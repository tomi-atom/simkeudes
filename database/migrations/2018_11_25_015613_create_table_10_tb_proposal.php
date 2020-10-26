<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTable10TbProposal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_proposal', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tahunusul');
            $table->integer('idpeneliti');
            $table->integer('idprogram');
            $table->string('judul');
            $table->integer('tktawal');
            $table->integer('tktakhir');
            $table->integer('idskema');
            $table->integer('idilmu1');
            $table->integer('idilmu2');
            $table->integer('idilmu3');
            $table->integer('idsbk');
            $table->integer('idfokus');
            $table->integer('idtema');
            $table->integer('idtopik');
            $table->integer('tahunkerja');
            $table->integer('lama');

            
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
        Schema::drop('tb_proposal');
    }
}
