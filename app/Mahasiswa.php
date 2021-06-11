<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $table = 'tb_mahasiswa';
    protected $primaryKey = 'id';
    protected $fillable = ['prosalid','ketuaid','nim','nama','jenis_kelamin', 'fakultas'];

}
