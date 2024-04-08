<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWheelOfLivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wheel_of_lives', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('health');
            $table->string('reason_health', 255)->nullable();
            $table->unsignedInteger('personal_growth');
            $table->string('reason_personal_growth', 255)->nullable();
            $table->unsignedInteger('home');
            $table->string('reason_home', 255)->nullable();
            $table->unsignedInteger('family_and_friends');
            $table->string('reason_family_and_friends', 255)->nullable();
            $table->unsignedInteger('love');
            $table->string('reason_love', 255)->nullable();
            $table->unsignedInteger('leisure');
            $table->string('reason_leisure', 255)->nullable();
            $table->unsignedInteger('work');
            $table->string('reason_work', 255)->nullable();
            $table->unsignedInteger('money');
            $table->string('reason_money', 255)->nullable();
            $table->timestamps();
            
            $table->foreign('user_id', 'wheel_of_lives_user_id_foreign')->references('id')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wheel_of_lives');
    }
}
