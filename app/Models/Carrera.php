<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Carrera
 *
 * @property int $id_carrera
 * @property string $nombre_carrera
 * @property int $num_edif
 * @property int $capacidad
 *
 * @property Alumno[] $alumnos
 */
class Carrera extends Model
{
    protected $primaryKey = 'id_carrera'; // Clave primaria personalizada
    public $incrementing = true; // Si es autoincremental, deja esto
    protected $keyType = 'int';
    protected $perPage = 20;

    protected $fillable = [
        'nombre_carrera',
        'num_edif',
        'capacidad',
    ];

    /**
     * Define la relación con Alumnos.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function alumnos()
    {
        // === CORRECCIÓN CLAVE ===
        // Usamos la clave foránea real en la tabla alumnos: 'FKid_carrera'
        return $this->hasMany(\App\Models\Alumno::class, 'FKid_carrera', 'id_carrera');
    }
}
