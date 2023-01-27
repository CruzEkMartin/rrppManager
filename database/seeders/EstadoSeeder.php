<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Estado;

class EstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Estado::truncate();
  
        $csvFile = fopen(base_path("database/data/estados_inegi_24012023.csv"), "r");
  
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, "|")) !== FALSE) {
            if (!$firstline) {
                Estado::create([
                    "cve_ent" => $data['0'],
                    "nom_ent" => $data['1'],
                    "nom_abr" => $data['2'],
                    "status" => "1",
                ]);
            }
            $firstline = false;
        }
        fclose($csvFile);
    }
}
