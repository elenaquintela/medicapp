<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Mostrar (o redirigir) la vista de login.
     * Tu flujo empieza en welcome, así que mandamos ahí.
     */
    public function create(): RedirectResponse
    {
        return to_route('welcome'); // asegúrate de tener Route::view('/', 'welcome')->name('welcome');
    }

    /**
     * Login.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();

        // tu lógica actual de perfil activo
        session(['perfil_activo_id' => $user->perfiles->first()?->id_perfil]);

        // CLAVE: no usar intended. Decide siempre el siguiente paso del onboarding.
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

    /**
     * Decide el siguiente paso del onboarding.
     * Ajusta los nombres de rutas/relaciones si en tu proyecto se llaman distinto.
     */
    private function nextRouteFor($user): string
    {
        // 1) Plan elegido (usa aquí tu condición real: rol_global/plan en DB)
        if (empty($user->rol_global) || !in_array($user->rol_global, ['estandar','premium'])) {
            return 'planes.show'; // o 'planes'
        }

        // 2) Primer perfil creado
        if (!$user->perfiles()->exists()) {
            return 'perfil.create';
        }

        // 3) Primer tratamiento creado (si lo creas junto con el perfil, puedes obviar este bloque)
        $perfil = $user->perfiles()->first();
        $trat = $perfil->tratamientos()->latest()->first();
        if (!$trat) {
            // si creas tratamiento dentro de perfil.store, elimina este return
            return 'perfil.create'; // o una ruta específica para crear tratamiento, si la tienes
        }

        // 4) Primera medicación
        if (!$trat->medicaciones()->exists()) {
            return 'medicacion.create';
        }

        // 5) Todo completo → dashboard
        return 'dashboard';
    }
}
