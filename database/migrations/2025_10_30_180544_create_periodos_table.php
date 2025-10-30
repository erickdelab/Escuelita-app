<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('periodos', function (Blueprint $table) {
            $table->id();
            $table->string('periodo_nombre'); // Enero-Junio, Agosto-Diciembre
            $table->integer('anio'); // 2020, 2021, 2022, etc.
            $table->string('codigo_periodo')->unique(); // ENEJUN20, AGODIC20, etc.
            $table->boolean('activo')->default(true);
            $table->timestamps();

            // Índices
            $table->index('anio');
            $table->index('activo');
        });
    }

    public function down()
    {
        Schema::dropIfExists('periodos');
    }
};