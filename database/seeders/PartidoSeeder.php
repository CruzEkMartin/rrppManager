<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Partido;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PartidoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // $partido = new Partido([
        //     "name" => "Partido Acción Nacional",
        //     "siglas" => "PAN",
        //     "status" => "1",
        // ]);
        // $partido->saveOrFail();

        DB::table('c_partidos')->insert([

            [
                'name' => 'Partido Acción Nacional',
                'siglas' => 'PAN',
                'status' => '1',
            ],
            [
                'name' => 'Partido Revolucionario Institucional',
                'siglas' => 'PRI',
                'status' => '1',
            ],
            [
                'name' => 'Partido Verde Ecologista de México',
                'siglas' => 'PVEM',
                'status' => '1',
            ],
            [
                'name' => 'Partido del Trabajo',
                'siglas' => 'PT',
                'status' => '1',
            ],
            [
                'name' => 'Movimiento Ciudadano',
                'siglas' => 'MC',
                'status' => '1',
            ],
            [
                'name' => 'Movimiento Regeneración Nacional',
                'siglas' => 'MORENA',
                'status' => '1',
            ]

        ]);

    }
}
