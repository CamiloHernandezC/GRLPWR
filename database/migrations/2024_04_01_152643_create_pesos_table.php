<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('usuario_id');
            $table->double('peso', 5, 2)->unsigned();
            $table->unsignedInteger('unidad_medida');
            $table->timestamps();
            
            $table->foreign('usuario_id', 'pesos_usuario_id_foreign')->references('usuario_id')->on('clientes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pesos');
    }
}
