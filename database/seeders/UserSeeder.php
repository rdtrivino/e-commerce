<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Http;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Obtener los roles
        $adminRole = Role::where('name', 'admin')->first();
        $userRole = Role::where('name', 'user')->first();

        // Lista de avatares predefinidos
        $avatars = [
            'https://picsum.photos/200/200?image=1',
            'https://picsum.photos/200/200?image=2',
            'https://picsum.photos/200/200?image=3',
        ];

        // Verificar si los roles existen
        if ($adminRole && $userRole) {
            // Crear un usuario admin
            $admin = User::updateOrCreate(
                ['email' => 'admin@example.com'], // Busca por email para evitar duplicados
                [
                    'name' => 'Admin User',
                    'password' => Hash::make('password123'), // Cambia esta contraseña según tus necesidades
                    'avatar' => $this->getRandomAvatar($avatars),
                ]
            );
            $admin->assignRole($adminRole);

            // Crear un usuario normal
            $user = User::updateOrCreate(
                ['email' => 'user@example.com'], // Busca por email para evitar duplicados
                [
                    'name' => 'Regular User',
                    'password' => Hash::make('password123'), // Cambia esta contraseña según tus necesidades
                    'avatar' => $this->getRandomAvatar($avatars),
                ]
            );
            $user->assignRole($userRole);
        } else {
            $this->command->error('Roles "admin" y "user" no encontrados. Asegúrate de ejecutar RoleAndPermissionSeeder primero.');
        }
    }

    /**
     * Obtiene una URL de avatar aleatoria de la lista proporcionada.
     *
     * @param array $avatars
     * @return string
     */
    protected function getRandomAvatar(array $avatars)
    {
        return $avatars[array_rand($avatars)];
    }
}
