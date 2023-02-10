<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    use HasFactory;
    protected $table = 'contactos';

    protected $fillable = [
                    'idUsuario',
                    'idSector',
                    'idCategoria',
                    'status',
                    'genero',
                    'titulo',
                    'nombre',
                    'apellido_paterno',
                    'apellido_materno',
                    'fecha_nacimiento',
                    'cargo',
                    'area',
                    'dependencia',
                    'telefono_celular',
                    'telefono_oficina',
                    'asistente',
                    'domicilio_laboral',
                    'codigo_postal',
                    'cve_ent',
                    'cve_mun',
                    'cve_loc',
                    'email_laboral',
                    'email_personal',
                    'idPartido',
                    'foto',
                    'observaciones',
    ];
}
