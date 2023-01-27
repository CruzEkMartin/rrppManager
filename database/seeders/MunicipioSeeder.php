<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Municipio;

class MunicipioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Municipio::truncate();
  
        $csvFile = fopen(base_path("database/data/municipios_inegi_24012023.csv"), "r");
  
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, "|")) !== FALSE) {
            if (!$firstline) {
                Municipio::create([
                    "cve_ent" => $data['0'],
                    "cve_mun" => $data['1'],
                    "nom_mun" => $data['2'],
                    "status" => "1",
                ]);
            }
            $firstline = false;
        }
        fclose($csvFile);
    }
}
