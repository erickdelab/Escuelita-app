<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSetupSeeder extends Seeder
{
    public function run()
    {
        // 1. Asegurar que existan los roles
        $roleAdmin = Role::firstOrCreate(['name' => 'admin']);
        $roleProfesor = Role::firstOrCreate(['name' => 'profesor']);
        $roleAlumno = Role::firstOrCreate(['name' => 'alumno']);

        // --------------------------------------------------------
        // 2. Configurar SUPER ADMIN
        // --------------------------------------------------------
        // Buscamos tu usuario admin actual o lo creamos
        $admin = User::firstOrCreate(
            ['email' => 'admin@admin.com'], 
            [
                'name' => 'Administrador Sistema',
                'password' => Hash::make('password'), 
            ]
        );
        
        // Asignar rol y limpiar vínculos por seguridad
        $admin->assignRole($roleAdmin);
        $admin->n_control_link = null;
        $admin->n_trabajador_link = null;
        $admin->save();
        
        $this->command->info('✅ Usuario ADMIN configurado: admin@admin.com / password');

        // --------------------------------------------------------
        // 3. Configurar PROFESOR (Carlos Torres - CAMOTO1)
        // --------------------------------------------------------
        $profeUser = User::firstOrCreate(
            ['email' => 'Torres@carlos'], // Correo tomado de tu tabla profesores
            [
                'name' => 'Carlos Torres Moran',
                'password' => Hash::make('CAMOTO1'), // La contraseña será su clave de trabajador
            ]
        );

        // VINCULACIÓN CLAVE: Conectamos el user con el profesor real
        $profeUser->n_trabajador_link = 'CAMOTO1'; 
        $profeUser->save();
        $profeUser->assignRole($roleProfesor);

        $this->command->info('✅ Usuario PROFESOR configurado: Torres@carlos / CAMOTO1');

        // --------------------------------------------------------
        // 4. Configurar ALUMNO (Jimmy Baraquiel - 091234)
        // --------------------------------------------------------
        // Usaremos un correo ficticio ya que en la tabla alumnos no vi correos
        $alumnoUser = User::firstOrCreate(
            ['email' => 'jimmy@alumno.com'], 
            [
                'name' => 'Jimmy Baraquiel',
                'password' => Hash::make('091234'), // La contraseña será su matrícula
            ]
        );

        // VINCULACIÓN CLAVE: Conectamos el user con el alumno real
        $alumnoUser->n_control_link = '091234';
        $alumnoUser->save();
        $alumnoUser->assignRole($roleAlumno);

        $this->command->info('✅ Usuario ALUMNO configurado: jimmy@alumno.com / 091234');
    }
}