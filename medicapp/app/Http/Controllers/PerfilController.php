<?php

namespace App\Http\Controllers;

use App\Models\Perfil;
use App\Models\Tratamiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerfilController extends Controller
{
    public function create(Request $request)
    {
        $layout = $request->boolean('fromDashboard') ? 'layouts.auth' : 'layouts.registro';
        return view('perfil.create', compact('layout'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'nombre_paciente' => 'required|string|max:80',
            'fecha_nacimiento' => 'required|date|before_or_equal:today|after:1900-01-01',
            'sexo' => 'required|in:F,M,NB,O',
            'causa' => 'required|string|max:150',
        ]);


        // 1. Crear el perfil
        $perfil = Perfil::create([
            'nombre_paciente' => $request->nombre_paciente,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'sexo' => $request->sexo,
        ]);

        // 2. Asociar el perfil al usuario como "creador"
        $usuario = Auth::user();
        /** @var \App\Models\Usuario $usuario */
        $usuario->perfiles()->attach($perfil->id_perfil, [
            'rol_en_perfil' => 'creador',
            'estado' => 'aceptada'
        ]);

        // 3. Crear el tratamiento con la causa inicial
        $tratamiento = Tratamiento::create([
            'id_perfil' => $perfil->id_perfil,
            'causa' => $request->causa,
            'fecha_inicio' => now(),
        ]);

        // 4. Redirigir a la siguiente vista
        return redirect()->route('medicacion.create', $tratamiento->id_tratamiento)
            ->with('success', 'Perfil y tratamiento creados correctamente');
    }
}
