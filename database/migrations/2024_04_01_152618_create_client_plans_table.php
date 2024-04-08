<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_plans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('plan_id');
            $table->unsignedInteger('remaining_shared_classes')->nullable();
            $table->boolean('equipment_included')->default(1);
            $table->dateTime('expiration_date');
            $table->unsignedInteger('payment_id');
            $table->boolean('scheduled_renew_msg')->default(0);
            $table->timestamps();
            
            $table->foreign('client_id', 'client_plans_client_id_foreign')->references('id')->on('usuarios');
            $table->foreign('payment_id', 'client_plans_payment_id_foreign')->references('id')->on('transacciones_pagos');
            $table->foreign('plan_id', 'client_plans_plan_id_foreign')->references('id')->on('plans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_plans');
    }
}
