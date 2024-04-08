<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardiovascularRisksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cardiovascular_risks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->enum('risk', ['low', 'medium', 'high']);
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
            
            $table->foreign('client_id', 'cardiovascular_risks_client_id_foreign')->references('usuario_id')->on('clientes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cardiovascular_risks');
    }
}
