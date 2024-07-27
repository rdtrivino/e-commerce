<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements HasMedia
{
    use Notifiable, HasRoles, InteractsWithMedia;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Asegúrate de tener esta columna en la base de datos
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Set the user's avatar.
     *
     * @param  mixed  $avatar
     * @return void
     */
    public function setAvatar($avatar)
    {
        $this->clearMediaCollection('avatars'); // Limpiar la colección anterior si existe
        $this->addMedia($avatar)
            ->toMediaCollection('avatars');
    }

    /**
     * Get the URL of the user's avatar.
     *
     * @return string|null
     */
    public function getAvatarUrl()
    {
        $media = $this->getFirstMedia('avatars');
        return $media ? $media->getUrl() : null;
    }
}
