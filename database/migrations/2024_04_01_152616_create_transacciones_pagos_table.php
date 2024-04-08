<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaccionesPagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transacciones_pagos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('payment_method_id');
            $table->string('ref_payco');
            $table->integer('codigo_respuesta');
            $table->string('respuesta');
            $table->integer('amount');
            $table->longText('data');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            
            $table->foreign('payment_method_id', 'transacciones_pagos_payment_method_id_foreign')->references('id')->on('payment_methods');
            $table->foreign('user_id', 'transacciones_pagos_user_id_foreign')->references('id')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transacciones_pagos');
    }
}
