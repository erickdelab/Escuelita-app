<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boleta extends Model
{
    use HasFactory;

    protected $fillable = [
        'n_control',
        'cod_materia',
        'periodo',
        'calificacion',
        'oportunidad',
        'n_trabajador',
        'id_grupo'
    ];

    // Relación con alumno
    public function alumno() {
        return $this->belongsTo(Alumno::class, 'n_control', 'n_control');
    }
    
    // Relación con materia
    public function materia() {
        return $this->belongsTo(Materia::class, 'cod_materia', 'cod_materia');
    }

    // ✅ Relación con profesor (Esta es la que faltaba)
    public function profesor() {
        return $this->belongsTo(Profesore::class, 'n_trabajador', 'n_trabajador');
    }
}