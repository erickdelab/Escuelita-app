<?php

namespace App\Services;

use App\Models\Horario;
use App\Models\Materia;
use App\Models\Aula;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ScheduleService
{
    /**
     * Intenta asignar un horario complejo a un grupo.
     * Lanza una excepción si hay colisión.
     */
    public function assignSchedule(
        int $grupoId,
        string $materiaId,    // cod_materia
        string $profesorId,   // n_trabajador
        int $aulaId,
        string $patron,       // 'L-M' o 'M-J'
        string $horaInicioBloque // '07:00:00', etc.
    ): void {
        // 1. Obtenemos la materia (usa el PK cod_materia)
        $materia = Materia::findOrFail($materiaId);

        // ✅ CORREGIDO: 'credito' en singular
        $creditos = $materia->credito ?? 5;

        // 2. Generar los bloques tentativos según reglas de créditos y patrón
        $bloques = $this->generateBlocks($creditos, $patron, $horaInicioBloque);

        // 3. Comprobar colisiones
        $this->checkCollisions($grupoId, $profesorId, $aulaId, $bloques);

        // 4. Guardar dentro de una transacción
        DB::transaction(function () use ($bloques, $grupoId, $materiaId, $profesorId, $aulaId) {
            foreach ($bloques as $bloque) {
                Horario::create([
                    'grupo_id' => $grupoId,
                    'materia_id' => $materiaId,
                    'profesore_id' => $profesorId,
                    'aula_id' => $aulaId,
                    'dia_semana' => $bloque['dia'],
                    'hora_inicio' => $bloque['inicio'],
                    'hora_fin' => $bloque['fin'],
                ]);
            }
        });

        Log::info("✅ Horario asignado correctamente a grupo {$grupoId} con materia {$materiaId}");
    }

    /**
     * Genera los bloques de horario según créditos y patrón.
     */
    public function generateBlocks(int $creditos, string $patron, string $horaInicioStr): array
    {
        $bloques = [];
        $horaInicio = Carbon::parse($horaInicioStr);
        $horaFinBloque = $horaInicio->copy()->addHours(2)->format('H:i:s');
        $horaInicioBloque = $horaInicio->format('H:i:s');

        $diasPatron = $patron === 'L-M' ? [1, 3] : [2, 4];

        foreach ($diasPatron as $dia) {
            $bloques[] = [
                'dia' => $dia,
                'inicio' => $horaInicioBloque,
                'fin' => $horaFinBloque,
            ];
        }

        if ($creditos == 5) {
            if ($patron === 'L-M') {
                $bloques[] = [
                    'dia' => 5,
                    'inicio' => $horaInicioBloque,
                    'fin' => $horaInicio->copy()->addHour()->format('H:i:s'),
                ];
            } elseif ($patron === 'M-J') {
                $bloques[] = [
                    'dia' => 5,
                    'inicio' => $horaInicio->copy()->addHour()->format('H:i:s'),
                    'fin' => $horaFinBloque,
                ];
            }
        }

        return $bloques;
    }

    /**
     * Verifica colisiones para grupo, profesor y aula.
     */
    private function checkCollisions(int $grupoId, string $profesorId, int $aulaId, array $bloques): void
    {
        foreach ($bloques as $bloque) {
            $collision = Horario::query()
                ->where('dia_semana', $bloque['dia'])
                ->where('hora_inicio', '<', $bloque['fin'])
                ->where('hora_fin', '>', $bloque['inicio'])
                ->where(function ($query) use ($grupoId, $profesorId, $aulaId) {
                    $query->where('grupo_id', $grupoId)
                        ->orWhere('profesore_id', $profesorId)
                        ->orWhere('aula_id', $aulaId);
                })
                ->exists();

            if ($collision) {
                $diaNombre = match ($bloque['dia']) {
                    1 => 'Lunes',
                    2 => 'Martes',
                    3 => 'Miércoles',
                    4 => 'Jueves',
                    5 => 'Viernes',
                    default => 'Día ' . $bloque['dia'],
                };

                throw new \Exception(
                    "⚠️ Colisión detectada el {$diaNombre} entre {$bloque['inicio']} y {$bloque['fin']}."
                );
            }
        }
    }

    /**
     * 🔹 NUEVO MÉTODO:
     * Verifica la disponibilidad de aulas según patrón y hora seleccionada.
     * Devuelve dos listas: disponibles y ocupadas.
     */
   public function verificarDisponibilidad(string $cod_materia, string $patron, string $hora_inicio): array
{
    // 1️⃣ Obtener todas las aulas
    $aulas = \App\Models\Aula::all();

    // 2️⃣ Buscar las aulas ocupadas en ese patrón y hora
    $aulasOcupadasIds = \App\Models\Horario::where('patron', $patron)
        ->where('hora_inicio', $hora_inicio)
        ->pluck('aula_id')
        ->toArray();

    // 3️⃣ Clasificar (usa 'id' porque así se llama el campo en tu tabla)
    $disponibles = $aulas->whereNotIn('id', $aulasOcupadasIds)->values();
    $ocupadas = $aulas->whereIn('id', $aulasOcupadasIds)->values();

    return [
        'disponibles' => $disponibles,
        'ocupadas' => $ocupadas,
    ];
}
}
