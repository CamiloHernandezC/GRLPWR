<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSesionesClienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sesiones_cliente', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id');
            $table->unsignedInteger('kangoo_id')->nullable();
            $table->unsignedBigInteger('evento_id');
            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_fin');
            $table->dateTime('reservado_hasta')->nullable();
            $table->unsignedInteger('calorias')->nullable();
            $table->boolean('is_courtesy')->default(0);
            $table->unsignedBigInteger('host')->nullable();
            $table->boolean('attended')->default(0);
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            
            $table->foreign('cliente_id', 'sesiones_cliente_cliente_id_foreign')->references('usuario_id')->on('clientes');
            $table->foreign('evento_id', 'sesiones_cliente_evento_id_foreign')->references('id')->on('eventos');
            $table->foreign('host', 'sesiones_cliente_host_foreign')->references('id')->on('usuarios');
            $table->foreign('kangoo_id', 'sesiones_cliente_kangoo_id_foreign')->references('id')->on('kangoos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sesiones_cliente');
    }
}
