<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CitaController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        return view('cita.index', [
            'perfilesUsuario' => $user->perfiles ?? [],
            'perfilActivo' => $user->perfilActivo ?? null,
        ]);
    }
}
