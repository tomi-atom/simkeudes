<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    protected $table = 'adm_prodi';
    protected $primaryKey = 'id';
    protected $fillable = ['idfakultas','prodi','sinonim'];

    public function fakultas() {
    	return $this->belongsTo('App\Fakultas', 'idfakultas');
    }

    public function peneliti() {
    	return $this->hasMany('App\Peneliti', 'id');
    }
}
