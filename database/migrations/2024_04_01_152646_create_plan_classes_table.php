<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_classes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('class_type_id');
            $table->unsignedBigInteger('plan_id');
            $table->tinyInteger('equipment_included');
            $table->tinyInteger('unlimited');
            $table->unsignedInteger('number_of_classes')->nullable();
            $table->timestamps();
            
            $table->foreign('class_type_id', 'plan_classes_class_type_id_foreign')->references('id')->on('class_types');
            $table->foreign('plan_id', 'plan_classes_plan_id_foreign')->references('id')->on('plans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plan_classes');
    }
}
