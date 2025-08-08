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

        // Cambiar de perfil si se indica por URL
        $idPerfilSeleccionado = $request->input('perfil');
        if ($idPerfilSeleccionado && $usuario->perfiles->contains('id_perfil', $idPerfilSeleccionado)) {
            session(['perfil_activo_id' => $idPerfilSeleccionado]);
        }

        // Obtener perfil activo
        $perfilActivo = $usuario->perfilActivo;

        // Tratamientos con medicaciones y medicamentos precargados
        $tratamientos = $perfilActivo
            ? $perfilActivo->tratamientos()->with('medicaciones.medicamento')->get()
            : collect();

        // Generar nuevos recordatorios para los próximos 48h
        if ($tratamientos->isNotEmpty()) {
            foreach ($tratamientos as $tratamiento) {
                foreach ($tratamiento->medicaciones as $medicacion) {
                    if (!$medicacion->fecha_hora_inicio) continue;

                    $unidad = match ($medicacion->pauta_unidad) {
                        'horas' => 'hours',
                        'dias' => 'days',
                        'semanas' => 'weeks',
                        'meses' => 'months',
                        default => 'hours',
                    };

                    $intervalo = (int) $medicacion->pauta_intervalo;
                    $inicio = Carbon::parse($medicacion->fecha_hora_inicio)->copy();
                    $ahora = Carbon::now();
                    $fin = $ahora->copy()->addHours(48);

                    // Calcular siguiente toma igual o posterior a ahora
                    while ($inicio->lt($ahora)) {
                        $inicio->add($unidad, $intervalo);
                    }

                    // Generar recordatorios hasta 48h desde ahora
                    while ($inicio->lte($fin)) {
                        $yaExiste = Recordatorio::where('id_trat_med', $medicacion->id_trat_med)
                            ->where('fecha_hora', $inicio)
                            ->exists();

                        if (!$yaExiste) {
                            Recordatorio::create([
                                'id_trat_med' => $medicacion->id_trat_med,
                                'fecha_hora' => $inicio->copy(),
                                'tomado' => false,
                            ]);
                        }

                        $inicio->add($unidad, $intervalo);
                    }
                }
            }

            // Eliminar recordatorios marcados como tomados hace más de 3 días
            Recordatorio::where('tomado', true)
                ->where('fecha_hora', '<', now()->subDays(3))
                ->delete();
        }

        // Recordatorios para hoy (entre 00:00 y 23:59)
        $recordatorios = collect();
        if ($perfilActivo) {
            $tratMedIds = $tratamientos
                ->flatMap(fn($t) => $t->medicaciones->pluck('id_trat_med'))
                ->unique();

            $recordatorios = Recordatorio::with('tratamientoMedicamento.medicamento')
                ->whereIn('id_trat_med', $tratMedIds)
                ->whereDate('fecha_hora', Carbon::today())
                ->where('tomado', false)
                ->orderBy('fecha_hora')
                ->get();
        }

        // Citas futuras (desde hoy)
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
