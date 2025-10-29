<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    protected $table = 'grupos';
    protected $primaryKey = 'id_grupo';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_grupo',
        'cod_materia',
        'n_trabajador',
        'semestre'
    ];

    /**
     * Relación con la tabla materias - CORREGIDA
     */
    public function materia()
    {
        return $this->belongsTo(Materia::class, 'cod_materia', 'cod_materia');
    }

    /**
     * Relación con la tabla profesores
     */
    public function profesore()
    {
        return $this->belongsTo(Profesore::class, 'n_trabajador', 'n_trabajador');
    }

    /**
     * Relación con alumnos a través de la tabla pivote
     */
    public function alumnos()
    {
        return $this->belongsToMany(Alumno::class, 'alumno_grupo', 'id_grupo', 'n_control');
    }

    /**
     * Accessor para obtener el nombre de la materia
     */
    public function getNombreMateriaAttribute()
    {
        // Si la relación está cargada, usarla
        if ($this->relationLoaded('materia') && $this->materia) {
            return $this->materia->nombre;
        }
        
        // Si no, buscar directamente
        $materia = Materia::where('cod_materia', $this->cod_materia)->first();
        return $materia ? $materia->nombre : null;
    }

    /**
     * Accessor para verificar si tiene materia asignada
     */
    public function getTieneMateriaAttribute()
    {
        return !empty($this->cod_materia) && $this->nombre_materia;
    }
}