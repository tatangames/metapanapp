<?php

namespace Database\Seeders;

use App\Models\Banco;
use Illuminate\Database\Seeder;

class BancoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Banco::create([
            'activo' => '1',
            'token' => '',
            'fecha_token' => '2021-06-24',
            'comision' => '3.00',
        ]);
    }
}
