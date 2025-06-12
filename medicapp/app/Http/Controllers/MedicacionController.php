<?php

namespace App\Http\Controllers;

use App\Models\Tratamiento;
use App\Models\TratamientoMedicamento;
use App\Models\Recordatorio;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
            'fecha_hora_inicio' => 'required|date',
            'pauta_intervalo' => 'required|integer|min:1',
            'pauta_unidad' => 'required|string',
            'observaciones' => 'nullable|string|max:255',
        ]);

        $medicamento = \App\Models\Medicamento::firstOrCreate(
            ['nombre' => $request->nombre],
            ['descripcion' => null, 'id_cima' => null]
        );

        $tratMed = TratamientoMedicamento::create([
            'id_tratamiento' => $tratamiento->id_tratamiento,
            'id_medicamento' => $medicamento->id_medicamento,
            'indicacion' => $request->indicacion,
            'presentacion' => $request->presentacion,
            'via' => $request->via,
            'dosis' => $request->dosis,
            'fecha_hora_inicio' => $request->fecha_hora_inicio,
            'pauta_intervalo' => $request->pauta_intervalo,
            'pauta_unidad' => $request->pauta_unidad,
            'observaciones' => $request->observaciones,
            'estado' => 'activo',
        ]);

        // Generar recordatorios solo para las tomas futuras (próximas 48h)
        $unidadCarbon = match ($request->pauta_unidad) {
            'horas' => 'hours',
            'dias' => 'days',
            'semanas' => 'weeks',
            'meses' => 'months',
            default => 'hours',
        };

        $intervalo = (int) $request->pauta_intervalo;
        $inicio = Carbon::parse($request->fecha_hora_inicio);
        $ahora = now();
        $limite = $ahora->copy()->addHours(48);
        $actual = $inicio->copy();

        while ($actual->lte($limite)) {
            if ($actual->gte($ahora)) {
                Recordatorio::create([
                    'id_trat_med' => $tratMed->id_trat_med,
                    'fecha_hora' => $actual,
                    'tomado' => false,
                ]);
            }
            $actual->add($unidadCarbon, $intervalo);
        }

        if ($request->accion === 'add') {
            return redirect()->route('medicacion.create', $tratamiento->id_tratamiento)
                ->with('success', 'Medicación añadida correctamente');
        }

        if ($request->accion === 'done') {
            $usuario = Auth::user();
            if ($usuario->rol_global && $tratamiento->id_perfil) {
                return redirect()->route('dashboard', ['perfil' => $tratamiento->id_perfil])
                    ->with('success', 'Tratamiento y medicación añadidos correctamente');
            }
            return redirect()->route('planes.show')
                ->with('success', 'Tratamiento y medicación registrados con éxito');
        }

        return back()->withErrors(['accion' => 'Acción no reconocida.']);
    }
}
