<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fokus extends Model
{
    protected $table = 'adm_fokus';
    protected $primaryKey = 'id';
    protected $fillable = ['fokus'];

    public function proposal() {
    	return $this->hasMany('App\Proposal', 'id');
    }
}
