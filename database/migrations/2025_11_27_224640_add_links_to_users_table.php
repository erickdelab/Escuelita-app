<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Verificar si la columna ya existe antes de crearla
            if (!Schema::hasColumn('users', 'n_control_link')) {
                $table->string('n_control_link')->nullable()->index()->after('email');
            }
            
            if (!Schema::hasColumn('users', 'n_trabajador_link')) {
                $table->string('n_trabajador_link')->nullable()->index()->after('n_control_link');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['n_control_link', 'n_trabajador_link']);
        });
    }
};