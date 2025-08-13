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

        // === ACEPTACIÓN AUTOMÁTICA DE INVITACIÓN (si venimos de un enlace) ===
        if ($token = session('pending_invitation_token')) {
            // limpiamos la sesión pase lo que pase
            $request->session()->forget(['pending_invitation_token', 'invited_email']);

            $inv = PerfilInvitacion::where('token', $token)->first();

            if ($inv && $inv->estado === 'pendiente' && ! $inv->isExpired()) {
                // seguridad: el email registrado debe coincidir con el de la invitación
                if (strcasecmp($user->email, $inv->email) === 0) {
                    // ¿ya es miembro?
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

                    // marcar invitación como aceptada
                    $inv->update([
                        'estado'              => 'aceptada',
                        'accepted_at'         => now(),
                        'id_usuario_invitado' => $user->id_usuario,
                    ]);

                    // activar ese perfil y enviar a dashboard (tal y como pediste)
                    session(['perfil_activo_id' => $inv->id_perfil]);

                    return redirect()->route('dashboard')->with('success', 'Invitación aceptada. Bienvenido/a.');
                }
                // si el email no coincide, ignoramos la invitación y seguimos flujo normal
            }
            // si no es válida o está expirada, seguimos flujo normal
        }

        // Si no hay invitación pendiente, seguimos tu onboarding normal
        return redirect()->route($this->nextRouteFor($user));
    }


    /**
     * Lógica de onboarding (igual que en AuthenticatedSessionController).
     * Ajusta los nombres de rutas/relaciones si difieren en tu app.
     */
    private function nextRouteFor($user): string
    {
        // 1) Elegir plan
        if (empty($user->rol_global) || !in_array($user->rol_global, ['standard', 'estandar', 'premium'])) {
            return 'planes.show'; // ruta de la vista de planes
        }

        // 2) Crear primer perfil
        if (!$user->perfiles()->exists()) {
            return 'perfil.create';
        }

        // 3) Primer tratamiento (si lo creas dentro de perfil.store, puedes omitir este chequeo)
        $perfil = $user->perfiles()->first();
        $trat   = $perfil->tratamientos()->latest()->first();
        if (!$trat) {
            // Si tu UX crea tratamiento junto con el perfil, elimina este return.
            // O usa la ruta específica para crear tratamiento si la tienes.
            return 'perfil.create';
        }

        // 4) Primera medicación
        if (method_exists($trat, 'medicaciones') && !$trat->medicaciones()->exists()) {
            return 'medicacion.create';
        }

        // 5) Todo listo → dashboard
        return 'dashboard';
    }
}
