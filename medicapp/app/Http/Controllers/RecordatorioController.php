<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recordatorio;

class RecordatorioController extends Controller
{
    public function marcarComoTomado(Request $request, Recordatorio $recordatorio)
    {
        $validated = $request->validate([
            'tomado' => 'required|boolean',
        ]);

        $recordatorio->tomado = $validated['tomado'];
        $recordatorio->save();

        return response()->json(['success' => true]);
    }
}
