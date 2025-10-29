<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Alumno
 *
 * @property $n_control
 * @property $nombre
 * @property $s_nombre
 * @property $ap_pat
 * @property $ap_mat
 * @property $fech_nac
 * @property $genero
 * @property $FKid_carrera
 * @property $situacion
 * @property $semestre
 * @property $created_at
 * @property $updated_at
 *
 * @property Carrera $carrera
 * @property Grupo[] $grupos
 * @property Historial[] $historials
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Alumno extends Model
{
    // *** CORRECCIÓN CRÍTICA PARA CLAVES NO PREDETERMINADAS ***
    protected $primaryKey = 'n_control';
    public $incrementing = false; // El n_control es manual, no se incrementa solo
    protected $keyType = 'string'; // El n_control es una cadena numérica/texto
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
      protected $fillable = [
        'n_control',
        'nombre',
        's_nombre',
        'ap_pat',
        'ap_mat',
        'fech_nac',
        'genero',
        'FKid_carrera',
        'situacion',
        'semestre',
        'promedio_general', // ✅ NUEVO
    ];


    // =======================================
    // === RELACIONES ===
    // =======================================

    /**
     * Define la relación: Un Alumno pertenece a una Carrera.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function carrera()
    {
        // Se enlaza FKid_carrera (en esta tabla) con id_carrera (en la tabla 'carreras').
        return $this->belongsTo(\App\Models\Carrera::class, 'FKid_carrera', 'id_carrera');
    }
    
    /**
     * Define la relación: Un Alumno tiene muchos Historiales.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function historials()
    {
        // Se enlaza n_control (en esta tabla) con FKn_control (en la tabla 'historials').
        return $this->hasMany(\App\Models\Historial::class, 'FKn_control', 'n_control');
    }

    /**
 * Define la relación Muchos a Muchos con Grupos.
 * Esto representa la inscripción del alumno en un grupo.
 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
 */
public function grupos()
{
    return $this->belongsToMany(\App\Models\Grupo::class, 'alumno_grupo', 'n_control', 'id_grupo')
                ->withPivot('oportunidad') // ✅ Agregar este campo
                ->withTimestamps();
}
}