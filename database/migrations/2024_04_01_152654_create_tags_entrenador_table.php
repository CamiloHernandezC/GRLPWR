<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsEntrenadorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags_entrenador', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedInteger('tag_id');
            $table->timestamps();
            
            $table->foreign('tag_id', 'tags_entrenador_tag_id_foreign')->references('id')->on('tags');
            $table->foreign('usuario_id', 'tags_entrenador_usuario_id_foreign')->references('usuario_id')->on('entrenadores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tags_entrenador');
    }
}
