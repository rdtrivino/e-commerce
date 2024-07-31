<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Services\AvatarService;

class User extends Authenticatable implements HasMedia
{
    use Notifiable, HasRoles, InteractsWithMedia;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Establece el avatar para el usuario.
     *
     * @param mixed $avatar
     * @return void
     */
    public function setAvatar($avatar)
    {
        // Si $avatar es una cadena base64, guarda el avatar en la colección de medios
        if (is_string($avatar) && strpos($avatar, 'data:image/') === 0) {
            // Crear un archivo temporal para la imagen base64
            $image = $this->base64ToImage($avatar);
            $this->clearMediaCollection('avatars');
            $this->addMedia($image)
                ->toMediaCollection('avatars');
        } elseif (is_file($avatar)) {
            // Si $avatar es un archivo, simplemente añade el archivo
            $this->clearMediaCollection('avatars');
            $this->addMedia($avatar)
                ->toMediaCollection('avatars');
        }
    }

    /**
     * Convierte una cadena base64 en una imagen.
     *
     * @param string $base64String
     * @return string
     */
    protected function base64ToImage($base64String)
    {
        $imageData = explode(',', $base64String);
        $imageType = explode(';', explode(':', $imageData[0])[1])[0];
        $imageData = base64_decode($imageData[1]);

        $imageName = 'avatar.' . explode('/', $imageType)[1];

        $path = storage_path('app/public/' . $imageName);
        file_put_contents($path, $imageData);

        return $path;
    }

    /**
     * Obtiene la URL del avatar del usuario.
     *
     * @return string|null
     */
    public function getAvatarUrl()
    {
        $media = $this->getFirstMedia('avatars');
        return $media ? $media->getUrl() : null;
    }

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }
}
