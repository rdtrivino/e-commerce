<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Obtener los roles
        $adminRole = Role::where('name', 'admin')->first();
        $userRole = Role::where('name', 'user')->first();

        // Verificar si los roles existen
        if ($adminRole && $userRole) {
            // Crear un usuario admin
            $admin = User::updateOrCreate(
                ['email' => 'admin@example.com'], // Busca por email para evitar duplicados
                [
                    'name' => 'Admin User',
                    'password' => Hash::make('password123'), // Cambia esta contraseña según tus necesidades
                ]
            );
            $admin->assignRole($adminRole);

            // Crear un usuario normal
            $user = User::updateOrCreate(
                ['email' => 'user@example.com'], // Busca por email para evitar duplicados
                [
                    'name' => 'Regular User',
                    'password' => Hash::make('password123'), // Cambia esta contraseña según tus necesidades
                ]
            );
            $user->assignRole($userRole);
        } else {
            $this->command->error('Roles "admin" y "user" no encontrados. Asegúrate de ejecutar RoleAndPermissionSeeder primero.');
        }
    }
}
