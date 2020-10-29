<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnggaranAkhir extends Model
{
    protected $table = 'tb_penggunaan_anggaran_akhir';
    protected $primaryKey = 'id';
    protected $fillable = ['prosalid','status','upload'];
}
