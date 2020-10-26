<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTable27DsPerubahan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ds_perubahan', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sinta');
            $table->string('idpddk');
            $table->string('fungsi');
            $table->string('hindex');
            
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
        Schema::drop('ds_perubahan');
    }
}
