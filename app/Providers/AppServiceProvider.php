<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator; // <-- 1. IMPORTA EL PAGINADOR

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
        // 2. AÑADE ESTA LÍNEA
        Paginator::useBootstrapFive(); 
        // o Paginator::useBootstrapFour(); si usas Bootstrap 4
    }
}