<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('branch_id');
            $table->string('image');
            $table->unsignedInteger('number_of_shared_classes')->nullable();
            $table->unsignedInteger('duration_days');
            $table->double('price', 9, 2)->unsigned();
            $table->double('discount', 9, 2)->nullable();
            $table->double('offer', 5, 2)->nullable();
            $table->string('description')->nullable();
            $table->dateTime('expiration_date')->nullable();
            $table->unsignedInteger('available_plans')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            
            $table->foreign('branch_id', 'plans_branch_id_foreign')->references('id')->on('branches');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plans');
    }
}
