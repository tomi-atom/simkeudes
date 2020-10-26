<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTable14AdmRumpunilmu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adm_rumpunilmu', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idilmu1');
            $table->string('ilmu1');
            $table->integer('idilmu2');
            $table->string('ilmu2');
            $table->integer('idilmu3');
            $table->string('ilmu3');
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
        Schema::drop('adm_rumpunilmu');
    }
}
