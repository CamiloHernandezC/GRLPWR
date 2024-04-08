<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRemainingClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('remaining_classes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_plan_id');
            $table->unsignedBigInteger('class_type_id');
            $table->tinyInteger('equipment_included');
            $table->tinyInteger('unlimited');
            $table->unsignedInteger('remaining_classes')->nullable();
            $table->timestamps();
            
            $table->foreign('class_type_id', 'remaining_classes_class_type_id_foreign')->references('id')->on('class_types');
            $table->foreign('client_plan_id', 'remaining_classes_client_plan_id_foreign')->references('id')->on('client_plans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('remaining_classes');
    }
}
