<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistroPagoTable extends Migration
{
    /**
     * Registro de un pago en general
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registro_pago', function (Blueprint $table) {
            $table->id();

            // fecha
            $table->dateTime('fecha');

            // cuanto pagara en total es decir: aqui viene multiplicado por la comision ya
            // ejem: partida $2.10 * 3% = $2.16

            // sino aplica comision, en el campo comision aparecera 0
            $table->decimal('pago_total', 10, 2);

            // la comision que se le quiera poner, el banco wompi por ejemplo: cobra
            // 2.85%
            $table->decimal('comision', 10, 2);

            // id que da la transaccion (por si acaso se guarda este campo)
            $table->string('idtransaccion', 200)->nullable();

            // codigo que da la transaccion (por si acaso se guarda este campo)
            $table->string('codigo', 200)->nullable();

            // si la transaccion fue real 1, o modo prueba: 0
            $table->boolean('esreal');

            // si la transaccion fue aprobada o reprobada por cualquier cosa
            $table->boolean('esaprobada');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registro_pago');
    }
}
