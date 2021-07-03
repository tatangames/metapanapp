<?php

namespace Database\Seeders;

use App\Models\TipoEnvioDenuncia;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(RolesSeeder::class);
        $this->call(UsuariosSeeder::class);
        $this->call(BancoSeeder::class);
        $this->call(TipoPartidaSeeder::class);
        $this->call(EstadoPartidaSeeder::class);
        $this->call(EstadoDenunciaSeeder::class);
        $this->call(TipoEnvioDenunciaSeeder::class);
    }
}
