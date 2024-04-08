<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKangooPartesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kangoo_partes', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('parte_id');
            $table->unsignedInteger('kangoo_id');
            $table->date('fecha_instalacion');
            $table->date('ultimo_mantenimiento');
            $table->date('proximo_mantenimiento');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            
            $table->foreign('kangoo_id', 'kangoo_partes_kangoo_id_foreign')->references('id')->on('kangoos');
            $table->foreign('parte_id', 'kangoo_partes_parte_id_foreign')->references('id')->on('partes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kangoo_partes');
    }
}
