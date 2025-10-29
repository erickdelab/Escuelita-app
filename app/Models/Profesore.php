<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class Profesore
 *
 * @property $n_trabajador
 * @property $nombre
 * @property $s_nombre
 * @property $ap_materno
 * @property $ap_paterno
 * @property $correo_institucional
 * @property $FKcod_area
 * @property $created_at
 * @property $updated_at
 *
 * @property Area $area
 * @property Grupo[] $grupos
 * @property Historial[] $historials
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Profesore extends Model
{
    use HasFactory;

    // Configuración para la clave primaria no autoincremental de tipo string
    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'n_trabajador';
    
    protected $perPage = 20;
    
    // === SOLUCIÓN CLAVE PARA LA CACHÉ ===
    // Aunque se usa principalmente para relaciones, ayuda a forzar la recarga del modelo
    // en ciertas situaciones de Eloquent. 
    protected $touches = []; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'n_trabajador', 'nombre', 's_nombre', 'ap_materno', 'ap_paterno', 
        'correo_institucional', 'FKcod_area', 'situacion' // Aseguramos que 'situacion' sea fillable
    ];
    
    // ===============================================
    // LÓGICA DE GENERACIÓN DEL CÓDIGO ÚNICO (INICIALES + NÚMERO)
    // ===============================================

    protected static function boot()
    {
        parent::boot();

        // Escuchar el evento 'creating' (antes de guardar, solo en CREATE)
        static::creating(function ($profesore) {
            // Genera y asigna el n_trabajador si está vacío 
            if (empty($profesore->n_trabajador)) {
                $profesore->n_trabajador = self::generateUniqueNTrabajador($profesore);
            }
        });
    }

    /**
     * Genera un n_trabajador único basado en las iniciales de los apellidos y el nombre.
     */
    public static function generateUniqueNTrabajador(Profesore $profesore)
    {
        // 1. Obtener iniciales (ejemplo: Sergio Díaz López -> SEDILO)
        $nombre = strtoupper(substr($profesore->nombre, 0, 2));
        $apellidoPaterno = strtoupper(substr($profesore->ap_paterno, 0, 2));
        $apellidoMaterno = strtoupper(substr($profesore->ap_materno, 0, 2));
        
        $baseCode = $nombre . $apellidoPaterno . $apellidoMaterno;
        
        $counter = 1;
        $uniqueCode = '';

        do {
            $uniqueCode = $baseCode . $counter;
            $exists = Profesore::where('n_trabajador', $uniqueCode)->exists();
            
            if ($exists) {
                $counter++;
            }
            
        } while ($exists);

        return $uniqueCode;
    }

    // ===============================================
    // RELACIONES
    // ===============================================
    
    /**
     * Relación con el Área.
     */
    public function area()
    {
        // Enlaza FKcod_area (profesores) con cod_area (areas)
        return $this->belongsTo(\App\Models\Area::class, 'FKcod_area', 'cod_area'); 
    }
    
    /**
     * Relación con Grupos.
     */
    public function grupos()
    {
        // La clave foránea en la tabla grupos es el n_trabajador
        return $this->hasMany(\App\Models\Grupo::class, 'n_trabajador', 'n_trabajador');
    }
    
    /**
     * Relación con Historials.
     */
    public function historials()
    {
        // La clave foránea en la tabla historials es FK_prof
        return $this->hasMany(\App\Models\Historial::class, 'FK_prof', 'n_trabajador');
    }
}
