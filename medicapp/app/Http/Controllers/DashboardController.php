<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Recordatorio;
use App\Models\TratamientoMedicamento;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        /** @var \App\Models\Usuario $usuario */
        $usuario = Auth::user();
        $usuario->load('perfiles');

        $idPerfilSeleccionado = $request->input('perfil');
        if ($idPerfilSeleccionado && $usuario->perfiles->contains('id_perfil', $idPerfilSeleccionado)) {
            session(['perfil_activo_id' => $idPerfilSeleccionado]);
        }

        $perfilActivo = $usuario->perfilActivo;

        $tratamientos = $perfilActivo
            ? $perfilActivo->tratamientos()->with([
                'medicaciones' => function ($q) {
                    $q->where('estado', 'activo')->with('medicamento');
                }
            ])->get()
            : collect();

        if ($tratamientos->isNotEmpty()) {
            foreach ($tratamientos as $tratamiento) {
                foreach ($tratamiento->medicaciones as $medicacion) {
                    if ($medicacion->estado !== 'activo') continue; 
                    if (!$medicacion->fecha_hora_inicio) continue;

                    $unidad = match ($medicacion->pauta_unidad) {
                        'horas'   => 'hours',
                        'dias'    => 'days',
                        'semanas' => 'weeks',
                        'meses'   => 'months',
                        default   => 'hours',
                    };

                    $intervalo = (int) $medicacion->pauta_intervalo;
                    $inicio = Carbon::parse($medicacion->fecha_hora_inicio)->copy();
                    $ahora  = Carbon::now();
                    $fin    = $ahora->copy()->addHours(48);

                    while ($inicio->lt($ahora)) {
                        $inicio->add($unidad, $intervalo);
                    }

                    while ($inicio->lte($fin)) {
                        $yaExiste = Recordatorio::where('id_trat_med', $medicacion->id_trat_med)
                            ->where('fecha_hora', $inicio)
                            ->exists();

                        if (!$yaExiste) {
                            Recordatorio::create([
                                'id_trat_med' => $medicacion->id_trat_med,
                                'fecha_hora'  => $inicio->copy(),
                                'tomado'      => false,
                            ]);
                        }

                        $inicio->add($unidad, $intervalo);
                    }
                }
            }

            Recordatorio::where('tomado', true)
                ->where('fecha_hora', '<', now()->subDays(3))
                ->delete();
        }

        $recordatorios = collect();
        if ($perfilActivo) {
            $tratMedIds = $tratamientos
                ->flatMap(fn($t) => $t->medicaciones->pluck('id_trat_med')) 
                ->unique();

            $recordatorios = Recordatorio::with('tratamientoMedicamento.medicamento')
                ->whereIn('id_trat_med', $tratMedIds)
                ->whereDate('fecha_hora', Carbon::today())
                ->where('tomado', false)
                ->whereHas('tratamientoMedicamento', function ($q) {
                    $q->where('estado', 'activo');
                })
                ->orderBy('fecha_hora')
                ->get();
        }

        $citas = $perfilActivo
            ? $perfilActivo->citas()
                ->whereDate('fecha', '>=', Carbon::today())
                ->orderBy('fecha')
                ->orderBy('hora_inicio')
                ->get()
            : collect();

        $perfilesUsuario = $usuario->perfiles;

        return view('dashboard', compact(
            'perfilActivo',
            'tratamientos',
            'citas',
            'perfilesUsuario',
            'recordatorios'
        ));
    }
}
