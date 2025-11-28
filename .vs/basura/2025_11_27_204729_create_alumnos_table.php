<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('alumnos', function (Blueprint $table) {

            $table->string('n_control', 30)->primary(); // tu llave primaria real

            $table->string('nombre');
            $table->string('ap_paterno');
            $table->string('ap_materno')->nullable();
            $table->string('email')->nullable();

            // Relación con carreras (se llenará después)
            $table->unsignedInteger('id_carrera')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('alumnos');
    }
};
