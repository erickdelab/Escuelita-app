<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = 'areas';
    protected $primaryKey = 'cod_area';
    public $incrementing = true; // Asegúrate de que esto sea TRUE
    protected $keyType = 'int';  // Y el tipo sea 'int' si es numérico

    protected $fillable = [
        // 'cod_area', // REMOVER de fillable si es autoincremental
        'area', 
        'jefe_area'
    ];

    /**
     * Relación con el profesor jefe del área
     */
    public function jefe()
    {
        return $this->belongsTo(Profesore::class, 'jefe_area', 'n_trabajador');
    }

    /**
     * Relación con los profesores que pertenecen a esta área
     */
    public function profesores()
    {
        return $this->hasMany(Profesore::class, 'FKcod_area', 'cod_area');
    }
}