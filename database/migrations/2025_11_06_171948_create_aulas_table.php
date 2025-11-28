<?php
// database/migrations/..._create_aulas_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('aulas')) { 
        Schema::create('aulas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); // E.g., "Edificio A - 101"
            $table->integer('capacidad')->nullable(); // Buena práctica
            $table->timestamps();
        });
    }
    }

    

    public function down(): void
    {
        Schema::dropIfExists('aulas');
    }
};