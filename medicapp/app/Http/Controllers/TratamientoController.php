<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tratamiento;

class TratamientoController extends Controller
{
    public function create()
    {
        /** @var \App\Models\Usuario $usuario */
        $usuario = Auth::user();
        $usuario->load('perfiles');

        $perfilActivo = $usuario->perfilActivo;

        if (!$perfilActivo) {
            return redirect()->route('dashboard')->withErrors(['perfil' => 'No hay perfil activo.']);
        }

        return view('tratamiento.create', [
            'perfilActivo' => $perfilActivo
        ]);
    }

    public function store(Request $request)
    {
        /** @var \App\Models\Usuario $usuario */
        $usuario = Auth::user();
        $usuario->load('perfiles');

        $perfilActivo = $usuario->perfilActivo;

        if (!$perfilActivo) {
            return redirect()->route('dashboard')->withErrors(['perfil' => 'No hay perfil activo.']);
        }

        $request->validate([
            'causa' => [
                'required',
                'string',
                'max:150',
                function ($attribute, $value, $fail) use ($perfilActivo) {
                    $existe = Tratamiento::where('id_perfil', $perfilActivo->id_perfil)
                        ->where('causa', $value)
                        ->exists();

                    if ($existe) {
                        $fail('Este perfil ya tiene un tratamiento con la causa "' . $value . '". Usa otro nombre.');
                    }
                }
            ],
        ]);

        $tratamiento = Tratamiento::create([
            'id_perfil' => $perfilActivo->id_perfil,
            'id_usuario_creador' => $usuario->id_usuario,
            'causa' => $request->causa,
            'fecha_inicio' => now(),
            'estado' => 'activo',
        ]);

        $params = ['tratamiento' => $tratamiento->id_tratamiento];
        if ($request->has('volver_a_index')) {
            $params['volver_a_index'] = 1;
        }

        return redirect()->route('medicacion.create', $params);
    }

    public function index()
    {
        // Versión minimal para debug
        $tratamientos = collect();
        return view('tratamiento.index', compact('tratamientos'));
    }

    public function show(Tratamiento $tratamiento)
    {
        $tratamiento->load('medicaciones.medicamento');
        return view('tratamiento.show', compact('tratamiento'));
    }

    public function archivar(\App\Models\Tratamiento $tratamiento)
    {
        $usuario = Auth::user();
        $perfilActivo = $usuario->perfilActivo;
        if (!$perfilActivo || $tratamiento->id_perfil !== $perfilActivo->id_perfil) {
            return back()->withErrors(['No tienes permiso para archivar este tratamiento.']);
        }
        $tratamiento->estado = 'archivado';
        $tratamiento->save();
        return back()->with('success', 'Tratamiento archivado.');
    }

    public function reactivar($id)
    {
        $tratamiento = Tratamiento::findOrFail($id);
        $tratamiento->estado = 'activo';
        $tratamiento->save();

        return redirect()->route('tratamiento.index')->with('success', 'Tratamiento reactivado correctamente.');
    }

    public function destroy(\App\Models\Tratamiento $tratamiento)
    {
        $usuario = Auth::user();
        $perfilActivo = $usuario->perfilActivo;
        if (!$perfilActivo || $tratamiento->id_perfil !== $perfilActivo->id_perfil) {
            return back()->withErrors(['No tienes permiso para eliminar este tratamiento.']);
        }
        if ($tratamiento->estado !== 'archivado') {
            return back()->withErrors(['Solo puedes eliminar tratamientos archivados.']);
        }
        $tratamiento->delete();
        return back()->with('success', 'Tratamiento eliminado.');
    }
}
