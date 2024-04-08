<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfrecimientosOfrecimientosSolicitudServicioIdForeignTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ofrecimientos', function (Blueprint $table) {
            $table->foreign('solicitud_servicio_id', 'ofrecimientos_solicitud_servicio_id_foreign')->references('id')->on('solicitudes_servicio');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ofrecimientos', function(Blueprint $table){
            $table->dropForeign('ofrecimientos_solicitud_servicio_id_foreign');
        });
    }
}
