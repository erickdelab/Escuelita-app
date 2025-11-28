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
    if (!Schema::hasColumn('alumnos', 'id_carrera')) { // <--- Agrega esta condición
        Schema::table('alumnos', function (Blueprint $table) {
            $table->unsignedBigInteger('id_carrera')->nullable()->after('n_control');
        });
    }
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