<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoServiciosTable extends Migration
{
    /**
     * Esto sera los primero que vera el cliente al iniciar sesion en la app
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_servicios', function (Blueprint $table) {
            $table->id();

            // nombre del servicio
            $table->string('nombre', 50);

            // descripcion
            $table->string('descripcion', 125)->nullable();

            // imagen del servicio
            $table->string('imagen', 100);

            // si hay problemas se activara y al usuario se mostrara una alerta
            // esto significara que por el momento esta ocupado
            $table->boolean('activo');

            // no aparecera en la vista del usuario
            $table->boolean('visible');

            // posicion que se mostrara
            $table->integer('posicion');

            // fecha de ingreso
            $table->date('fecha');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipo_servicios');
    }
}
