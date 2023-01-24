<?php

namespace Database\Seeders;

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
        // User::factory(10)->create();
        $this->call([PrimerUsuarioSeeder::class]);
        $this->call([EstadoSeeder::class]);
        $this->call([MunicipioSeeder::class]);
        $this->call([LocalidadSeeder::class]);
    }
}
