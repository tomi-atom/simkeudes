<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LaporanKemajuan extends Model
{
    protected $table = 'tb_laporan_kemajuan';
    protected $primaryKey = 'id';
    protected $fillable = ['prosalid','status','upload'];
}
