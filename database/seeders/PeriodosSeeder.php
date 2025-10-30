<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PeriodosSeeder extends Seeder
{
    public function run()
    {
        $periodos = [
            ['Enero-Junio', 2020, 'ENEJUN20', 0],
            ['Agosto-Diciembre', 2020, 'AGODIC20', 0],
            ['Enero-Junio', 2021, 'ENEJUN21', 0],
            ['Agosto-Diciembre', 2021, 'AGODIC21', 0],
            ['Enero-Junio', 2022, 'ENEJUN22', 0],
            ['Agosto-Diciembre', 2022, 'AGODIC22', 0],
            ['Enero-Junio', 2023, 'ENEJUN23', 0],
            ['Agosto-Diciembre', 2023, 'AGODIC23', 1],
            ['Enero-Junio', 2024, 'ENEJUN24', 1],
            ['Agosto-Diciembre', 2024, 'AGODIC24', 1],
            ['Enero-Junio', 2025, 'ENEJUN25', 1],
            ['Agosto-Diciembre', 2025, 'AGODIC25', 1],
        ];

        foreach ($periodos as $periodo) {
            DB::table('periodos')->insert([
                'periodo_nombre' => $periodo[0],
                'anio' => $periodo[1],
                'codigo_periodo' => $periodo[2],
                'activo' => $periodo[3],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}