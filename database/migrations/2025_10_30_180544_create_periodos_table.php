<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
{
    if (!Schema::hasTable('periodos')) { // <--- Agrega esto
        Schema::create('periodos', function (Blueprint $table) {
            $table->id();
            $table->string('periodo_nombre');
            $table->integer('anio');
            $table->string('codigo_periodo');
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }
}

    public function down()
    {
        Schema::dropIfExists('periodos');
    }
};