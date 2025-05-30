<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;


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

        $user = $request->user();

        // Verificar la contraseña 
        if (!Hash::check($request->contrasena, $user->contrasena)) {
            return back()->withErrors([
                'contrasena' => 'La contraseña es incorrecta.',
            ])->with('openDeleteModal', true);
        }

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
