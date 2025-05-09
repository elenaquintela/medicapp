<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        /** @var \App\Models\Usuario $usuario */
        $usuario = Auth::user();
        $perfilesUsuario = $usuario->perfiles()->get();

        // ¿Viene un perfil en la URL?
        $idPerfilSeleccionado = $request->input('perfil');

        if ($idPerfilSeleccionado && $perfilesUsuario->contains('id_perfil', $idPerfilSeleccionado)) {
            // Guardar selección en la sesión
            session(['perfil_activo_id' => $idPerfilSeleccionado]);
        }

        // Obtener el perfil activo de la sesión o usar el primero disponible
        $perfilActivo = $perfilesUsuario->firstWhere('id_perfil', session('perfil_activo_id'));

        if (!$perfilActivo) {
            $perfilActivo = $perfilesUsuario->first();
        }

        $tratamientos = $perfilActivo ? $perfilActivo->tratamientos : collect();

        return view('dashboard', compact('perfilesUsuario', 'perfilActivo', 'tratamientos'));
    }
}
