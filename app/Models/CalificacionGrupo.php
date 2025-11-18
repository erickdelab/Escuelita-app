<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalificacionGrupo extends Model
{
    protected $table = 'calificaciones_grupo';
    
    protected $fillable = [
        'alumno_grupo_id',
        'u1', 'u2', 'u3', 'u4', 
        'promedio'
    ];

    // Relación inversa hacia la inscripción (pivote)
    public function alumnoGrupo()
    {
        return $this->belongsTo(AlumnoGrupo::class, 'alumno_grupo_id');
    }
}