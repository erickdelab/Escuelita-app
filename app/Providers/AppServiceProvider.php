<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator; // <-- 1. IMPORTA EL PAGINADOR
use Illuminate\Support\Facades\Gate; // <--- AGREGAR ESTO

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Paginator::useBootstrapFive();

        // 🔥 SUPER ADMIN: Permite que el rol 'admin' vea TODO siempre.
        // Intercepta cualquier chequeo de permisos y devuelve "sí" automáticamente.
        Gate::before(function ($user, $ability) {
            if ($user->hasRole('admin')) {
                return true;
            }
        });
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