<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// Añadimos los 'use' para las nuevas relaciones
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Horario; // Asegúrate de que este modelo exista

class Grupo extends Model
{
    // 🔹 Nombre de la tabla
    protected $table = 'grupos';

    // 🔹 Clave primaria personalizada
    protected $primaryKey = 'id_grupo';
    public $incrementing = true;
    protected $keyType = 'int';

    // 🔹 Control de timestamps
    public $timestamps = true;

    // 🔹 Campos permitidos para asignación masiva
    protected $fillable = [
        'id_grupo',
        'cod_materia',
        'n_trabajador',
        'semestre',
        'patron',
        'hora_inicio',
        'periodo_id'
    ];

    /* -------------------------------------------------------------------------- */
    /*                               🔹 ROUTE BINDING                             */
    /* -------------------------------------------------------------------------- */
    /**
     * Laravel usará `id_grupo` para resolver el modelo automáticamente
     * en las rutas tipo:
     *   Route::get('/grupos/{grupo}/edit', [GrupoController::class, 'edit']);
     */
    public function getRouteKeyName()
    {
        return 'id_grupo';
    }

    /* -------------------------------------------------------------------------- */
    /*                               🔹 RELACIONES                                */
    /* -------------------------------------------------------------------------- */

    // Relación con la tabla materias
    public function materia()
    {
        return $this->belongsTo(Materia::class, 'cod_materia', 'cod_materia');
    }

    // Relación con la tabla profesores
    public function profesore()
    {
        return $this->belongsTo(Profesore::class, 'n_trabajador', 'n_trabajador');
    }

    // Relación con la tabla periodos
    public function periodo()
    {
        return $this->belongsTo(Periodo::class, 'periodo_id', 'id');
    }

    // Relación muchos a muchos con alumnos
    public function alumnos()
    {
        return $this->belongsToMany(Alumno::class, 'alumno_grupo', 'id_grupo', 'n_control');
    }

    /**
     * --- 🔹 NUEVA RELACIÓN AÑADIDA 🔹 ---
     * Un Grupo tiene muchas entradas de horario.
     *
     * Se conecta a la tabla 'horarios' usando:
     * - Llave Foránea en 'horarios': 'grupo_id'
     * - Llave Local en 'grupos': 'id_grupo' (tu Primary Key)
     */
    public function horarios(): HasMany
    {
        return $this->hasMany(Horario::class, 'grupo_id', 'id_grupo');
    }


    /* -------------------------------------------------------------------------- */
    /*                               🔹 ACCESSORS                                 */
    /* -------------------------------------------------------------------------- */

    public function getNombreMateriaAttribute()
    {
        return $this->materia ? $this->materia->nombre : 'Sin materia asignada';
    }
}