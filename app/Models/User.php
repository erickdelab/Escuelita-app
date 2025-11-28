<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * Mass assignable attributes.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'n_control_link',
        'n_trabajador_link',
    ];

    /**
     * Hidden attributes.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Cast definitions.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relación: Usuario → Alumno
     * Une n_control_link (users) con n_control (alumnos)
     */
    public function alumnoData()
    {
        return $this->belongsTo(Alumno::class, 'n_control_link', 'n_control');
    }

    /**
     * Relación: Usuario → Profesor
     */
    public function profesorData()
    {
        return $this->belongsTo(Profesore::class, 'n_trabajador_link', 'n_trabajador');
    }
}
