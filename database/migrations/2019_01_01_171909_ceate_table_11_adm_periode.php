<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CeateTable11AdmPeriode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adm_periode', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tahun');
            $table->string('sesi');
            $table->integer('jenis');
            $table->integer('aktif');
            
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
        Schema::drop('adm_periode');
    }
}
