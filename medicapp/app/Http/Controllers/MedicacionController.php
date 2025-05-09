<?php

namespace App\Http\Controllers;

use App\Models\Tratamiento;
use App\Models\TratamientoMedicamento;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MedicacionController extends Controller
{
    public function create(Tratamiento $tratamiento)
    {
        return view('medicacion.create', compact('tratamiento'));
    }

    public function store(Request $request, Tratamiento $tratamiento)
    {
        $request->validate([
            'nombre' => 'required|string|max:120',
            'indicacion' => 'required|string|max:120',
            'presentacion' => 'required|string',
            'via' => 'required|string',
            'dosis' => 'required|string|max:50',
            'pauta_intervalo' => 'required|integer|min:1',
            'pauta_unidad' => 'required|string',
            'observaciones' => 'nullable|string|max:255',
        ]);

        // Buscar o crear el medicamento a partir del nombre introducido
        $medicamento = \App\Models\Medicamento::firstOrCreate(
            ['nombre' => $request->nombre],
            ['descripcion' => null, 'id_cima' => null]
        );

        // Crear el tratamiento-medicamento con el id del medicamento
        TratamientoMedicamento::create([
            'id_tratamiento' => $tratamiento->id_tratamiento,
            'id_medicamento' => $medicamento->id_medicamento,
            'indicacion' => $request->indicacion,
            'presentacion' => $request->presentacion,
            'via' => $request->via,
            'dosis' => $request->dosis,
            'pauta_intervalo' => $request->pauta_intervalo,
            'pauta_unidad' => $request->pauta_unidad,
            'observaciones' => $request->observaciones,
            'estado' => 'activo',
        ]);

        if ($request->accion === 'add') {
            return redirect()->route('medicacion.create', $tratamiento->id_tratamiento)
                ->with('success', 'Medicación añadida correctamente');
        }

        if ($request->accion === 'done') {
            $usuario = Auth::user();

            // Redirigir según si el usuario ya tiene plan
            if ($usuario->rol_global) {
                return redirect()->route('dashboard', ['perfil' => $tratamiento->id_perfil])
                    ->with('success', 'Tratamiento y medicación añadidos correctamente');
            } else {
                return redirect()->route('planes.show')
                    ->with('success', 'Tratamiento y medicación registrados con éxito');
            }
        }

        return back()->withErrors(['accion' => 'Acción no reconocida.']);
    }
}
