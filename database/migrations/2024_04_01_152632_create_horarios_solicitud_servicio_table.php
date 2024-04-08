<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHorariosSolicitudServicioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horarios_solicitud_servicio', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('solicitud_servicio_id');
            $table->date('fecha');
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->unsignedInteger('estado');
            $table->tinyInteger('finalizado_cliente')->nullable();
            $table->tinyInteger('finalizado_entrenador')->nullable();
            $table->unsignedBigInteger('usuario_cancelacion')->nullable();
            $table->dateTime('canceled_at')->nullable();
            $table->timestamps();
            
            $table->foreign('solicitud_servicio_id', 'horarios_solicitud_servicio_solicitud_servicio_id_foreign')->references('id')->on('solicitudes_servicio');
            $table->foreign('usuario_cancelacion', 'horarios_solicitud_servicio_usuario_cancelacion_foreign')->references('id')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('horarios_solicitud_servicio');
    }
}
