<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            /** @var \App\Models\Usuario $user */
            $user = Auth::user();

            if ($user) {
                $user->load('perfiles');


                $perfilActivo = null;
                $perfilActivoId = Session::get('perfil_activo_id');

                if ($perfilActivoId) {
                    $perfilActivo = $user->perfiles->firstWhere('id_perfil', $perfilActivoId);
                }

                $view->with('perfilActivo', $perfilActivo);
                $view->with('perfilesUsuario', $user->perfiles);
            }
        });
    }
}
