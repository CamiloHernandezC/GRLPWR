<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaccionesPendientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transacciones_pendientes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_transaccion');
            $table->tinyInteger('verificada');
            $table->timestamps();
            
            $table->foreign('id_transaccion', 'transacciones_pendientes_id_transaccion_foreign')->references('id')->on('transacciones_pagos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transacciones_pendientes');
    }
}
