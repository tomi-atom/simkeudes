<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fungsional extends Model
{
    protected $table = 'adm_fungsional';
    protected $primaryKey = 'id';
    protected $fillable = ['fungsional'];

    public function peneliti() {
    	return $this->hasMany('App\Peneliti', 'id');
    }
}
