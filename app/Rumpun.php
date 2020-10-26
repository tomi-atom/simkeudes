<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rumpun extends Model
{
    protected $table = 'adm_rumpunilmu';
    protected $primaryKey = 'id';
    protected $fillable = ['ilmu1', 'ilmu2', 'ilmu3'];

    public function proposal() {
    	return $this->hasMany('App\Proposal', 'id');
    }

    public function peneliti() {
    	return $this->hasMany('App\Peneliti', 'id');
    }
}
