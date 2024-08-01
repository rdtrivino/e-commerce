<?php

namespace App\Services;

use Laravolt\Avatar\Facade as Avatar;

class AvatarService
{
    public function generateAvatar($name)
    {
        return Avatar::create($name)->toBase64();
    }
}
