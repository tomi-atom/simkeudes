<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    protected $table = 'adm_periode';
    protected $primaryKey = 'id';
    protected $fillable = ['tahun', 'sesi','program','aktif','tanggal_mulai','tanggal_akhir','tm_perbaikan','ta_perbaikan','tm_laporankemajuan','ta_laporankemajuan','tm_laporanakhir','ta_laporanakhir'];

    public function proposal() {
    	return $this->hasMany('App\Proposal', 'id');
    }
    public function idprogram() {
        return $this->belongsTo('App\Program', 'program');
    }

}
