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
        try {
            $usuario = Auth::user();
            
            // Debug: verificar si el usuario existe
            if (!$usuario) {
                return response('Usuario no autenticado', 500);
            }
            
            $perfilActivo = $usuario->perfilActivo;
            
            // Debug: verificar el perfil activo
            if (!$perfilActivo) {
                return response('No hay perfil activo - Session ID: ' . session('perfil_activo_id'), 500);
            }

            $tratamientos = collect();

            if ($perfilActivo) {
                $query = $perfilActivo->tratamientos()->with('usuarioCreador');

                if ($busqueda = request('busqueda')) {
                    $query->where(function ($q) use ($busqueda) {
                        $q->where('causa', 'like', "%{$busqueda}%")
                            ->orWhere('estado', 'like', "%{$busqueda}%")
                            ->orWhereDate('fecha_inicio', $busqueda)
                            ->orWhereHas('usuarioCreador', function ($subquery) use ($busqueda) {
                                $subquery->where('nombre', 'like', "%{$busqueda}%");
                            });
                    });
                }
                $tratamientos = $query->get();
            }
            return view('tratamiento.index', compact('tratamientos'));
        } catch (\Exception $e) {
            return response('Error: ' . $e->getMessage() . ' - Line: ' . $e->getLine() . ' - File: ' . $e->getFile(), 500);
        }
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
