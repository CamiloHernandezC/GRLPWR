<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews_user', function (Blueprint $table) {
            $table->unsignedBigInteger('review_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            
            $table->foreign('review_id', 'reviews_user_review_id_foreign')->references('id')->on('reviews');
            $table->foreign('user_id', 'reviews_user_user_id_foreign')->references('id')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews_user');
    }
}
