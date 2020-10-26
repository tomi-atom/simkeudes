<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bidangtkt extends Model
{
    protected $table = 'adm_bidangtkt';
    protected $primaryKey = 'id';
    protected $fillable = ['bidang','aktif'];

    public function indikator() {
    	return $this->hasMany('App\Bidangtkt', 'id');
    }
}
