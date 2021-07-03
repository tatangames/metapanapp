<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBancoTable extends Migration
{
    /**
     * Se registra solo en el ID 1
     * los datos para utilizar pasarela de pago wompi
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banco', function (Blueprint $table) {
            $table->id();
            $table->boolean('activo');

            // token de seguridad para procesar pagos
            $table->string('token', 2500)->nullable();
            $table->dateTime('fecha_token')->nullable();

            // comision a cobrar extra por la transaccion
            $table->decimal('comision', 6,2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banco');
    }
}
