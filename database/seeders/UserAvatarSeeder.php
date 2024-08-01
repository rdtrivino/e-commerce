<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class UserAvatarSeeder extends Seeder
{
    public function run()
    {
        $avatars = [
            'https://picsum.photos/200/200?image=1',
            'https://picsum.photos/200/200?image=2',
            'https://picsum.photos/200/200?image=3',
        ];

        $users = User::all();

        foreach ($users as $index => $user) {
            $avatarUrl = $avatars[$index % count($avatars)];

            try {
                $response = Http::get($avatarUrl);
                $avatarPath = 'public/' . basename(parse_url($avatarUrl, PHP_URL_PATH));
                Storage::put($avatarPath, $response->body());

                // Guarda la URL en la base de datos
                $user->setAvatar(Storage::url($avatarPath));
            } catch (\Exception $e) {
                \Log::error("No se pudo descargar el avatar desde $avatarUrl: " . $e->getMessage());
            }
        }
    }
}
