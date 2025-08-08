<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Perfil;
use Illuminate\Http\Request;

class PerfilActivoController extends Controller
{
    public function cambiar(Perfil $perfil, Request $request)
    {
        /** @var \App\Models\Usuario $usuario */
        $usuario = Auth::user();

        $tieneAcceso = $usuario->perfiles()->whereKey($perfil->id_perfil)->exists();

        if (!$tieneAcceso) {
            abort(403, 'No tienes permiso para cambiar al perfil seleccionado.');
        }

        session(['perfil_activo_id' => $perfil->id_perfil]);

        $redirect = url()->previous() ?: route('perfil.index');

        if ($request->filled('redirect_to')) {
            $redirect = $request->input('redirect_to');
        }

        return redirect($redirect)->with('success', 'Perfil activo cambiado correctamente.');
    }
}
