<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pendidikan extends Model
{
    protected $table = 'adm_pendidikan';
    protected $primaryKey = 'id';
    protected $fillable = ['pendidikan'];

    public function peneliti() {
    	return $this->hasMany('App\Peneliti', 'id');
    }
}
