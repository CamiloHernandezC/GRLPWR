<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhysicalAssessmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('physical_assessments', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->unsignedBigInteger('user_id');
            $table->decimal('muscle', 5, 2)->nullable();
            $table->decimal('visceral_fat', 5, 2)->nullable();
            $table->decimal('body_fat', 5, 2)->nullable();
            $table->decimal('water_level', 5, 2)->nullable();
            $table->decimal('proteins', 5, 2)->nullable();
            $table->decimal('basal_metabolism', 6, 2)->nullable();
            $table->decimal('bone_mass', 5, 2)->nullable();
            $table->decimal('body_score', 5, 2)->nullable();
            $table->timestamps();
            
            $table->foreign('user_id', 'physical_assesments_user_id_foreign')->references('id')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('physical_assessments');
    }
}
