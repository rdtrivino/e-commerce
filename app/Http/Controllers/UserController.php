<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();

        // Obtener avatares predefinidos desde la base de datos
        $avatars = User::pluck('avatar')->filter()->unique();

        return view('users.create', compact('roles', 'avatars'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|exists:roles,name',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($request->hasFile('avatar')) {
            // Almacenar el archivo en el disco 'public' y obtener la URL completa
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
            $user->save();
        } elseif ($request->input('avatar')) {
            $avatarUrl = $request->input('avatar');
            $this->savePredefinedAvatar($user, $avatarUrl);
        }

        $user->assignRole($request->role);

        return redirect()->route('users.index')->with('success', 'Usuario creado con éxito.');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();

        // Obtener avatares predefinidos desde la base de datos
        $avatars = User::pluck('avatar')->filter()->unique();

        return view('users.edit', compact('user', 'roles', 'avatars'));
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|exists:roles,name',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->filled('password') ? Hash::make($request->password) : $user->password,
        ]);

        if ($request->hasFile('avatar')) {
            // Eliminar el avatar antiguo si existe
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            // Almacenar el nuevo archivo y obtener la URL completa
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
            $user->save();
        } elseif ($request->input('avatar')) {
            $avatarUrl = $request->input('avatar');
            $this->savePredefinedAvatar($user, $avatarUrl);
        }

        $user->syncRoles($request->role);

        return redirect()->route('users.index')->with('success', 'Usuario actualizado con éxito.');
    }

    public function destroy(User $user)
    {
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Usuario eliminado con éxito.');
    }

    /**
     * Guarda un avatar predefinido en el usuario.
     *
     * @param User $user
     * @param string $avatarUrl
     * @return void
     */
    protected function savePredefinedAvatar(User $user, $avatarUrl)
    {
        // Descargar la imagen desde la URL y guardarla en el almacenamiento
        $imageContent = file_get_contents($avatarUrl);
        $filename = basename($avatarUrl);
        $avatarStoragePath = 'avatars/' . $filename;

        // Guardar la imagen en el almacenamiento
        Storage::disk('public')->put($avatarStoragePath, $imageContent);

        // Actualizar la URL del avatar en el usuario
        $user->avatar = $avatarStoragePath;
        $user->save();
    }
}
