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

    // Relación opcional para ver datos del alumno desde la boleta
    public function alumno() {
        return $this->belongsTo(Alumno::class, 'n_control', 'n_control');
    }
    
    // Relación opcional con materia
    public function materia() {
        return $this->belongsTo(Materia::class, 'cod_materia', 'cod_materia');
    }
}