<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topik extends Model
{
    protected $table = 'adm_topik';
    protected $primaryKey = 'id';
    protected $fillable = ['idtema','topik'];

    public function proposal() {
    	return $this->hasMany('App\Proposal', 'id');
    }

    public function tema() {
    	return $this->belongsTo('App\Tema', 'idtema');
    }
}
