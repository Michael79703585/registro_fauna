<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Institucion;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        View::composer('*', function ($view) {
    $institucion = null;
    if (Auth::check()) {
        $institucion = Auth::user()->institucion;
    }
    $view->with('institucion', $institucion);
});

    }
}
