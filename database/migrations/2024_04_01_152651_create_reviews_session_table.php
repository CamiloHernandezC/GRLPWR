<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsSessionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews_session', function (Blueprint $table) {
            $table->unsignedBigInteger('review_id');
            $table->unsignedBigInteger('session_id');
            $table->timestamps();
            
            $table->foreign('review_id', 'reviews_session_review_id_foreign')->references('id')->on('reviews');
            $table->foreign('session_id', 'reviews_session_session_id_foreign')->references('id')->on('sesiones_cliente');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews_session');
    }
}
