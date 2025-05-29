<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Perfil;

class PerfilActivoController extends Controller
{
    public function cambiar($id)
    {
        $usuario = Auth::user();

        if (!$usuario->perfiles->contains('id_perfil', $id)) {
            abort(403);
        }

        Session::put('perfil_activo_id', $id);
        return redirect()->back();
    }
}
