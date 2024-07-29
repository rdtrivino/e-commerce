<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run()
    {
        // Eliminar roles y permisos existentes para evitar duplicados
        Role::query()->delete();
        Permission::query()->delete();

        // Crear roles
        $admin = Role::create(['name' => 'admin']);
        $user = Role::create(['name' => 'user']);

        // Crear permisos
        $permission1 = Permission::create(['name' => 'edit articles']);
        $permission2 = Permission::create(['name' => 'delete articles']);

        // Asignar permisos a roles
        $admin->givePermissionTo([$permission1, $permission2]);
        $user->givePermissionTo($permission1);
    }
}
