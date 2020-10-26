<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDokumenRenstrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dp_dokumen_renstra', function (Blueprint $table) {
            $table->increments('id');
            $table->string('keterangan');
            $table->string('jenis');
            $table->string('upload');
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
        Schema::dropIfExists('dp_dokumen_renstra');
    }
}
