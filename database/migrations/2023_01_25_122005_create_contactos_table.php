<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contactos', function (Blueprint $table) {
            $table->id();
            $table->integer('idUsuario');
            $table->integer('idSector');
            $table->integer('idCategoria');
            $table->string('genero');
            $table->string('titulo');
            $table->string('nombre');
            $table->string('apellido_paterno')->nullable();
            $table->string('apellido_materno')->nullable();
            $table->date('fecha_nacimiento');
            $table->string('cargo');
            $table->string('area')->nullable();
            $table->string('dependencia');
            $table->string('telefono_celular');
            $table->string('telefono_oficina')->nullable();
            $table->string('asistente')->nullable();
            $table->string('domicilio_laboral')->nullable();
            $table->integer('codigo_postal')->nullable();
            $table->string('cve_ent')->nullable();
            $table->string('cve_mun')->nullable();
            $table->string('cve_loc')->nullable();
            $table->string('email_laboral')->nullable();
            $table->string('email_personal');
            $table->integer('idPartido')->nullable();
            $table->string('foto')->nullable();
            $table->string('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contactos');
    }
}
