<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('alumnos', function (Blueprint $table) {

            // 1) Eliminar FK vieja si existe
            $foreignKeys = DB::select("
                SELECT CONSTRAINT_NAME 
                FROM information_schema.KEY_COLUMN_USAGE
                WHERE TABLE_NAME = 'alumnos'
                AND COLUMN_NAME = 'id_carrera'
                AND REFERENCED_TABLE_NAME IS NOT NULL;
            ");

            foreach ($foreignKeys as $fk) {
                try {
                    $table->dropForeign($fk->CONSTRAINT_NAME);
                } catch (\Exception $e) {}
            }

            // 2) Crear columna si no existe
            if (!Schema::hasColumn('alumnos', 'id_carrera')) {
                $table->unsignedInteger('id_carrera')->nullable()->after('n_control');
            }
        });

        // 3) Asegurar que el tipo de id_carrera sea INT UNSIGNED (igual que carreras.id)
        DB::statement("ALTER TABLE alumnos MODIFY id_carrera INT UNSIGNED NULL");

        // 4) Crear FK correcta hacia carreras.id
        Schema::table('alumnos', function (Blueprint $table) {
            try {
                $table->foreign('id_carrera')
                      ->references('id')
                      ->on('carreras')
                      ->onDelete('restrict');
            } catch (\Exception $e) {
                // Evita romper si ya existe
            }
        });
    }

    public function down()
    {
        Schema::table('alumnos', function (Blueprint $table) {

            try {
                $table->dropForeign(['id_carrera']);
            } catch (\Exception $e) {}

            if (Schema::hasColumn('alumnos', 'id_carrera')) {
                $table->dropColumn('id_carrera');
            }
        });
    }
};
