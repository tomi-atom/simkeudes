<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTable26TbUkurantkt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_ukurtkt', function (Blueprint $table) {
            $table->increments('id');
            $table->string('teknologi');
            $table->string('tkt1');
            $table->string('tkt2');
            $table->string('tkt3');
            $table->string('tkt4');
            $table->string('tkt5');
            $table->string('tkt6');
            $table->string('tkt7');
            $table->string('tkt8');
            $table->string('tkt9');
            
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
        Schema::drop('tb_ukurtkt');
    }
}
