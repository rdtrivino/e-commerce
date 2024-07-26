<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function assignRole(Request $request, $userId)
    {
        // Validar y encontrar el usuario
        $user = User::findOrFail($userId);

        // Encontrar el rol
        $role = Role::where('name', $request->input('role'))->first();

        if ($user && $role) {
            // Asignar el rol al usuario
            $user->assignRole($role);

            return response()->json(['message' => 'Role assigned successfully.']);
        }

        return response()->json(['message' => 'User or role not found.'], 404);
    }
}
