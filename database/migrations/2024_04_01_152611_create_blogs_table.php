<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('usuario_id');
            $table->string('titulo');
            $table->string('portada');
            $table->text('contenido')->nullable();
            $table->unsignedInteger('tipo');
            $table->string('slug', 64)->unique('blogs_slug_unique');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            
            $table->foreign('usuario_id', 'blogs_usuario_id_foreign')->references('id')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blogs');
    }
}
