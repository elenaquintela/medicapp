<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\MedicacionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TratamientoController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


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
    return view('account.planes');
})->name('planes.show');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');



Route::get('/tratamiento/create', [TratamientoController::class, 'create'])->name('tratamiento.create');
Route::post('/tratamiento', [TratamientoController::class, 'store'])->name('tratamiento.store');


Route::middleware('auth')->group(function () {
    Route::get('/account', [AccountController::class, 'edit'])->name('account.edit');
    Route::patch('/account', [AccountController::class, 'update'])->name('account.update');
    Route::delete('/acccount', [AccountController::class, 'destroy'])->name('account.destroy');
});

require __DIR__ . '/auth.php';
