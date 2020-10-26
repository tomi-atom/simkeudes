<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LaporanAkhir extends Model
{
    protected $table = 'tb_laporan_akhir';
    protected $primaryKey = 'id';
    protected $fillable = ['prosalid','status','upload'];
}
