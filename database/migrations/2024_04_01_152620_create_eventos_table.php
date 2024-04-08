<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->unsignedBigInteger('branch_id');
            $table->unsignedBigInteger('class_type_id');
            $table->string('descripcion', 500)->nullable();
            $table->string('imagen');
            $table->string('info_adicional', 250)->nullable();
            $table->string('lugar');
            $table->integer('cupos');
            $table->double('precio', 9, 2);
            $table->double('precio_sin_implementos', 9, 2)->nullable();
            $table->double('descuento', 9, 2)->nullable();
            $table->double('oferta', 5, 2)->nullable();
            $table->tinyInteger('repeatable');
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->time('start_hour')->nullable();
            $table->time('end_hour')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            
            $table->foreign('branch_id', 'eventos_branch_id_foreign')->references('id')->on('branches');
            $table->foreign('class_type_id', 'eventos_class_type_id_foreign')->references('id')->on('class_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eventos');
    }
}
