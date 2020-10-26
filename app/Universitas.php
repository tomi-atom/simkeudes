<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Universitas extends Model
{
    protected $table = 'adm_pt';
    protected $primaryKey = 'id';
    protected $fillable = ['pt'];

    public function peneliti() {
    	return $this->hasMany('App\Peneliti', 'id');
    }
    
    public function fakultas() {
    	return $this->hasMany('App\Fakultas', 'id');
    }
    
}
