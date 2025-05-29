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
            'causa' => 'required|string|max:150',
        ]);

        $tratamiento = Tratamiento::create([
            'id_perfil' => $perfilActivo->id_perfil,
            'causa' => $request->causa,
            'fecha_inicio' => now(),
        ]);

        return redirect()->route('medicacion.create', $tratamiento->id_tratamiento);
    }
}
