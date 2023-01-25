<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMunicipiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('c_municipios', function (Blueprint $table) {
            $table->id();
            $table->string('cve_ent');
            $table->string('cve_mun');
            $table->string('nom_mun');
            $table->boolean('status');
            $table->timestamps();

            $table->index(['cve_ent', 'cve_mun']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('c_municipios');
    }
}
