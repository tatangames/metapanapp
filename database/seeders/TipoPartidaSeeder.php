<?php

namespace Database\Seeders;

use App\Models\TipoPartida;
use Illuminate\Database\Seeder;

class TipoPartidaSeeder extends Seeder
{
    /**
     * Los 2 tipos de partidas que hay
     *
     * @return void
     */
    public function run()
    {
        TipoPartida::create([
            'nombre' => 'Normal',
        ]);

        TipoPartida::create([
            'nombre' => 'Certificada',
        ]);
    }
}
