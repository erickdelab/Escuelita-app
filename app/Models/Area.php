<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Area
 *
 * @property $cod_area
 * @property $area
 * @property $jefe_area
 * @property $created_at
 * @property $updated_at
 *
 * @property Profesore $jefe
 * @property Profesore[] $profesores
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Area extends Model
{
    // === CONFIGURACIÓN DE CLAVE PRIMARIA ===
    protected $primaryKey = 'cod_area'; 
    public $incrementing = false;
    protected $keyType = 'integer'; // Asumiendo que cod_area es INT
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['cod_area', 'area', 'jefe_area'];

    // =======================================
    // === RELACIONES ===
    // =======================================

    /**
     * Define la relación con el Jefe de Área (un Profesor específico).
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jefe()
    {
        // Enlaza jefe_area (Area) con n_trabajador (Profesore)
        return $this->belongsTo(\App\Models\Profesore::class, 'jefe_area', 'n_trabajador');
    }

    /**
     * Relación con los Profesores que pertenecen a esta Área.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function profesores()
    {
        // Enlaza cod_area (Area) con FKcod_area (Profesore)
        return $this->hasMany(\App\Models\Profesore::class, 'FKcod_area', 'cod_area');
    }
    
}
