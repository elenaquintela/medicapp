<?php

namespace App\Http\Controllers;

use App\Models\Perfil;
use App\Models\Usuario;
use App\Models\PerfilInvitacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class PerfilInvitacionController extends Controller
{
    // Enviar invitación por email
    public function store(Request $request, Perfil $perfil)
    {
        $request->validate(['email' => ['required','email','max:255']]);

        /** @var \App\Models\Usuario $owner */
        $owner = Auth::user();
        if ($owner->rol_global !== 'premium') abort(403, 'Solo premium puede invitar.');

        $esPropietario = $owner->perfiles()
            ->wherePivot('rol_en_perfil', 'creador')
            ->where('perfil.id_perfil', $perfil->id_perfil)
            ->exists();
        if (! $esPropietario) abort(403, 'No eres el propietario del perfil.');

        // Evitar duplicados pendientes al mismo email y perfil
        $yaPendiente = PerfilInvitacion::where('id_perfil', $perfil->id_perfil)
            ->where('email', $request->email)
            ->where('estado', 'pendiente')
            ->exists();
        if ($yaPendiente) {
            return back()->with('success', 'Ya existe una invitación pendiente para ese correo.');
        }

        $token = Str::random(48);

        $inv = PerfilInvitacion::create([
            'id_perfil'            => $perfil->id_perfil,
            'id_usuario_invitador' => $owner->id_usuario,
            'email'                => $request->email,
            'token'                => $token,
            'estado'               => 'pendiente',
            'expires_at'           => now()->addDays(7),
        ]);

        // Enviar email
        $link = route('invitaciones.accept', $token);
        Mail::to($inv->email)->send(new \App\Mail\InvitacionPerfilMail($inv, $link));

        return back()->with('success', 'Invitación enviada por email.');
    }

    // Aceptar invitación (click desde email)
    public function accept(Request $request, string $token)
    {
        $inv = PerfilInvitacion::where('token', $token)->first();
        if (! $inv || $inv->estado !== 'pendiente' || $inv->isExpired()) {
            return redirect()->route('welcome')->withErrors(['invitacion' => 'Invitación no válida o expirada.']);
        }

        $usuario = Auth::user();

        // Si no autenticado → guardar token en sesión y mandar a login/registro según exista el email
        if (! $usuario) {
            $existe = Usuario::where('email', $inv->email)->exists();
            session(['pending_invitation_token' => $token, 'invited_email' => $inv->email]);
            return $existe
                ? redirect()->route('welcome')->with('info', 'Inicia sesión para aceptar la invitación.')
                : redirect()->route('register')->with('info', 'Crea tu cuenta para aceptar la invitación.')
                  ->withInput(['email' => $inv->email]);
        }

        // Autenticado: forzar que coincida el email del token por seguridad
        if (strcasecmp($usuario->email, $inv->email) !== 0) {
            return redirect()->route('welcome')->withErrors([
                'invitacion' => 'Estás autenticado como '.$usuario->email.'. Sal de la sesión e inicia con '.$inv->email.' para aceptar la invitación.'
            ]);
        }

        // Conceder acceso si no lo tenía
        $yaMiembro = $inv->perfil->usuarios()
            ->where('usuario.id_usuario', $usuario->id_usuario)->exists();

        if (! $yaMiembro) {
            $inv->perfil->usuarios()->attach($usuario->id_usuario, [
                'rol_en_perfil' => 'invitado',
                'estado'        => 'aceptada',
                'fecha_inv'     => now(),
            ]);
        }

        // Marcar invitación como aceptada
        $inv->update([
            'estado'             => 'aceptada',
            'accepted_at'        => now(),
            'id_usuario_invitado'=> $usuario->id_usuario,
        ]);

        // Opcional: activar ese perfil como activo
        session(['perfil_activo_id' => $inv->id_perfil]);

        return redirect()->route('dashboard')->with('success', 'Invitación aceptada. Ya puedes gestionar el perfil.');
    }
}
