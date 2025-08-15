<?php

namespace App\Http\Controllers;

use App\Models\Perfil;
use App\Models\Tratamiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PerfilInvitacion;


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

        $perfil = Perfil::create([
            'nombre_paciente' => $request->nombre_paciente,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'sexo' => $request->sexo,
        ]);

        /** @var \App\Models\Usuario $usuario */
        $usuario = Auth::user();
        $usuario->perfiles()->attach($perfil->id_perfil, [
            'rol_en_perfil' => 'creador',
            'estado' => 'aceptada'
        ]);

        session(['perfil_activo_id' => $perfil->id_perfil]);

        $tratamiento = Tratamiento::create([
            'id_perfil' => $perfil->id_perfil,
            'id_usuario_creador' => $usuario->id_usuario,
            'causa' => $request->causa,
            'fecha_inicio' => now(),
            'estado' => 'activo',
        ]);

        return redirect()->route('medicacion.create', ['tratamiento' => $tratamiento->id_tratamiento])
            ->with('success', 'Perfil y tratamiento creados correctamente');
    }

    public function index()
    {
        /** @var \App\Models\Usuario $usuario */
        $usuario   = Auth::user();
        $perfiles  = $usuario->perfiles()->latest('id_perfil')->get();

        $perfilActivo = null;
        if ($id = session('perfil_activo_id')) {
            $perfilActivo = $perfiles->firstWhere('id_perfil', $id);
        }
        if (!$perfilActivo && $perfiles->count()) {
            $perfilActivo = $perfiles->first();
            session(['perfil_activo_id' => $perfilActivo->id_perfil]);
        }
        if (!$perfiles->count()) {
            session()->forget('perfil_activo_id');
        }

        $esPremium     = $usuario->rol_global === 'premium';
        $esPropietario = false;
        $invitados     = collect();
        $creador       = null;
        $pendientes    = collect();

        if ($perfilActivo) {
            $esPropietario = $usuario->perfiles()
                ->wherePivot('rol_en_perfil', 'creador')
                ->where('perfil.id_perfil', $perfilActivo->id_perfil)
                ->exists();

            $invitados = $perfilActivo->usuarios()
                ->wherePivot('rol_en_perfil', 'invitado')
                ->get();

            $creador = $perfilActivo->usuarios()
                ->wherePivot('rol_en_perfil', 'creador')
                ->first();

            $pendientes = PerfilInvitacion::where('id_perfil', $perfilActivo->id_perfil)
                ->where('estado', 'pendiente')
                ->get();
        }

        return view('perfil.index', compact(
            'usuario',
            'perfiles',
            'perfilActivo',
            'esPremium',
            'esPropietario',
            'invitados',
            'creador',
            'pendientes',
        ));
    }

    public function update(Request $request, Perfil $perfil)
    {
        $request->validate([
            'nombre_paciente' => 'required|string|max:80',
            'fecha_nacimiento' => 'required|date|before_or_equal:today|after:1900-01-01',
            'sexo' => 'required|in:F,M,NB,O',
        ]);

        $perfil->update([
            'nombre_paciente' => $request->nombre_paciente,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'sexo' => $request->sexo,
        ]);

        return redirect()->route('perfil.index')->with('success', 'Perfil actualizado correctamente.');
    }

    public function destroy(Perfil $perfil)
    {
        /** @var \App\Models\Usuario $usuario */
        $usuario = Auth::user();

        if (!$usuario->perfiles->contains('id_perfil', $perfil->id_perfil)) {
            return redirect()->route('perfil.index')->withErrors(['No tienes permiso para eliminar este perfil.']);
        }
        $eraActivo = session('perfil_activo_id') == $perfil->id_perfil;

        if ($eraActivo) {
            session()->forget('perfil_activo_id');
        }

        $perfil->citas()->delete();

        foreach ($perfil->tratamientos as $tratamiento) {
            foreach ($tratamiento->medicaciones as $medicacion) {
                $medicacion->recordatorios()->delete();
                $medicacion->delete();
            }
            $tratamiento->delete();
        }

        $perfil->notificaciones()->delete();
        $perfil->informes()->delete();
        $usuario->perfiles()->detach($perfil->id_perfil);
        $perfil->delete();

        if ($eraActivo) {
            $nuevo = $usuario->perfiles()->latest('id_perfil')->first();
            if ($nuevo) {
                session(['perfil_activo_id' => $nuevo->id_perfil]);
            } else {
                session()->forget('perfil_activo_id');
            }
        }

        return redirect()->route('perfil.index')->with('success', 'Perfil eliminado correctamente.');
    }
}
