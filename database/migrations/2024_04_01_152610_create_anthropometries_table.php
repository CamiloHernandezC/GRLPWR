<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnthropometriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anthropometries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->unsignedInteger('heart_rate')->nullable();
            $table->unsignedInteger('systolic_pressure')->nullable();
            $table->unsignedInteger('diastolic_pressure')->nullable();
            $table->double('hip', 8, 2)->unsigned()->nullable();
            $table->double('abdominal_perimeter', 8, 2)->unsigned()->nullable();
            $table->double('back', 8, 2)->unsigned()->nullable();
            $table->double('chest', 8, 2)->unsigned()->nullable();
            $table->double('right_thigh', 8, 2)->unsigned()->nullable();
            $table->double('left_thigh', 8, 2)->unsigned()->nullable();
            $table->double('right_arm', 8, 2)->unsigned()->nullable();
            $table->double('left_arm', 8, 2)->unsigned()->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
            
            $table->foreign('client_id', 'anthropometries_client_id_foreign')->references('usuario_id')->on('clientes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('anthropometries');
    }
}
