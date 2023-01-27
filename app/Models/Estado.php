<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    use HasFactory;

    protected $table = 'c_estados';

    protected $fillable = [
        'cve_ent', 'nom_ent', 'nom_abr', 'status',   ];
}
