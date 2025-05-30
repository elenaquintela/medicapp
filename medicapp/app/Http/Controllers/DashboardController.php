<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        /** @var \App\Models\Usuario $usuario */
        $usuario = Auth::user();
        $usuario->load('perfiles');

        // Comprobar si viene el cambio de perfil en la URL
        $idPerfilSeleccionado = $request->input('perfil');
        if ($idPerfilSeleccionado && $usuario->perfiles->contains('id_perfil', $idPerfilSeleccionado)) {
            session(['perfil_activo_id' => $idPerfilSeleccionado]);
        }

        // Obtener el perfil activo
        $perfilActivo = $usuario->perfilActivo;

        // Tratamientos con medicaciones y medicamentos precargados
        $tratamientos = $perfilActivo
            ? $perfilActivo->tratamientos()->with('medicaciones.medicamento')->get()
            : collect();

        // Citas futuras del perfil activo
        $citas = $perfilActivo
            ? $perfilActivo->citas()
                ->whereDate('fecha', '>=', now()->toDateString())
                ->orderBy('fecha')
                ->orderBy('hora_inicio')
                ->get()
            : collect();

        // Perfiles para el layout
        $perfilesUsuario = $usuario->perfiles;

        return view('dashboard', compact('perfilActivo', 'tratamientos', 'citas', 'perfilesUsuario'));
    }
}
