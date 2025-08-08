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
        $usuario = Auth::user();
        $usuario->load('perfiles');

        return view('perfil.index', [
            'perfilActivo' => $usuario->perfilActivo,
            'usuario' => $usuario
        ]);
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

        // Verifica que el usuario tenga acceso a este perfil
        if (!$usuario->perfiles->contains('id_perfil', $perfil->id_perfil)) {
            return redirect()->route('perfil.index')->withErrors(['No tienes permiso para eliminar este perfil.']);
        }

        if (session('perfil_activo_id') == $perfil->id_perfil) {
            session()->forget('perfil_activo_id');
        }

        // Eliminar citas asociadas
        $perfil->citas()->delete();

        // Eliminar tratamientos y sus medicamentos y recordatorios
        foreach ($perfil->tratamientos as $tratamiento) {
            foreach ($tratamiento->medicaciones as $medicacion) {
                $medicacion->recordatorios()->delete();
                $medicacion->delete();
            }
            $tratamiento->delete();
        }

        // Eliminar otras relaciones (notificaciones, informes si los tienes)
        $perfil->notificaciones()->delete();
        $perfil->informes()->delete();

        // Eliminar la relación del usuario con este perfil
        $usuario->perfiles()->detach($perfil->id_perfil);

        // Finalmente, eliminar el perfil
        $perfil->delete();

        return redirect()->route('perfil.index')->with('success', 'Perfil eliminado correctamente.');
    }
}