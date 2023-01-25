<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Localidad extends Model
{
    use HasFactory;

    protected $table = 'c_localidades';

    protected $fillable = [
        'cve_ent', 'cve_mun', 'cve_loc','nom_loc' ,'ambito', 'latitud', 'longitud', 'lat_decimal', 'lon_decimal','nom_loc' ,'altitud', 'cve_carta', 'status',   ];
}
