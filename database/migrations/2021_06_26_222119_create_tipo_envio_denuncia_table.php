<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoEnvioDenunciaTable extends Migration
{
    /**
     * Esto tendra los estados para saver como enviar la denuncias
     * 1- Envio Directo
     * 2- Se podra enviar Nota + Imagen opcionales
     * 3- la denuncia tendra multiples opciones
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_envio_denuncia', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50);
            $table->string('descripcion', 150)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipo_envio_denuncia');
    }
}
