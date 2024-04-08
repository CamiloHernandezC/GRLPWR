<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTutorialesRealizadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutoriales_realizados', function (Blueprint $table) {
            $table->unsignedInteger('tutorial_id');
            $table->unsignedBigInteger('usuario_id');
            $table->timestamps();
            
            $table->foreign('tutorial_id', 'tutoriales_realizados_tutorial_id_foreign')->references('id')->on('tutoriales');
            $table->foreign('usuario_id', 'tutoriales_realizados_usuario_id_foreign')->references('id')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tutoriales_realizados');
    }
}
