<?php

namespace Database\Seeders; // <--- ESTA LÍNEA ES CRUCIAL

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // 1. Crear Roles
        // Usamos firstOrCreate para evitar errores si lo corres dos veces
        $roleAdmin = Role::firstOrCreate(['name' => 'admin']);
        $roleProfesor = Role::firstOrCreate(['name' => 'profesor']);
        $roleAlumno = Role::firstOrCreate(['name' => 'alumno']);

        // 2. Crear Permisos (Ejemplos básicos)
        Permission::firstOrCreate(['name' => 'ver todo']);
        Permission::firstOrCreate(['name' => 'calificar']);
        Permission::firstOrCreate(['name' => 'ver propias calificaciones']);

        // 3. Asignar permisos a roles
        $roleAdmin->syncPermissions(Permission::all());
        $roleProfesor->givePermissionTo('calificar');
        $roleAlumno->givePermissionTo('ver propias calificaciones');
    }
}