<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Institucion;

class ViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Compartir automáticamente $institucion en todas las vistas
        View::composer('*', function ($view) {
            $institucion = null;

            if (Auth::check()) {
                $user = Auth::user();

                // Asegúrate que el usuario tenga relación con institución
                $institucion = $user->institucion ?? null;
            }

            $view->with('institucion', $institucion);
        });
    }

    public function register(): void
    {
        //
    }
}
