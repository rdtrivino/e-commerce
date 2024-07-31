<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Importar el modelo User

class UserDashboardController extends Controller
{
    public function index()
    {
        // Obtén el usuario autenticado
        $user = Auth::user();

        // Obtén todos los usuarios registrados
        $users = User::all();

        // Pasa el usuario y los usuarios a la vista
        return view('users.index', compact('user', 'users'));
    }
}
