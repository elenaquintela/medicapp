<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
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
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.Usuario::class],
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

        // Redirige SIEMPRE al siguiente paso del onboarding (sin intended).
        return redirect()->route($this->nextRouteFor($user));
    }

    /**
     * Lógica de onboarding (igual que en AuthenticatedSessionController).
     * Ajusta los nombres de rutas/relaciones si difieren en tu app.
     */
    private function nextRouteFor($user): string
    {
        // 1) Elegir plan
        if (empty($user->rol_global) || !in_array($user->rol_global, ['standard','estandar','premium'])) {
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
