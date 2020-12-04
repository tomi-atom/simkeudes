<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NilaiAkhirLuaranLainnya extends Model
{
    protected $table = 'n2_laporan_akhir';
    protected $primaryKey = 'id';
    protected $fillable = ['prosalid','iddosen','jenis','skema','kriteria1','kriteria2','kriteria3','kriteria4','kriteria5','kriteria6','kriteria7'];

}
