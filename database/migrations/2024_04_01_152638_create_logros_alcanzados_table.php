<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogrosAlcanzadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logros_alcanzados', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('logro_id');
            $table->unsignedBigInteger('usuario_id');
            $table->timestamps();
            
            $table->foreign('logro_id', 'logros_alcanzados_logro_id_foreign')->references('id')->on('logros');
            $table->foreign('usuario_id', 'logros_alcanzados_usuario_id_foreign')->references('id')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logros_alcanzados');
    }
}
