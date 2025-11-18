<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class AlumnoGrupo extends Pivot
{
    protected $table = 'alumno_grupo';
    public $incrementing = true; // Importante porque tiene ID propio

    // Relación con las calificaciones
    public function calificacion()
    {
        return $this->hasOne(CalificacionGrupo::class, 'alumno_grupo_id', 'id');
    }
    
    public function alumno() {
        return $this->belongsTo(Alumno::class, 'n_control', 'n_control');
    }

    public function grupo() {
        return $this->belongsTo(Grupo::class, 'id_grupo', 'id_grupo');
    }
}