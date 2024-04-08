<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramacionSolicitudServicioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programacion_solicitud_servicio', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('solicitud_servicio_id');
            $table->date('fecha_inicio');
            $table->date('fecha_finalizacion');
            $table->tinyInteger('lunes')->nullable();
            $table->time('hora_inicio_lunes')->nullable();
            $table->time('hora_fin_lunes')->nullable();
            $table->tinyInteger('martes')->nullable();
            $table->time('hora_inicio_martes')->nullable();
            $table->time('hora_fin_martes')->nullable();
            $table->tinyInteger('miercoles')->nullable();
            $table->time('hora_inicio_miercoles')->nullable();
            $table->time('hora_fin_miercoles')->nullable();
            $table->tinyInteger('jueves')->nullable();
            $table->time('hora_inicio_jueves')->nullable();
            $table->time('hora_fin_jueves')->nullable();
            $table->tinyInteger('viernes')->nullable();
            $table->time('hora_inicio_viernes')->nullable();
            $table->time('hora_fin_viernes')->nullable();
            $table->tinyInteger('sabado')->nullable();
            $table->time('hora_inicio_sabado')->nullable();
            $table->time('hora_fin_sabado')->nullable();
            $table->tinyInteger('domingo')->nullable();
            $table->time('hora_inicio_domingo')->nullable();
            $table->time('hora_fin_domingo')->nullable();
            $table->timestamps();
            
            $table->foreign('solicitud_servicio_id', 'programacion_solicitud_servicio_solicitud_servicio_id_foreign')->references('id')->on('solicitudes_servicio');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('programacion_solicitud_servicio');
    }
}
