<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    protected $table = 'adm_periode';
    protected $primaryKey = 'id';
    protected $fillable = ['tahun', 'sesi','aktif','tanggal_mulai','tanggal_akhir','tm_rancangan','ta_rancangan'];

    public function proposal() {
    	return $this->hasMany('App\Proposal', 'id');
    }

}
