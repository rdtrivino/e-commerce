<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid'); // Añadir esta línea para la columna uuid
            $table->string('model_type', 191);
            $table->unsignedBigInteger('model_id');
            $table->string('collection_name');
            $table->string('name');
            $table->string('file_name');
            $table->string('mime_type');
            $table->string('disk');
            $table->string('conversions_disk')->nullable();
            $table->integer('size');
            $table->text('manipulations')->nullable();
            $table->text('custom_properties')->nullable();
            $table->text('generated_conversions')->nullable();
            $table->unsignedInteger('order_column')->nullable();
            $table->text('responsive_images')->nullable(); // Añadir esta línea para la columna responsive_images
            $table->timestamps();

            $table->index(['model_type', 'model_id'], 'media_model_type_model_id_index');
            $table->unique('uuid'); // Asegurarse de que 'uuid' sea único
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media');
    }
}
