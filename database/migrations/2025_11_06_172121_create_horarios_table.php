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
        Schema::create('horarios', function (Blueprint $table) {
            $table->id();

            // --- Columnas de Llaves Foráneas ---
            // Asumimos los tipos de datos de tus llaves primarias:
            // id_grupo -> unsignedBigInteger
            // cod_materia -> string
            // n_trabajador -> string
            // id (aula) -> unsignedBigInteger
            
            $table->unsignedBigInteger('grupo_id');
            $table->string('materia_id'); 
            $table->string('profesore_id');
            $table->unsignedBigInteger('aula_id');

            // --- El Núcleo del Horario ---
            $table->tinyInteger('dia_semana'); // 1=Lunes, 2=Martes...
            $table->time('hora_inicio');
            $table->time('hora_fin');
            
            $table->timestamps();

            // --- Definiciones de Llaves (LA SOLUCIÓN) ---
            
            // 1. Llave para GRUPOS (El error estaba aquí)
            $table->foreign('grupo_id')
                  ->references('id_grupo')->on('grupos') // Tu llave es 'id_grupo', no 'id'
                  ->cascadeOnDelete();
            
            // 2. Llave para MATERIAS (Corregido proactivamente)
            $table->foreign('materia_id')
                  ->references('cod_materia')->on('materias') // Tu llave es 'cod_materia'
                  ->cascadeOnDelete();
                  
            // 3. Llave para PROFESORES (Corregido proactivamente)
            $table->foreign('profesore_id')
                  ->references('n_trabajador')->on('profesores') // Tu llave es 'n_trabajador'
                  ->cascadeOnDelete();
                  
            // 4. Llave para AULAS (Esta estaba bien, pero la hacemos explícita)
            $table->foreign('aula_id')
                  ->references('id')->on('aulas')
                  ->cascadeOnDelete();

            // --- Índices para Búsquedas Rápidas ---
            $table->index(['dia_semana', 'hora_inicio', 'hora_fin']);
            $table->index(['profesore_id', 'dia_semana']);
            $table->index(['aula_id', 'dia_semana']);
        });
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horarios');
    }
};