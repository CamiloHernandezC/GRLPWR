<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudesServicioSolicitudesServicioOfertaAceptadaForeignTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('solicitudes_servicio', function (Blueprint $table) {
            $table->foreign('oferta_aceptada', 'solicitudes_servicio_oferta_aceptada_foreign')->references('id')->on('ofrecimientos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('solicitudes_servicio', function(Blueprint $table){
            $table->dropForeign('solicitudes_servicio_oferta_aceptada_foreign');
        });
    }
}
