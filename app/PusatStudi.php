<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PusatStudi extends Model
{
    protected $table = 'adm_pusatstudi';
    protected $primaryKey = 'id';
    protected $fillable = ['pusatstudi','aktif'];

    public function proposal() {
    	return $this->hasMany('App\Proposal', 'id');
    }

    public function tema() {
        return $this->belongsTo('App\PusatStudi', 'idpusatstudi');
    }
}
