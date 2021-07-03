<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiciosAlcaldiaTable extends Migration
{
    /**
     * Registra los diferentes servicios de la alcaldia
     * ejemplo: solicitud partida de nacimiento
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicios_alcaldia', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('imagen', 100);

            // si el servicio esta activo por el momento
            $table->boolean('activo');

            // si estara visible en la app
            $table->boolean('visible');

            // posiciones
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
        Schema::dropIfExists('servicios_alcaldia');
    }
}
