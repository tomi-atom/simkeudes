<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tema extends Model
{
    protected $table = 'adm_tema';
    protected $primaryKey = 'id';
    protected $fillable = ['idskema','tema'];

    public function proposal() {
    	return $this->hasMany('App\Proposal', 'id');
    }

    public function skema() {
    	return $this->belongsTo('App\Skema', 'idskema');
    }

    public function topik() {
    	return $this->hasMany('App\Topik', 'id');
    }
}
