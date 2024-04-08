<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFitnessComponentsTable extends Migration
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
            $table->unsignedBigInteger('client_id');
            $table->double('muscular_endurance', 8, 2);
            $table->unsignedInteger('muscle_strength');
            $table->integer('flexibility')->nullable();
            $table->timestamps();
            
            $table->foreign('client_id', 'fitness_components_client_id_foreign')->references('usuario_id')->on('clientes');
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
}
