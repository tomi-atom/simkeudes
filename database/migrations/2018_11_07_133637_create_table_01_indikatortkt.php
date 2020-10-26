<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTable01Indikatortkt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('02_indikatortkt', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idbidang');
            $table->integer('leveltkt');
            $table->integer('nourut');
            $table->string('indikator');
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
        Schema::drop('02_indikatortkt');
    }
}
