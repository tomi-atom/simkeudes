<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTable17TbSubtansi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_subtansi', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ringkasan');
            $table->string('katakunci');
            $table->string('lbelakang');
            $table->string('literatur');
            $table->string('metode');
            $table->string('jadwal');
            $table->string('pustaka');
            $table->string('unggah');
            $table->string('aktif');
            
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
        Schema::drop('tb_subtansi');
    }
}
