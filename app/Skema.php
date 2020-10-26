<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skema extends Model
{
    protected $table = 'adm_skema';
    protected $primaryKey = 'id';
    protected $fillable = ['idprogram','skema','skema','minpeserta','maxpeserta','mindidik1','minjabat1','mindidik2','minjabat2','maxjabat','dana','mintkt','minluaran','kuota'];

    public function proposal() {
    	return $this->hasMany('App\Proposal', 'id');
    }

    public function tema() {
    	return $this->hasMany('App\Tema', 'id');
    }
}
