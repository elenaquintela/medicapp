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
use App\Http\Controllers\PerfilInvitacionController;
use App\Http\Controllers\PerfilMiembrosController;
use App\Http\Controllers\InformeController;
use App\Http\Controllers\GoogleCalendarController;
use App\Http\Controllers\NotificacionController;

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
})->name('welcome');

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


Route::get('/invitaciones/aceptar/{token}', [PerfilInvitacionController::class, 'accept'])
    ->middleware('throttle:20,1')
    ->name('invitaciones.accept');



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
    Route::get('/perfil', [PerfilController::class, 'index'])->name('perfil.index');
    Route::put('/perfil/{perfil}', [PerfilController::class, 'update'])->name('perfil.update');
    Route::delete('/perfil/{perfil}', [PerfilController::class, 'destroy'])->name('perfil.destroy');
    Route::post('/perfil/seleccionar', function (Request $request) {
        $request->validate([
            'id_perfil' => 'required|integer',
            'redirect_to' => 'nullable|string'
        ]);

        session(['perfil_activo_id' => $request->id_perfil]);

        return $request->filled('redirect_to')
            ? redirect($request->redirect_to)
            : redirect()->back();
    })->name('perfil.seleccionar');

    // Tratamiento
    Route::get('/tratamiento/create', [TratamientoController::class, 'create'])->name('tratamiento.create');
    Route::post('/tratamiento', [TratamientoController::class, 'store'])->name('tratamiento.store');
    Route::get('/tratamientos', [TratamientoController::class, 'index'])->name('tratamiento.index');
    Route::get('/tratamiento/{tratamiento}', [TratamientoController::class, 'show'])->name('tratamiento.show');
    Route::put('/tratamiento/{tratamiento}/archivar', [TratamientoController::class, 'archivar'])->name('tratamiento.archivar');
    Route::delete('/tratamiento/{tratamiento}', [TratamientoController::class, 'destroy'])->name('tratamiento.destroy');
    Route::put('/tratamientos/{tratamiento}/reactivar', [TratamientoController::class, 'reactivar'])
    ->name('tratamiento.reactivar');

    // Medicación
    Route::get('/tratamiento/{tratamiento}/medicacion', [MedicacionController::class, 'create'])->name('medicacion.create');
    Route::post('/tratamiento/{tratamiento}/medicacion', [MedicacionController::class, 'store'])->name('medicacion.store');
    Route::get('/medicacion/{medicacion}/edit', [MedicacionController::class, 'edit'])->name('medicacion.edit');
    Route::put('/medicacion/{medicacion}', [MedicacionController::class, 'update'])->name('medicacion.update');
    Route::delete('/medicacion/{medicacion}', [MedicacionController::class, 'destroy'])->name('medicacion.destroy');
    Route::put('/medicacion/{medicacion}/archivar', [MedicacionController::class, 'archivar'])->name('medicacion.archivar');
    Route::put('/medicacion/{id}/reactivar', [MedicacionController::class, 'reactivar'])
    ->name('medicacion.reactivar');
    Route::get('/tratamiento/{tratamiento}/medicacion/{tratMed}/sustituir', [MedicacionController::class, 'replaceForm'])->name('medicacion.replace.form');
    Route::post('/tratamiento/{tratamiento}/medicacion/{tratMed}/sustituir', [MedicacionController::class, 'replace'])->name('medicacion.replace');

    // Citas
    Route::get('/citas', [CitaController::class, 'index'])->name('cita.index');
    Route::get('/citas/crear', [CitaController::class, 'create'])->name('cita.create');
    Route::post('/citas', [CitaController::class, 'store'])->name('cita.store');
    Route::get('/citas/{cita}/editar', [CitaController::class, 'edit'])->name('cita.edit');
    Route::put('/citas/{cita}', [CitaController::class, 'update'])->name('cita.update');
    Route::delete('/citas/{cita}', [CitaController::class, 'destroy'])->name('cita.destroy');


    // Informes

    Route::get('/informes', [InformeController::class, 'index'])->name('informe.index');
    Route::post('/informes', [InformeController::class, 'store'])->name('informe.store');
    Route::get('/informes/{informe}/descargar', [InformeController::class, 'download'])->name('informe.download');
    Route::delete('/informes/{informe}', [InformeController::class, 'destroy'])->name('informe.destroy');

    // Notificaciones

    Route::get('/notificaciones', [NotificacionController::class, 'index'])
        ->name('notificaciones.index');
    Route::post('/notificaciones/{notificacion}/leer', [NotificacionController::class, 'marcarLeida'])
        ->name('notificaciones.leer');
    Route::post('/notificaciones/leer-todas', [NotificacionController::class, 'marcarTodasLeidas'])
        ->name('notificaciones.leerTodas');

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

    // PerfilActivo
    Route::post('/perfil/activo/{perfil}', [PerfilActivoController::class, 'cambiar'])
        ->name('perfil.activo.cambiar');

    // Recordatorios
    Route::post('/recordatorios/{recordatorio}/marcar', [\App\Http\Controllers\RecordatorioController::class, 'marcarComoTomado'])
        ->name('recordatorio.marcar');

    // Invitaciones
    Route::post('/perfil/{perfil}/invitaciones', [PerfilInvitacionController::class, 'store'])
        ->name('perfil.invitaciones.store');

    // PerfilMiembros
    Route::delete('/perfil/{perfil}/miembros/{usuario}', [PerfilMiembrosController::class, 'destroy'])
        ->name('perfil.miembros.destroy');

    // Google Calendar 
    Route::get('/google/connect',  [GoogleCalendarController::class, 'connect'])->name('google.connect');
    Route::get('/google/callback', [GoogleCalendarController::class, 'callback'])->name('google.callback');
    Route::post('/google/sync-citas', [GoogleCalendarController::class, 'syncAll'])->name('google.syncAll');
    Route::get('/google/reconnect', [GoogleCalendarController::class, 'reconnect'])->name('google.reconnect');


});

/*
|--------------------------------------------------------------------------
| Rutas de autenticación Breeze
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';
