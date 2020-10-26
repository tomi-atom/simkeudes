<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nilai2LaporanKemajuan extends Model
{
    protected $table = 'n2_laporan_kemajuan';
    protected $primaryKey = 'id';
    protected $fillable = ['prosalid','iddosen','jenis','skema','kriteria1','kriteria2','kriteria3','kriteria4','kriteria5','kriteria6','kriteria7'];

}
