<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstadoPartidaTable extends Migration
{
    /**
     * aqui estan los 7 estados que puede tener una solicitud de partida
     *
     * nombre_api es el que se mostrara en la aplicacion
     * nombre_web es el que se mostrara en la pagina web
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estado_partida', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_api', 200);
            $table->string('nombre_web', 200);
            $table->string('descripcion', 200)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estado_partida');
    }
}
