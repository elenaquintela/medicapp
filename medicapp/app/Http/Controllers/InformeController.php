<?php

namespace App\Http\Controllers;

use App\Models\Informe;
use App\Models\Tratamiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class InformeController extends Controller
{
    public function index(Request $request)
    {
        /** @var \App\Models\Usuario $user */
        $user = Auth::user();
        if ($user->rol_global !== 'premium') {
            abort(403, 'Solo usuarios premium pueden generar informes.');
        }

        $perfil = $user->perfilActivo;
        if (!$perfil) {
            return redirect()->route('perfil.index')->withErrors('Selecciona o crea un perfil primero.');
        }

        $tratamientos = $perfil->tratamientos()->latest('id_tratamiento')->get();

        $informes = Informe::with(['tratamiento'])
            ->where('id_usuario', $user->id_usuario)
            ->where('id_perfil', $perfil->id_perfil)
            ->orderByDesc('ts_creacion')
            ->get();

        $defInicio = optional($tratamientos->first())->fecha_inicio
            ? \Illuminate\Support\Carbon::parse($tratamientos->first()->fecha_inicio)->toDateString()
            : now()->toDateString();

        $defFin    = now()->toDateString();

        return view('informe.index', compact('perfil', 'tratamientos', 'informes', 'defInicio', 'defFin'));
    }

    public function store(Request $request)
    {
        $user   = Auth::user();
        if ($user->rol_global !== 'premium') abort(403);

        $perfil = $user->perfilActivo;
        if (!$perfil) return redirect()->route('perfil.index')->withErrors('Selecciona un perfil.');

        $request->validate([
            'id_tratamiento' => ['required', 'integer'],
            'rango_inicio'   => ['required', 'date'],
            'rango_fin'      => ['required', 'date', 'after_or_equal:rango_inicio'],
        ]);

        /** @var Tratamiento $trat */
        $trat = $perfil->tratamientos()->where('id_tratamiento', $request->id_tratamiento)->first();
        if (!$trat) return back()->withErrors(['id_tratamiento' => 'Tratamiento inválido para este perfil.']);

        $perfil->load('citas');             
        $trat->load(['medicaciones.medicamento']); 

        $data = [
            'perfil' => $perfil,
            'tratamiento' => $trat,
            'inicio' => $request->rango_inicio,
            'fin' => $request->rango_fin,
            'generado_por' => $user,
            'generado_en' => now(),
        ];

        $pdf = Pdf::loadView('informe.pdf', $data)->setPaper('a4');

        $filename = 'informe_' . $perfil->id_perfil . '_t' . $trat->id_tratamiento . '_' . now()->format('Ymd_His') . '.pdf';
        $relative = 'informes/' . $filename;
        Storage::disk('public')->put($relative, $pdf->output());

        Informe::create([
            'id_usuario'     => $user->id_usuario,
            'id_perfil'      => $perfil->id_perfil,
            'id_tratamiento' => $trat->id_tratamiento,
            'rango_inicio'   => $request->rango_inicio,
            'rango_fin'      => $request->rango_fin,
            'ruta_pdf'       => $relative,
        ]);

        return redirect()->route('informe.index')->with('success', 'Informe generado correctamente.');
    }

    public function download(Informe $informe)
    {
        $user = Auth::user();
        if ($user->rol_global !== 'premium') abort(403);
        if ($informe->id_usuario !== $user->id_usuario) abort(403);

        $relative = ltrim($informe->ruta_pdf, '/');

        if (!Storage::disk('public')->exists($relative)) {
            return back()->withErrors('El archivo PDF no está disponible.');
        }

        $absolutePath = Storage::disk('public')->path($relative);
        $downloadName = basename($relative);

        return response()->download($absolutePath, $downloadName);
    }


    public function destroy(Informe $informe)
    {
        $user = Auth::user();
        if ($user->rol_global !== 'premium') abort(403);
        if ($informe->id_usuario !== $user->id_usuario) abort(403);

        if (Storage::disk('public')->exists($informe->ruta_pdf)) {
            Storage::disk('public')->delete($informe->ruta_pdf);
        }
        $informe->delete();

        return back()->with('success', 'Informe eliminado.');
    }
}
