<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Recordatorio;

class RecordatorioController extends Controller
{
    public function marcarComoTomado(Request $request, Recordatorio $recordatorio)
    {
        $validated = $request->validate([
            'tomado' => 'required|boolean',
        ]);
        /** @var \App\Models\Usuario $usuario */
        $usuario = Auth::user();
        $usuario->load('perfiles');
        $perfilActivo = $usuario->perfilActivo;

        if (!$perfilActivo ||
            $recordatorio->tratamientoMedicamento?->tratamiento?->id_perfil !== $perfilActivo->id_perfil) {
            return response()->json(['success' => false, 'error' => 'No autorizado'], 403);
        }

        $recordatorio->tomado = $validated['tomado'];
        $recordatorio->save();

        return response()->json(['success' => true]);
    }
}
