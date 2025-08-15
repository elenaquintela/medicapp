<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use App\Models\PerfilInvitacion;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Mostrar la vista de registro.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Registrar nuevo usuario.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:60'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . Usuario::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = Usuario::create([
            'nombre'     => $request->name,
            'email'      => $request->email,
            'contrasena' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);
        $request->session()->regenerate();

        if ($token = session('pending_invitation_token')) {
            $request->session()->forget(['pending_invitation_token', 'invited_email']);

            $inv = PerfilInvitacion::where('token', $token)->first();

            if ($inv && $inv->estado === 'pendiente' && ! $inv->isExpired()) {
                if (strcasecmp($user->email, $inv->email) === 0) {
                    $yaMiembro = $inv->perfil->usuarios()
                        ->where('usuario.id_usuario', $user->id_usuario)
                        ->exists();

                    if (! $yaMiembro) {
                        $inv->perfil->usuarios()->attach($user->id_usuario, [
                            'rol_en_perfil' => 'invitado',
                            'estado'        => 'aceptada',
                            'fecha_inv'     => now(),
                        ]);
                    }

                    $inv->update([
                        'estado'              => 'aceptada',
                        'accepted_at'         => now(),
                        'id_usuario_invitado' => $user->id_usuario,
                    ]);

                    session(['perfil_activo_id' => $inv->id_perfil]);

                    return redirect()->route('dashboard')->with('success', 'Invitación aceptada. Bienvenido/a.');
                }
            }
        }

        return redirect()->route($this->nextRouteFor($user));
    }


    /**
     * Lógica de onboarding
     */
    private function nextRouteFor($user): string
    {
        if (empty($user->rol_global) || !in_array($user->rol_global, ['estandar', 'premium'])) {
            return 'planes.show'; 
        }

        if (!$user->perfiles()->exists()) {
            return 'perfil.create';
        }

        $perfil = $user->perfiles()->first();
        $trat   = $perfil->tratamientos()->latest()->first();

        if (!$trat) {
            return 'perfil.create';
        }

        if (method_exists($trat, 'medicaciones') && !$trat->medicaciones()->exists()) {
            return 'medicacion.create';
        }

        return 'dashboard';
    }
}
