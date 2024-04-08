<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntrenadoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entrenadores', function (Blueprint $table) {
            $table->unsignedBigInteger('usuario_id')->unique('entrenadores_usuario_id_unique');
            $table->string('banco', 140)->nullable();
            $table->tinyInteger('tipo_cuenta')->nullable();
            $table->string('numero_cuenta', 32)->nullable();
            $table->unsignedInteger('tarifa')->nullable();
            $table->timestamps();
            
            $table->foreign('usuario_id', 'entrenadores_usuario_id_foreign')->references('id')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entrenadores');
    }
}
