<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExercisePrescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercise_prescriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->longText('recommendations');
            $table->timestamps();
            
            $table->foreign('client_id', 'exercise_prescriptions_client_id_foreign')->references('usuario_id')->on('clientes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exercise_prescriptions');
    }
}
