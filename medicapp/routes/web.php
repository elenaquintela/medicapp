<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\MedicacionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TratamientoController;
use App\Http\Controllers\CitaController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    return view('auth.welcome');
});

Route::get('/login', function () {
    return redirect('/');
});

Route::view('/aviso-legal', 'legal.aviso-legal')->name('legal.aviso');
Route::view('/politica-privacidad', 'legal.politica-privacidad')->name('legal.privacidad');
Route::view('/politica-cookies', 'legal.politica-cookies')->name('legal.cookies');

Route::get('/perfil/crear', [PerfilController::class, 'create'])->name('perfil.create');
Route::post('/perfil', [PerfilController::class, 'store'])->name('perfil.store');

Route::get('/tratamiento/{tratamiento}/medicacion', [MedicacionController::class, 'create'])->name('medicacion.create');
Route::post('/tratamiento/{tratamiento}/medicacion', [MedicacionController::class, 'store'])->name('medicacion.store');

Route::get('/planes', function () {
    $usuario = Auth::user();
    if ($usuario->rol_global) {
        return redirect()->route('dashboard');
    }

    return view('account.planes');
})->middleware('auth')->name('planes.show');

Route::post('/planes', function (Request $request) {
    $request->validate([
        'rol_global' => 'required|in:estandar,premium'
    ]);

    /** @var \App\Models\Usuario $usuario */
    $usuario = Auth::user();
    $usuario->rol_global = $request->rol_global;
    $usuario->save();

    return redirect()->route('perfil.create');
})->middleware('auth')->name('planes.store');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/tratamiento/create', [TratamientoController::class, 'create'])->name('tratamiento.create');
Route::post('/tratamiento', [TratamientoController::class, 'store'])->name('tratamiento.store');

Route::middleware('auth')->group(function () {
    Route::get('/account', [AccountController::class, 'edit'])->name('account.edit');
    Route::patch('/account', [AccountController::class, 'update'])->name('account.update');
    Route::delete('/account', [AccountController::class, 'destroy'])->name('account.destroy');

    Route::get('/citas', [CitaController::class, 'index'])->name('cita.index');
    Route::get('/citas/crear', [CitaController::class, 'create'])->name('cita.create');
    Route::post('/citas', [CitaController::class, 'store'])->name('cita.store');

    Route::get('/citas/{cita}/editar', [CitaController::class, 'edit'])->name('cita.edit');
    Route::put('/citas/{cita}', [CitaController::class, 'update'])->name('cita.update');

});

Route::get('/perfil/usar/{id}', [\App\Http\Controllers\PerfilActivoController::class, 'cambiar'])
    ->middleware('auth')
    ->name('perfil.cambiar');


Route::post('/perfil/seleccionar', function (Request $request) {
    $request->validate(['id_perfil' => 'required|integer']);
    session(['perfil_activo_id' => $request->id_perfil]);
    return redirect()->back();
})->middleware('auth')->name('perfil.seleccionar');

require __DIR__ . '/auth.php';
