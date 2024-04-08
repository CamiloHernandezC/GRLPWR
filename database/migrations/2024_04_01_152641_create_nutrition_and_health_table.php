<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNutritionAndHealthTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nutrition_and_health', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->longText('recommendations');
            $table->timestamps();
            
            $table->foreign('client_id', 'nutrition_and_health_client_id_foreign')->references('usuario_id')->on('clientes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nutrition_and_health');
    }
}
