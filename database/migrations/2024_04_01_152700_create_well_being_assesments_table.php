<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWellBeingAssesmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('well_being_assesments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('user_id');
            $table->string('body_discomfort', 255)->nullable();
            $table->integer('body_relation')->nullable();
            $table->string('stress', 255)->nullable();
            $table->string('stress_practice', 255)->nullable();
            $table->string('spiritual_belief', 255)->nullable();
            $table->timestamps();
            
            $table->foreign('user_id', 'well_being_assesments_user_id_foreign')->references('id')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('well_being_assesments');
    }
}
