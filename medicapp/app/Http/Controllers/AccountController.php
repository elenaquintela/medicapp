<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class AccountController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('account.edit', [
            'usuario' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Actualizar el nombre
        $user->nombre = $request->validated()['nombre'];

        // Si se envió una nueva contraseña, actualizarla
        if ($request->filled('password')) {
            $user->contrasena = bcrypt($request->password);
        }

        $user->save();

        return Redirect::route('account.edit')->with('status', 'profile-updated');
    }



    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'contrasena' => ['required'],
        ]);

        /** @var \App\Models\Usuario $user */
        $user = $request->user();

        if (!Hash::check($request->contrasena, $user->contrasena)) {
            return back()
                ->withErrors(['contrasena' => 'La contraseña es incorrecta.'], 'userDeletion')
                ->with('openDeleteModal', true);
        }

        // Cerrar sesión y limpiar sesión ANTES de tocar la BD
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        DB::transaction(function () use ($user) {
            // 1) BORRAR los perfiles donde este usuario es PROPIETARIO (rol_en_perfil='creador')
            foreach ($user->perfilesCreados as $perfil) {
                // Quita a todos los usuarios vinculados a ese perfil (incluido el creador)
                $perfil->usuarios()->detach();

                // Borrados asociados (mantén estos si no tienes ON DELETE CASCADE en BD)
                if (method_exists($perfil, 'citas')) {
                    $perfil->citas()->delete();
                }

                if (method_exists($perfil, 'tratamientos')) {
                    foreach ($perfil->tratamientos as $tratamiento) {
                        if (method_exists($tratamiento, 'medicaciones')) {
                            foreach ($tratamiento->medicaciones as $medicacion) {
                                if (method_exists($medicacion, 'recordatorios')) {
                                    $medicacion->recordatorios()->delete();
                                }
                                $medicacion->delete();
                            }
                        }
                        $tratamiento->delete();
                    }
                }

                if (method_exists($perfil, 'notificaciones')) {
                    $perfil->notificaciones()->delete();
                }
                if (method_exists($perfil, 'informes')) {
                    $perfil->informes()->delete();
                }

                // Finalmente, borrar el perfil
                $perfil->delete();
            }

            // 2) En perfiles donde es INVITADO (rol_en_perfil='invitado'), solo quitar acceso
            $user->perfilesInvitado()->detach();

            // 3) (Opcional) limpiar recursos propios del usuario
            if (method_exists($user, 'notificaciones')) {
                $user->notificaciones()->delete();
            }
            if (method_exists($user, 'informes')) {
                $user->informes()->delete();
            }
            if (method_exists($user, 'citasCreadas')) {
                $user->citasCreadas()->delete();
            }

            // 4) Borrar al usuario
            $user->delete();
        });

        return to_route('welcome')->with('status', 'account-deleted');
    }
}
