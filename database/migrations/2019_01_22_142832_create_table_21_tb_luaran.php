<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTable21TbLuaran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_luaran', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idpenelitian');
            $table->integer('kategori');
            $table->string('jenis');
            $table->string('target');
            $table->string('publish');
            $table->string('urllink');
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
        Schema::drop('tb_luaran');
    }
}
