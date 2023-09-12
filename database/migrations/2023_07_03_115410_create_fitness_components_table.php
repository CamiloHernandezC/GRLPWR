<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fitness_components', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');//foreign. Is necessary the unsigned to match with the other table
            $table->float('muscular_endurance');
            $table->unsignedInteger('muscle_strength');
            $table->integer('flexibility')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fitness_components');
    }
};
