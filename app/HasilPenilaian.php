<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HasilPenilaian extends Model
{
    protected $table = 'tb_hasil_penilaian';
    protected $primaryKey = 'id';
    protected $fillable = ['prosalid','status','upload'];
}
