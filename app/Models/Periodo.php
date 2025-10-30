<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    protected $table = 'periodos';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'periodo_nombre',
        'anio',
        'codigo_periodo',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'anio' => 'integer'
    ];

    /**
     * Scope para periodos activos
     */
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    /**
     * Scope para periodos por año
     */
    public function scopePorAnio($query, $anio)
    {
        return $query->where('anio', $anio);
    }

    /**
     * Scope para ordenar por año y periodo
     */
    public function scopeOrdenados($query)
    {
        return $query->orderBy('anio', 'desc')
                    ->orderByRaw("FIELD(periodo_nombre, 'Enero-Junio', 'Agosto-Diciembre')");
    }

    /**
     * Obtener el nombre completo del periodo
     */
    public function getNombreCompletoAttribute()
    {
        return "{$this->periodo_nombre} {$this->anio}";
    }

    /**
     * Verificar si el periodo es actual
     */
    public function getEsActualAttribute()
    {
        return $this->activo;
    }
}