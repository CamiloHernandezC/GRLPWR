<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->unsignedBigInteger('usuario_id')->unique('clientes_usuario_id_unique');
            $table->double('peso_ideal', 5, 2)->unsigned()->nullable();
            $table->double('talla_zapato', 3, 1)->unsigned()->nullable();
            $table->string('objective', 120)->nullable();
            $table->string('pathology', 120)->nullable();
            $table->enum('channel', ['Facebook', 'Instagram', 'TikTok', 'Google', 'Referido', 'Fisico', 'Otro'])->nullable();
            $table->string('biotipo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientes');
    }
}
