<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTable15TbKeanggota extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('tb_keanggota', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idpenelitian');
            $table->integer('anggotaid');
            $table->integer('peran');
            $table->String('tugas');
            $table->string('status');
            
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
        Schema::drop('tb_keanggota');
    }
}
