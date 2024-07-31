<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MediaSeeder extends Seeder
{
    public function run()
    {
        $avatarsPath = storage_path('app/public/avatars');
        $files = array_diff(scandir($avatarsPath), array('..', '.'));

        foreach ($files as $file) {
            $filePath = $avatarsPath . '/' . $file;
            $fileSize = filesize($filePath);
            $fileMime = mime_content_type($filePath);

            DB::table('media')->insert([
                'model_type' => 'App\Models\User', // Ajusta el tipo de modelo si es necesario
                'model_id' => 1, // Cambia el ID del modelo según sea necesario
                'collection_name' => 'avatars',
                'name' => $file,
                'file_path' => 'storage/avatars/' . $file,
                'mime_type' => $fileMime,
                'size' => $fileSize,
                'disk' => 'public',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
