<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TratamientoController extends Controller
{
    public function create()
    {
        return view('tratamiento.create', [
            'id_perfil' => request('perfil')
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'id_perfil' => 'required|exists:perfil,id_perfil',
            'causa' => 'required|string|max:150',
        ]);

        $tratamiento = \App\Models\Tratamiento::create([
            'id_perfil' => $request->id_perfil,
            'causa' => $request->causa,
            'fecha_inicio' => now(),
        ]);

        return redirect()->route('medicacion.create', $tratamiento->id_tratamiento)
            ->with('success', 'Tratamiento creado correctamente');
    }
}
