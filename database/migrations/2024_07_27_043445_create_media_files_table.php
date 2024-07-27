<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaTable extends Migration
{
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('model_type', 25); // Longitud reducida
            $table->unsignedBigInteger('model_id');
            $table->string('collection_name');
            $table->text('name');
            $table->string('file_name');
            $table->string('mime_type');
            $table->integer('disk');
            $table->integer('conversions_disk');
            $table->unsignedBigInteger('size');
            $table->text('manipulations')->nullable();
            $table->text('custom_properties')->nullable();
            $table->timestamps();

            // Crear un índice más corto
            $table->index(['model_type', 'model_id'], 'media_model_type_model_id_index');
        });
    }

    public function down()
    {
        Schema::dropIfExists('media');
    }
}
