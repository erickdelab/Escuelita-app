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
    Schema::create('boletas', function (Blueprint $table) {
        $table->id();
        
        // 1. Definimos la columna EXACTAMENTE igual a la de alumnos (VARCHAR 9)
        // IMPORTANTE: Agregamos ->collation('utf8mb4_general_ci') para que coincida con tu base de datos importada.
        $table->string('n_control', 9)->collation('utf8mb4_general_ci');
        
        // 2. Definimos la llave foránea
        $table->foreign('n_control')->references('n_control')->on('alumnos')->onDelete('cascade');
        
        // 3. Resto de los campos
        $table->string('cod_materia', 30)->collation('utf8mb4_general_ci'); // Sugiero agregarlo aquí también por si acaso
        $table->string('periodo', 20);
        $table->decimal('calificacion', 5, 2)->nullable();
        $table->string('oportunidad', 20);
        
        $table->string('n_trabajador', 30)->nullable()->collation('utf8mb4_general_ci');
        $table->unsignedBigInteger('id_grupo')->nullable();
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boletas');
    }
};
