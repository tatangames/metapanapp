<?php

namespace Database\Seeders;

use App\Models\EstadoPartida;
use Illuminate\Database\Seeder;

class EstadoPartidaSeeder extends Seeder
{
    /**
     * los 7 estados que puede tener una solicitud para
     * partida de nacimiento
     *
     * @return void
     */
    public function run()
    {
        EstadoPartida::create([
            'nombre_api' => 'Pendiente',
            'nombre_web' => 'Solicitud Pendiente',
            'descripcion' => 'Cuando se recibe una solicitud de partida de nacimiento',
        ]);

        EstadoPartida::create([
            'nombre_api' => 'En Proceso',
            'nombre_web' => 'En Proceso',
            'descripcion' => 'Se esta buscando la partida de nacimiento',
        ]);

        EstadoPartida::create([
            'nombre_api' => 'No Encontrada',
            'nombre_web' => 'No Encontrada',
            'descripcion' => 'La partida de nacimiento no se encuentra',
        ]);

        EstadoPartida::create([
            'nombre_api' => 'Pagar',
            'nombre_web' => 'Esperando Pago',
            'descripcion' => 'El usuario puede procesar el pago',
        ]);

        EstadoPartida::create([
            'nombre_api' => 'Pasar a Traer su partida',
            'nombre_web' => 'El usuario puede pasar a traer la partida de nacimiento',
            'descripcion' => 'Aqui se esta en espera que el usuario llegue a traer la partida',
        ]);

        EstadoPartida::create([
            'nombre_api' => 'Entregada',
            'nombre_web' => 'Entregada',
            'descripcion' => 'La partida de nacimiento fue entrega al usuario ',
        ]);

        EstadoPartida::create([
            'nombre_api' => 'Cancelada',
            'nombre_web' => 'Cancelada',
            'descripcion' => 'La solicitud fue cancelada',
        ]);

    }
}
