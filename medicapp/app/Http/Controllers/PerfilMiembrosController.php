<?php

namespace App\Http\Controllers;

use App\Models\Perfil;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerfilMiembrosController extends Controller
{
    public function store(Request $request, Perfil $perfil)
    {
        $request->validate([
            'email' => ['required','email'],
        ]);

        /** @var \App\Models\Usuario $owner */
        $owner = Auth::user();

        if ($owner->rol_global !== 'premium') {
            abort(403, 'Solo los usuarios premium pueden invitar.');
        }

        $esPropietario = $owner->perfiles()
            ->wherePivot('rol_en_perfil', 'creador')
            ->where('perfil.id_perfil', $perfil->id_perfil)
            ->exists();

        if (! $esPropietario) {
            abort(403, 'No eres el propietario de este perfil.');
        }

        $invitado = Usuario::where('email', $request->email)->first();

        if (! $invitado) {
            return back()->withErrors([
                'email' => 'No existe ningún usuario registrado con ese email. (En la siguiente iteración activaremos la invitación por correo para usuarios sin cuenta.)'
            ])->withInput();
        }

        if ($invitado->id_usuario === $owner->id_usuario) {
            return back()->withErrors(['email' => 'No puedes invitarte a ti mismo.'])->withInput();
        }

        $yaEsMiembro = $perfil->usuarios()
            ->where('usuario.id_usuario', $invitado->id_usuario)
            ->exists();

        if ($yaEsMiembro) {
            return back()->with('success', 'Ese usuario ya tiene acceso a este perfil.');
        }

        $perfil->usuarios()->attach($invitado->id_usuario, [
            'rol_en_perfil' => 'invitado',
            'estado'        => 'aceptada',
            'fecha_inv'     => now(),
        ]);

        return back()->with('success', 'Invitación concedida. El usuario ya puede gestionar este perfil.');
    }

    public function destroy(Perfil $perfil, Usuario $usuario)
    {
        /** @var \App\Models\Usuario $owner */
        $owner = Auth::user();

        if ($owner->rol_global !== 'premium') {
            abort(403, 'Solo los usuarios premium pueden quitar acceso.');
        }

        $esPropietario = $owner->perfiles()
            ->wherePivot('rol_en_perfil', 'creador')
            ->where('perfil.id_perfil', $perfil->id_perfil)
            ->exists();

        if (! $esPropietario) {
            abort(403, 'No eres el propietario de este perfil.');
        }

        if ($usuario->id_usuario === $owner->id_usuario) {
            return back()->withErrors(['miembro' => 'No puedes quitarte a ti mismo como propietario.']);
        }

        $perfil->usuarios()->detach($usuario->id_usuario);

        return back()->with('success', 'Acceso retirado correctamente.');
    }
}
