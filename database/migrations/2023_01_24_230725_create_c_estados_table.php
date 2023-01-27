<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCEstadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('c_estados', function (Blueprint $table) {
            $table->id();
            $table->string('cve_ent');
            $table->string('nom_ent');
            $table->string('nom_abr');
            $table->boolean('status');
            $table->timestamps();

            $table->index(['cve_ent']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('c_estados');
    }
}
