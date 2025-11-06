<?php
// app/Models/Horario.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Horario extends Model
{
    use HasFactory;

    protected $fillable = [
        'grupo_id',
        'materia_id',
        'profesore_id',
        'aula_id',
        'dia_semana',
        'hora_inicio',
        'hora_fin',
    ];

    protected $casts = [
        'dia_semana' => 'integer',
        'hora_inicio' => 'datetime:H:i', // Facilita el manejo
        'hora_fin' => 'datetime:H:i',
    ];

    // --- Relaciones Inversas (Corregidas) ---

    public function grupo(): BelongsTo
    {
        // Apunta a la llave primaria 'id_grupo' del modelo Grupo
        return $this->belongsTo(Grupo::class, 'grupo_id', 'id_grupo');
    }

    public function materia(): BelongsTo
    {
        // Apunta a la llave 'cod_materia' del modelo Materia
        // Asumiendo que 'materia_id' en 'horarios' se enlaza con 'cod_materia' en 'materias'
        return $this->belongsTo(Materia::class, 'materia_id', 'cod_materia');
    }

    public function profesore(): BelongsTo
    {
        // Apunta a la llave 'n_trabajador' del modelo Profesore
        // Asumiendo que 'profesore_id' en 'horarios' se enlaza con 'n_trabajador' en 'profesores'
        return $this->belongsTo(Profesore::class, 'profesore_id', 'n_trabajador');
    }

    public function aula(): BelongsTo
    {
        // Apunta a la llave 'id' del modelo Aula (que es el default)
        return $this->belongsTo(Aula::class, 'aula_id', 'id');
    }
}