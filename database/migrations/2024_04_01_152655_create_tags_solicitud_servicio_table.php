<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsSolicitudServicioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags_solicitud_servicio', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tag_id');
            $table->unsignedInteger('solicitud_servicio_id');
            $table->timestamps();
            
            $table->foreign('solicitud_servicio_id', 'tags_solicitud_servicio_solicitud_servicio_id_foreign')->references('id')->on('solicitudes_servicio');
            $table->foreign('tag_id', 'tags_solicitud_servicio_tag_id_foreign')->references('id')->on('tags');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tags_solicitud_servicio');
    }
}
