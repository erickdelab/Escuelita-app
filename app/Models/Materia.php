<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    protected $primaryKey = 'cod_materia';
    public $incrementing = false; // ← AGREGAR ESTO
    protected $keyType = 'string'; // ← AGREGAR ESTO (si cod_materia es string)

    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['cod_materia', 'nombre', 'credito', 'cadena', 'materia_estado'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function grupos()
    {
        return $this->hasMany(\App\Models\Grupo::class, 'cod_materia', 'cod_materia');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function historials()
    {
        return $this->hasMany(\App\Models\Historial::class, 'cod_materia', 'FK_materia');
    }
}