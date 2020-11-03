<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NilaiLaporanAkhir extends Model
{
    protected $table = 'n_laporan_akhir';
    protected $primaryKey = 'id';
    protected $fillable = ['prosald','iddosen','jenis','skema','kriteria1','kriteria2','kriteria3','kriteria4','kriteria5','kriteria6','kriteria7','kriteria8','kriteria9','kriteria10','kriteria11','nilai1','nilai2','nilai3','nilai4','nilai5','nilai6','nilai7','nilai8','nilai9','nilai10','nilai11','komentar'];

}
