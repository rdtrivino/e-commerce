<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

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
        $avatars = Media::where('collection_name', 'avatars')->get();

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
            $user->addMedia($request->file('avatar'))->toMediaCollection('avatars');
        } elseif ($request->input('avatar')) {
            $avatarUrl = $request->input('avatar');
            $this->savePredefinedAvatar($user, $avatarUrl);
        }

        $user->assignRole($request->role);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();

        // Obtener avatares predefinidos desde la base de datos
        $avatars = Media::where('collection_name', 'avatars')->get();

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
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        if ($request->hasFile('avatar')) {
            // Eliminar el avatar antiguo si existe
            $user->clearMediaCollection('avatars');
            $user->addMedia($request->file('avatar'))->toMediaCollection('avatars');
        } elseif ($request->input('avatar')) {
            $avatarUrl = $request->input('avatar');
            $this->savePredefinedAvatar($user, $avatarUrl);
        }

        $user->syncRoles($request->role);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
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
        // Descargar la imagen desde la URL y agregarla a la colección de medios
        $imageContent = file_get_contents($avatarUrl);
        $tempImagePath = storage_path('app/public/' . basename($avatarUrl));
        file_put_contents($tempImagePath, $imageContent);

        $user->addMedia($tempImagePath)->toMediaCollection('avatars');

        // Elimina el archivo temporal después de subirlo
        unlink($tempImagePath);
    }
}
