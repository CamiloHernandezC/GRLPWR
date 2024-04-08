<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingPreferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_preferences', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->unsignedBigInteger('user_id');
            $table->enum('training_frequency', ['nunca', '1', '2-3', '+3'])->nullable();
            $table->enum('intensity', ['low', 'medium', 'high'])->nullable();
            $table->string('music', 255)->nullable();
            $table->timestamps();
            
            $table->foreign('user_id', 'training_preferences_user_id_foreign')->references('id')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('training_preferences');
    }
}
