<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfrecimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ofrecimientos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('solicitud_servicio_id');
            $table->unsignedBigInteger('usuario_id');
            $table->double('precio', 10, 2);
            $table->unsignedInteger('estado')->default(0);
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
        Schema::dropIfExists('ofrecimientos');
    }
}
