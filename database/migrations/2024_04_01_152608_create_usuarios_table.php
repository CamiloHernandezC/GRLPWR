<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('email', 64)->unique('usuarios_email_unique');
            $table->string('password')->nullable();
            $table->string('rol');
            $table->double('nivel', 5, 2)->unsigned()->default(0.00);
            $table->string('nombre', 64);
            $table->string('apellido_1', 64)->nullable();
            $table->string('apellido_2', 64)->nullable();
            $table->string('genero', 1)->nullable();
            $table->string('descripcion', 140)->nullable();
            $table->string('ciudad')->nullable();
            $table->string('telefono', 15)->nullable()->unique('telefono');
            $table->date('fecha_nacimiento')->nullable();
            $table->bigInteger('document_id')->nullable();
            $table->string('eps', 15)->nullable();
            $table->enum('marital_status', ['Soltera', 'Casada', 'Otro'])->nullable();
            $table->string('instagram', 32)->nullable();
            $table->string('occupation', 32)->nullable();
            $table->string('emergency_contact', 64)->nullable();
            $table->string('emergency_phone', 15)->nullable();
            $table->string('foto')->default('default-avatar.png');
            $table->string('slug', 64)->unique('usuarios_slug_unique');
            $table->boolean('verificado')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}
