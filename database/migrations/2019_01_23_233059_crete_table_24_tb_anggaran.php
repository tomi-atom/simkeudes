<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreteTable24TbAnggaran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_anggaran', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('proposalid');
            $table->integer('anggaranid');
            $table->string('item');
            $table->string('satuan');
            $table->integer('volume');
            $table->integer('biaya');
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
        Schema::drop('tb_anggaran');
    }
}
