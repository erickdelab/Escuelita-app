<?php

namespace App\Services;

use App\Models\Horario;
use App\Models\Materia;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ScheduleService
{
    /**
     * Intenta asignar un horario complejo a un grupo.
     * Lanza una excepción con mensaje detallado si hay colisión.
     */
    public function assignSchedule(
        int $grupoId,
        string $materiaId,    
        string $profesorId,   
        int $aulaId,
        string $patron,       
        string $horaInicioBloque 
    ): void {
        
        $materia = Materia::findOrFail($materiaId);
        $creditos = $materia->credito ?? 5;

        // Generar bloques
        $bloques = $this->generateBlocks($creditos, $patron, $horaInicioBloque);

        // Comprobar colisiones DETALLADAS
        $this->checkCollisions($grupoId, $profesorId, $aulaId, $bloques);

        // Guardar
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
    }

    /**
     * Genera los bloques de horario.
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
            // La hora extra del viernes (o tercer día)
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
                    'fin' => $horaFinBloque, // Ojo: a veces M-J tiene viernes de 2h o 1h según regla escolar
                ];
            }
        }

        return $bloques;
    }

    /**
     * Verifica colisiones específicas y lanza mensajes claros.
     */
    private function checkCollisions(int $grupoId, string $profesorId, int $aulaId, array $bloques): void
    {
        foreach ($bloques as $bloque) {
            
            // 1. VERIFICAR AULA (Prioridad alta)
            // Buscamos si existe un horario en ese día/hora y en esa aula
            // (Nota: Como ya borramos el horario del grupo actual en el Controller, no choca consigo mismo)
            $colisionAula = Horario::with(['grupo.materia', 'aula'])
                ->where('dia_semana', $bloque['dia'])
                ->where('aula_id', $aulaId)
                ->where(function($q) use ($bloque) {
                    $q->where('hora_inicio', '<', $bloque['fin'])
                      ->where('hora_fin', '>', $bloque['inicio']);
                })
                ->first();

            if ($colisionAula) {
                $dia = $this->getDiaNombre($bloque['dia']);
                $aulaNombre = $colisionAula->aula->nombre ?? 'N/A';
                $materiaChocona = $colisionAula->grupo->materia->nombre ?? 'Desconocida';
                $grupoChocon = $colisionAula->grupo_id;

                throw new \Exception(
                    "🚫 CHOQUE DE AULA: El aula '{$aulaNombre}' ya está ocupada el {$dia} ({$colisionAula->hora_inicio} - {$colisionAula->hora_fin}) por la materia '{$materiaChocona}' (Grupo {$grupoChocon})."
                );
            }

            // 2. VERIFICAR PROFESOR
            $colisionProf = Horario::with('grupo.materia')
                ->where('dia_semana', $bloque['dia'])
                ->where('profesore_id', $profesorId)
                ->where(function($q) use ($bloque) {
                    $q->where('hora_inicio', '<', $bloque['fin'])
                      ->where('hora_fin', '>', $bloque['inicio']);
                })
                ->first();

            if ($colisionProf) {
                $dia = $this->getDiaNombre($bloque['dia']);
                $materiaChocona = $colisionProf->grupo->materia->nombre ?? 'Otra materia';
                
                throw new \Exception(
                    "👨‍🏫 CHOQUE DE PROFESOR: El docente ya tiene clase el {$dia} ({$colisionProf->hora_inicio} - {$colisionProf->hora_fin}) impartiendo '{$materiaChocona}'."
                );
            }
        }
    }

    private function getDiaNombre($diaNum) {
        return match ($diaNum) {
            1 => 'Lunes', 2 => 'Martes', 3 => 'Miércoles', 4 => 'Jueves', 5 => 'Viernes', 6 => 'Sábado', default => 'Día'
        };
    }

    /**
     * Utilidad para verificar disponibilidad visual (usado en el Controller)
     */
    public function verificarDisponibilidad(string $cod_materia, string $patron, string $hora_inicio): array
    {
        $aulas = \App\Models\Aula::all();
        
        // Simplemente devolvemos todas para que la validación fuerte se haga al guardar
        // O implementa lógica extra aquí si deseas filtrar pre-visualización.
        return [
            'disponibles' => $aulas,
            'ocupadas' => collect([])
        ];
    }
}   