<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Localidad;

class LocalidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Localidad::truncate();
  
        $csvFile = fopen(base_path("database/data/localidades_inegi_24012023.csv"), "r");
  
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, "|")) !== FALSE) {
            if (!$firstline) {
                Localidad::create([
                    "cve_ent" => $data['0'],
                    "cve_mun" => $data['1'],
                    "cve_loc" => $data['2'],
                    "nom_loc" => $data['3'],
                    "ambito" => $data['4'],
                    "latitud" => $data['5'],
                    "longitud" => $data['6'],
                    "lat_decimal" => $data['7'],
                    "lon_decimal" => $data['8'],
                    "nom_loc" => $data['9'],
                    "altitud" => $data['10'],
                    "cve_carta" => $data['11'],
                    "status" => "1",
                ]);
            }
            $firstline = false;
        }
        fclose($csvFile);

    }
}
