<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComentariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comentarios', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('blog_id');
            $table->unsignedInteger('reply_id')->nullable();
            $table->string('nombre', 64);
            $table->string('email', 64);
            $table->string('comentario');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            
            $table->foreign('blog_id', 'comentarios_blog_id_foreign')->references('id')->on('blogs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comentarios');
    }
}
