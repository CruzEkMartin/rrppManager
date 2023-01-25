<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCLocalidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('c_localidades', function (Blueprint $table) {
            $table->id();
            $table->string('cve_ent');
            $table->string('cve_mun');
            $table->string('cve_loc');
            $table->string('nom_loc');
            $table->string('ambito');
            $table->string('latitud');
            $table->string('longitud');
            $table->string('lat_decimal');
            $table->string('lon_decimal');
            $table->string('altitud');
            $table->string('cve_carta');
            $table->boolean('status');
            $table->timestamps();

            $table->index(['cve_ent', 'cve_mun', 'cve_loc']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('c_localidades');
    }
}
