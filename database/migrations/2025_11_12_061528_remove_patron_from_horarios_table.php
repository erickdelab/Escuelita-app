<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('horarios')) { 
        Schema::table('horarios', function (Blueprint $table) {
            // Elimina la columna redundante
            $table->dropColumn('patron');
        });
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('horarios', function (Blueprint $table) {
            // Vuelve a agregar la columna si hacemos rollback
            $table->string('patron', 10)->nullable()->after('aula_id');
        });
    }
};