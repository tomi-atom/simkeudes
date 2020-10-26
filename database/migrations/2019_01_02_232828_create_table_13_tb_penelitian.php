<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTable13TbPenelitian extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_penelitian', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('prosalid');
            $table->integer('ketuaid');
            $table->integer('thnkerja');
            $table->integer('tahun_ke');
            $table->integer('status');
            
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
        Schema::drop('tb_penelitian');
    }
}
