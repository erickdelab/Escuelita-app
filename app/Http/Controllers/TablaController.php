<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TablaController extends Controller
{
    public function mostrar($nombre)
    {
        // Verificar que la tabla exista en la base de datos
        $tablas = DB::connection()->getDoctrineSchemaManager()->listTableNames();
        if(!in_array($nombre, $tablas)){
            abort(404, 'La tabla no existe.');
        }

        // Obtener todos los registros
        $registros = DB::table($nombre)->get();

        return view('tablas.mostrar', compact('registros', 'nombre'));
    }
}
