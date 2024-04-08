<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudesServicioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitudes_servicio', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('usuario_id');
            $table->string('titulo', 32);
            $table->string('descripcion', 140)->nullable();
            $table->string('ciudad', 64);
            $table->string('direccion', 140)->nullable();
            $table->double('latitud', 10, 6);
            $table->double('longitud', 10, 6);
            $table->tinyInteger('tipo');
            $table->unsignedInteger('estado');
            $table->unsignedInteger('oferta_aceptada')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            
            $table->foreign('usuario_id', 'solicitudes_servicio_usuario_id_foreign')->references('usuario_id')->on('clientes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solicitudes_servicio');
    }
}
