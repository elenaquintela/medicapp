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

        // Si viene el campo oculto, se pasa el parámetro en la redirección
        $params = ['tratamiento' => $tratamiento->id_tratamiento];
        if ($request->has('volver_a_index')) {
            $params['volver_a_index'] = 1;
        }

        return redirect()->route('medicacion.create', $params);
    }

    public function index()
    {
        $usuario = Auth::user();
        $perfilActivo = $usuario->perfilActivo;

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
    }

    public function show(Tratamiento $tratamiento)
    {
        $tratamiento->load('medicaciones.medicamento');
        return view('tratamiento.show', compact('tratamiento'));
    }
}
