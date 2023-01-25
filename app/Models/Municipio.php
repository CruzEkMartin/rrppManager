<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    use HasFactory;

    protected $table = 'c_municipios';

    protected $fillable = [
        'cve_ent', 'cve_mun', 'nom_mun', 'status',   ];

}
