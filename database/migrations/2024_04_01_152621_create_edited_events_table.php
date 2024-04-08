<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEditedEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edited_events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('evento_id');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->time('start_hour');
            $table->time('end_hour');
            $table->tinyInteger('deleted');
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->unsignedBigInteger('class_type_id')->nullable();
            $table->string('nombre')->nullable();
            $table->string('descripcion', 500)->nullable();
            $table->string('imagen')->nullable();
            $table->string('info_adicional')->nullable();
            $table->string('lugar')->nullable();
            $table->integer('cupos')->nullable();
            $table->double('precio', 9, 2)->nullable();
            $table->double('precio_sin_implementos', 9, 2)->nullable();
            $table->double('descuento', 9, 2)->nullable();
            $table->double('oferta', 5, 2)->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            
            $table->foreign('branch_id', 'edited_events_branch_id_foreign')->references('id')->on('branches');
            $table->foreign('class_type_id', 'edited_events_class_type_id_foreign')->references('id')->on('class_types');
            $table->foreign('evento_id', 'edited_events_evento_id_foreign')->references('id')->on('eventos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('edited_events');
    }
}
