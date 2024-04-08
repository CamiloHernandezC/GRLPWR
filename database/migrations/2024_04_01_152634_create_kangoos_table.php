<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKangoosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kangoos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('marca');
            $table->string('referencia');
            $table->string('SKU')->unique('kangoos_sku_unique');
            $table->string('talla', 2);
            $table->unsignedInteger('resistencia');
            $table->string('estado');
            $table->string('anotaciones')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kangoos');
    }
}
