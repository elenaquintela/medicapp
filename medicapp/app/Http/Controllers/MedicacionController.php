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
        /** @var \App\Models\Usuario $usuario */
        $usuario = Auth::user();
        $usuario->load('perfiles');
        $perfilActivo = $usuario->perfilActivo;

        if (!$perfilActivo || $tratamiento->id_perfil !== $perfilActivo->id_perfil) {
            return redirect()->route('dashboard')->withErrors(['No tienes permiso para acceder a esta medicación.']);
        }

        return view('medicacion.create', compact('tratamiento'));
    }

    public function store(Request $request, Tratamiento $tratamiento)
    {
        /** @var \App\Models\Usuario $usuario */
        $usuario = Auth::user();
        $usuario->load('perfiles');
        $perfilActivo = $usuario->perfilActivo;

        if (!$perfilActivo || $tratamiento->id_perfil !== $perfilActivo->id_perfil) {
            return redirect()->route('dashboard')->withErrors(['No tienes permiso para añadir medicación a este tratamiento.']);
        }

        $request->validate([
            'nombre' => 'required|string|max:120',
            'presentacion' => 'required|in:comprimidos,jarabe,gotas,inyeccion,pomada,parche,polvo,spray,otro',
            'via' => 'required|in:oral,topica,nasal,ocular,otica,intravenosa,intramuscular,subcutanea,rectal,inhalatoria,otro',
            'dosis' => 'required|string|max:50',
            'fecha_hora_inicio' => 'required|date',
            'pauta_intervalo' => 'required|integer|min:1',
            'pauta_unidad' => 'required|in:horas,dias,semanas,meses',
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

        // Generar recordatorios (desde inicio de hoy hasta +48h), normalizando unidad y TZ
        $unidadRaw = mb_strtolower($request->pauta_unidad, 'UTF-8');
        $unidadRaw = str_replace(['día', 'días'], ['dia', 'dias'], $unidadRaw); // quitar acento si llega
        $intervalo = (int) $request->pauta_intervalo;

        // datetime-local no trae TZ -> parsea en la TZ de la app
        $inicioOriginal = Carbon::parse($request->fecha_hora_inicio, config('app.timezone'));
        $inicioDia      = now()->copy()->startOfDay();
        $finVentana     = now()->copy()->addHours(48);

        // Cursor: primera ocurrencia >= inicio del día (para NO perder recordatorios de esta mañana)
        $cursor = $inicioOriginal->copy();
        while ($cursor->lt($inicioDia)) {
            switch ($unidadRaw) {
                case 'horas':
                    $cursor->addHours($intervalo);
                    break;
                case 'dias':
                    $cursor->addDays($intervalo);
                    break;
                case 'semanas':
                    $cursor->addWeeks($intervalo);
                    break;
                case 'meses':
                    $cursor->addMonths($intervalo);
                    break;
                default:
                    $cursor->addHours($intervalo);
                    break;
            }
        }

        // Crear recordatorios desde el inicio del día hasta +48h (incluye “atrasados” de hoy)
        while ($cursor->lte($finVentana)) {
            Recordatorio::firstOrCreate(
                [
                    'id_trat_med' => $tratMed->id_trat_med,
                    'fecha_hora'  => $cursor->toDateTimeString(), // igualdad exacta
                ],
                ['tomado' => false]
            );

            switch ($unidadRaw) {
                case 'horas':
                    $cursor->addHours($intervalo);
                    break;
                case 'dias':
                    $cursor->addDays($intervalo);
                    break;
                case 'semanas':
                    $cursor->addWeeks($intervalo);
                    break;
                case 'meses':
                    $cursor->addMonths($intervalo);
                    break;
                default:
                    $cursor->addHours($intervalo);
                    break;
            }
        }


        // Redirecciones según el botón
        if ($request->has('volver_a_show')) {
            return redirect()->route('tratamiento.show', $tratamiento->id_tratamiento)
                ->with('success', 'Medicación añadida correctamente.');
        }

        if ($request->accion === 'add') {
            return redirect()->route('medicacion.create', $tratamiento->id_tratamiento)
                ->with('success', 'Medicación añadida correctamente');
        }

        if ($request->accion === 'done') {
            if ($request->has('volver_a_index')) {
                return redirect()->route('tratamiento.index')
                    ->with('success', 'Tratamiento y medicación registrados correctamente.');
            }

            if ($usuario->rol_global && $tratamiento->id_perfil) {
                return redirect()->route('dashboard', ['perfil' => $tratamiento->id_perfil])
                    ->with('success', 'Tratamiento y medicación añadidos correctamente');
            }

            return redirect()->route('planes.show')
                ->with('success', 'Tratamiento y medicación registrados con éxito');
        }

        return back()->withErrors(['accion' => 'Acción no reconocida.']);
    }

    public function edit($id)
    {
        /** @var \App\Models\Usuario $usuario */
        $usuario = Auth::user();
        $usuario->load('perfiles');
        $perfilActivo = $usuario->perfilActivo;

        $medicacion = TratamientoMedicamento::with('medicamento')->findOrFail($id);
        $tratamiento = $medicacion->tratamiento;

        if (!$perfilActivo || $tratamiento->id_perfil !== $perfilActivo->id_perfil) {
            return redirect()->route('dashboard')->withErrors(['No tienes permiso para editar esta medicación.']);
        }

        return view('medicacion.create', compact('medicacion', 'tratamiento'));
    }

    public function update(Request $request, $id)
    {
        /** @var \App\Models\Usuario $usuario */
        $usuario = Auth::user();
        $usuario->load('perfiles');
        $perfilActivo = $usuario->perfilActivo;

        $medicacion = TratamientoMedicamento::findOrFail($id);
        $tratamiento = $medicacion->tratamiento;

        if (!$perfilActivo || $tratamiento->id_perfil !== $perfilActivo->id_perfil) {
            return redirect()->route('dashboard')->withErrors(['No tienes permiso para actualizar esta medicación.']);
        }

        $request->validate([
            'nombre' => 'required|string|max:120',
            'indicacion' => 'required|string|max:120',
            'presentacion' => 'required|in:comprimidos,jarabe,gotas,inyeccion,pomada,parche,polvo,spray,otro',
            'via' => 'required|in:oral,topica,nasal,ocular,otica,intravenosa,intramuscular,subcutanea,rectal,inhalatoria,otro',
            'dosis' => 'required|string|max:50',
            'fecha_hora_inicio' => 'required|date',
            'pauta_intervalo' => 'required|integer|min:1',
            'pauta_unidad' => 'required|in:horas,dias,semanas,meses',
            'observaciones' => 'nullable|string|max:255',
        ]);

        $medicamento = \App\Models\Medicamento::firstOrCreate(
            ['nombre' => $request->nombre],
            ['descripcion' => null, 'id_cima' => null]
        );

        $medicacion->update([
            'id_medicamento' => $medicamento->id_medicamento,
            'indicacion' => $request->indicacion,
            'presentacion' => $request->presentacion,
            'via' => $request->via,
            'dosis' => $request->dosis,
            'fecha_hora_inicio' => $request->fecha_hora_inicio,
            'pauta_intervalo' => $request->pauta_intervalo,
            'pauta_unidad' => $request->pauta_unidad,
            'observaciones' => $request->observaciones,
        ]);

        return redirect()->route('tratamiento.show', $medicacion->id_tratamiento)
            ->with('success', 'Medicación actualizada correctamente.');
    }

    public function destroy($id)
    {
        /** @var \App\Models\Usuario $usuario */
        $usuario = Auth::user();
        $usuario->load('perfiles');

        $med = \App\Models\TratamientoMedicamento::findOrFail($id);
        $tratamiento = $med->tratamiento;

        // Solo permitir si pertenece al perfil activo del usuario
        $perfilActivo = $usuario->perfilActivo;
        if (!$perfilActivo || $tratamiento->id_perfil !== $perfilActivo->id_perfil) {
            return redirect()->route('dashboard')->withErrors(['No tienes permiso para eliminar esta medicación.']);
        }

        // Por seguridad, solo permitir borrar si está archivada
        if ($med->estado !== 'archivado') {
            return back()->withErrors(['Solo puedes eliminar medicaciones archivadas.']);
        }

        // Eliminar recordatorios asociados
        $med->recordatorios()->delete();

        $med->delete();

        return redirect()->route('tratamiento.show', $tratamiento->id_tratamiento)
            ->with('success', 'Medicación archivada eliminada correctamente.');
    }


    public function archivar($id)
    {
        /** @var \App\Models\Usuario $usuario */
        $usuario = Auth::user();
        $usuario->load('perfiles');
        $perfilActivo = $usuario->perfilActivo;

        $medicacion = TratamientoMedicamento::findOrFail($id);
        $tratamiento = $medicacion->tratamiento;

        if (!$perfilActivo || $tratamiento->id_perfil !== $perfilActivo->id_perfil) {
            return redirect()->route('dashboard')->withErrors(['No tienes permiso para archivar esta medicación.']);
        }

        $medicacion->estado = 'archivado';
        $medicacion->save();

        return redirect()->route('tratamiento.show', $medicacion->id_tratamiento)
            ->with('success', 'Medicación archivada correctamente.');
    }

    public function replaceForm(Tratamiento $tratamiento, TratamientoMedicamento $tratMed)
    {
        abort_if($tratMed->id_tratamiento !== $tratamiento->id_tratamiento, 404);

        return view('medicacion.replace', [
            'tratamiento' => $tratamiento,
            'original'    => $tratMed->load('medicamento'),
        ]);
    }

    public function replace(Request $request, Tratamiento $tratamiento, TratamientoMedicamento $tratMed)
    {
        abort_if($tratMed->id_tratamiento !== $tratamiento->id_tratamiento, 404);

        $request->validate([
            'nombre'           => 'required|string|max:120',
            'presentacion'     => 'required|in:comprimidos,jarabe,gotas,inyeccion,pomada,parche,polvo,spray,otro',
            'via'              => 'required|in:oral,topica,nasal,ocular,otica,intravenosa,intramuscular,subcutanea,rectal,inhalatoria,otro',
            'dosis'            => 'required|string|max:50',
            'pauta_intervalo'  => 'required|integer|min:1',
            'pauta_unidad'     => 'required|in:horas,dias,semanas,meses',
            'fecha_hora_inicio' => 'nullable|date',
            'observaciones'    => 'nullable|string|max:255',
        ]);

        $tratMed->sustituir($request->only([
            'nombre',
            'presentacion',
            'via',
            'dosis',
            'pauta_intervalo',
            'pauta_unidad',
            'fecha_hora_inicio',
            'observaciones'
        ]));

        return redirect()
            ->route('tratamiento.show', $tratamiento->id_tratamiento)
            ->with('success', 'Medicación sustituida correctamente.');
    }
}
