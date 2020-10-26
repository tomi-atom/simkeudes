<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Indikatortkt extends Model
{
    protected $table = 'adm_indikatortkt';
    protected $primaryKey = 'id';
    protected $fillable = ['idbidang', 'leveltkt', 'nourut', 'indikator'];

    public function bidang() {
    	return $this->belongsTo('App\Bidangtkt');
    }
}
