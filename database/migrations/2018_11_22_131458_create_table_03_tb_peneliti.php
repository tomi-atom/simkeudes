<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTable03TbPeneliti extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_peneliti', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama');
            $table->string('nidn');
            $table->integer('idpt');
            $table->integer('idfakultas');
            $table->integer('idprodi');
            $table->string('hindex');
            $table->string('sinta');
            $table->integer('status');
            $table->integer('tanggungan');
            $table->integer('pendidikan');
            $table->string('email');
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
        Schema::drop('tb_peneliti');
    }
}
