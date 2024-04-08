<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodAssesmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('food_assesments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('feeding_relationship')->nullable();
            $table->string('breakfast', 255)->nullable();
            $table->string('mid_morning', 255)->nullable();
            $table->string('lunch', 255)->nullable();
            $table->string('snacks', 255)->nullable();
            $table->string('dinner', 255)->nullable();
            $table->string('supplements', 255)->nullable();
            $table->string('medicines', 255)->nullable();
            $table->string('happy_food', 255)->nullable();
            $table->string('sad_food', 255)->nullable();
            $table->timestamps();
            
            $table->foreign('user_id', 'food_assesments_user_id_foreign')->references('id')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('food_assesments');
    }
}
