<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\TratamientoController;
use App\Http\Controllers\MedicacionController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\PerfilActivoController;

/*
|--------------------------------------------------------------------------
| Rutas públicas
|--------------------------------------------------------------------------
*/

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

/*
|--------------------------------------------------------------------------
| Rutas de registro inicial
|--------------------------------------------------------------------------
*/

Route::get('/planes', function () {
    /** @var \App\Models\Usuario $usuario */
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

/*
|--------------------------------------------------------------------------
| Rutas protegidas (requieren autenticación)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware(['verified'])
        ->name('dashboard');

    // Perfil
    Route::get('/perfil/crear', [PerfilController::class, 'create'])->name('perfil.create');
    Route::post('/perfil', [PerfilController::class, 'store'])->name('perfil.store');

    // Tratamiento
    Route::get('/tratamiento/create', [TratamientoController::class, 'create'])->name('tratamiento.create');
    Route::post('/tratamiento', [TratamientoController::class, 'store'])->name('tratamiento.store');

    // Medicación
    Route::get('/tratamiento/{tratamiento}/medicacion', [MedicacionController::class, 'create'])->name('medicacion.create');
    Route::post('/tratamiento/{tratamiento}/medicacion', [MedicacionController::class, 'store'])->name('medicacion.store');

    // Citas
    Route::get('/citas', [CitaController::class, 'index'])->name('cita.index');
    Route::get('/citas/crear', [CitaController::class, 'create'])->name('cita.create');
    Route::post('/citas', [CitaController::class, 'store'])->name('cita.store');
    Route::get('/citas/{cita}/editar', [CitaController::class, 'edit'])->name('cita.edit');
    Route::put('/citas/{cita}', [CitaController::class, 'update'])->name('cita.update');

    // Cuenta
    Route::get('/account', [AccountController::class, 'edit'])->name('account.edit');
    Route::patch('/account', [AccountController::class, 'update'])->name('account.update');
    Route::delete('/account', [AccountController::class, 'destroy'])->name('account.destroy');

    Route::post('/cuenta/cambiar-suscripcion', function (Request $request) {
        $request->validate([
            'rol_global' => 'required|in:estandar,premium'
        ]);
        /** @var \App\Models\Usuario $usuario */
        $usuario = Auth::user();
        $usuario->rol_global = $request->rol_global;
        $usuario->save();
        return redirect()->route('account.edit')->with('success', 'Tu suscripción ha sido actualizada.');
    })->name('account.changePlan');

    // Cambio de perfil activo
    Route::get('/perfil/usar/{id}', [PerfilActivoController::class, 'cambiar'])->name('perfil.cambiar');

    Route::post('/perfil/seleccionar', function (Request $request) {
        $request->validate(['id_perfil' => 'required|integer']);
        session(['perfil_activo_id' => $request->id_perfil]);
        return redirect()->back();
    })->name('perfil.seleccionar');

    // Marcar recordatorio como tomado
    Route::post('/recordatorios/{recordatorio}/marcar', [\App\Http\Controllers\RecordatorioController::class, 'marcarComoTomado'])
        ->name('recordatorio.marcar');

});

/*
|--------------------------------------------------------------------------
| Rutas de autenticación Breeze
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';
