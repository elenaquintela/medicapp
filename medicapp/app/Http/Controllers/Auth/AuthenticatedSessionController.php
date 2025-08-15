<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\PerfilInvitacion;


class AuthenticatedSessionController extends Controller
{

    public function create(): RedirectResponse
    {
        return to_route('welcome'); 
    }

    /**
     * Login.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();

        session(['perfil_activo_id' => $user->perfiles->first()?->id_perfil]);

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

                    return redirect()->route('dashboard')->with('success', 'Invitación aceptada. Ya puedes gestionar el perfil.');
                }
            }
        }
        return redirect()->route($this->nextRouteFor($user));
    }

    /**
     * Logout.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('welcome');
    }

    private function nextRouteFor($user): string
    {
        if (empty($user->rol_global) || !in_array($user->rol_global, ['estandar', 'premium'])) {
            return 'planes.show';
        }

        if (!$user->perfiles()->exists()) {
            return 'perfil.create';
        }
        $perfil = $user->perfiles()->first();
        $trat = $perfil->tratamientos()->latest()->first();
        if (!$trat) {
            return 'perfil.create'; 
        }

        if (!$trat->medicaciones()->exists()) {
            return 'medicacion.create';
        }

        return 'dashboard';
    }
}
