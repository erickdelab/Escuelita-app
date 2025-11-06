<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('alumnos', function (Blueprint $table) {
            
            // --- LÍNEA CORREGIDA ---
            // Se cambió 'id_alumno' por 'n_control', que es la llave primaria.
            $table->unsignedBigInteger('id_carrera')->nullable()->after('n_control');

            // --- RELACIÓN ---
            $table->foreign('id_carrera')
                  ->references('id_carrera')
                  ->on('carreras')
                  ->onDelete('restrict'); // evita eliminar carrera si hay alumnos
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('alumnos', function (Blueprint $table) {
            $table->dropForeign(['id_carrera']);
            $table->dropColumn('id_carrera');
        });
    }
};