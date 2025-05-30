<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CitaController extends Controller
{
    public function index()
    {
        /** @var \App\Models\Usuario $user */
        $user = Auth::user();
        $user->load('perfiles');

        $perfilActivo = $user->perfilActivo;

        if (!$perfilActivo) {
            return redirect()->route('dashboard')->withErrors(['Debes seleccionar un perfil antes de ver las citas.']);
        }

        $citas = Cita::where('id_perfil', $perfilActivo->id_perfil)
            ->orderBy('fecha', 'asc')
            ->orderBy('hora_inicio', 'asc')
            ->get();

        return view('cita.index', [
            'perfilesUsuario' => $user->perfiles,
            'perfilActivo' => $perfilActivo,
            'citas' => $citas
        ]);
    }

    public function create()
    {
        /** @var \App\Models\Usuario $user */
        $user = Auth::user();
        $user->load('perfiles');

        $perfilActivo = $user->perfilActivo;

        if (!$perfilActivo) {
            return redirect()->route('dashboard')->withErrors(['Debes seleccionar un perfil antes de crear una cita.']);
        }

        $especialidades = [
            'Medicina de familia',
            'Pediatría',
            'Cardiología',
            'Dermatología',
            'Ginecología',
            'Oftalmología',
            'Traumatología',
            'Neurología',
            'Psiquiatría',
            'Otorrinolaringología',
            'Urología',
            'Rehabilitación',
            'Alergología',
            'Endocrinología',
            'Digestivo',
            'Neumología',
            'Oncología',
        ];

        return view('cita.create', [
            'perfilesUsuario' => $user->perfiles,
            'perfilActivo' => $perfilActivo,
            'especialidades' => $especialidades,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'hora_inicio' => 'required',
            'hora_fin' => 'nullable',
            'motivo' => 'required|string|max:150',
            'ubicacion' => 'required|string|max:120',
            'especialidad' => 'nullable|string|max:80',
            'recordatorio' => 'nullable|boolean',
            'observaciones' => 'nullable|string'
        ]);

        /** @var \App\Models\Usuario $user */
        $user = Auth::user();
        $user->load('perfiles');

        $perfilActivo = $user->perfilActivo;

        if (!$perfilActivo) {
            return redirect()->back()->withErrors(['No hay perfil activo seleccionado.']);
        }

        $cita = new Cita();

        $cita->id_perfil = $perfilActivo->id_perfil;
        $cita->id_usuario_crea = $user->id_usuario;
        $cita->fecha = $request->fecha;
        $cita->hora_inicio = $request->hora_inicio;
        $cita->hora_fin = $request->hora_fin;
        $cita->motivo = $request->motivo;
        $cita->ubicacion = $request->ubicacion;
        $cita->especialidad = $request->especialidad === 'otra'
            ? $request->especialidad_otra
            : $request->especialidad;
        $cita->recordatorio = $request->has('recordatorio') ? 1 : 0;
        $cita->observaciones = $request->observaciones ?? null;
        $cita->save();

        return redirect()->route('cita.index');
    }

    public function edit(Cita $cita)
    {
        /** @var \App\Models\Usuario $user */
        $user = Auth::user();
        $user->load('perfiles');

        $perfilActivo = $user->perfilActivo;

        if (!$perfilActivo || $cita->id_perfil !== $perfilActivo->id_perfil) {
            return redirect()->route('cita.index')->withErrors(['No tienes permiso para editar esta cita.']);
        }

        $especialidades = [
            'Medicina de familia',
            'Pediatría',
            'Cardiología',
            'Dermatología',
            'Ginecología',
            'Oftalmología',
            'Traumatología',
            'Neurología',
            'Psiquiatría',
            'Otorrinolaringología',
            'Urología',
            'Rehabilitación',
            'Alergología',
            'Endocrinología',
            'Digestivo',
            'Neumología',
            'Oncología',
        ];

        return view('cita.edit', [
            'perfilesUsuario' => $user->perfiles,
            'perfilActivo' => $perfilActivo,
            'cita' => $cita,
            'especialidades' => $especialidades,
        ]);
    }


    public function update(Request $request, Cita $cita)
    {
        $request->validate([
            'fecha' => 'required|date',
            'hora_inicio' => 'required',
            'hora_fin' => 'nullable',
            'motivo' => 'required|string|max:150',
            'ubicacion' => 'required|string|max:120',
            'especialidad' => 'nullable|string|max:80',
            'recordatorio' => 'nullable|boolean',
            'observaciones' => 'nullable|string'
        ]);

        /** @var \App\Models\Usuario $user */
        $user = Auth::user();
        $perfilActivo = $user->perfilActivo;

        if (!$perfilActivo || $cita->id_perfil !== $perfilActivo->id_perfil) {
            return redirect()->route('cita.index')->withErrors(['No tienes permiso para actualizar esta cita.']);
        }

        $especialidad = $request->especialidad === 'otra'
            ? $request->especialidad_otra
            : $request->especialidad;

        $cita->update([
            'fecha' => $request->fecha,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
            'motivo' => $request->motivo,
            'ubicacion' => $request->ubicacion,
            'especialidad' => $especialidad,
            'recordatorio' => $request->has('recordatorio') ? 1 : 0,
            'observaciones' => $request->observaciones
        ]);

        return redirect()->route('cita.index');
    }
}
