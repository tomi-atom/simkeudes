<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Posisi extends Model
{
    protected $table = 'adm_status';
    protected $primaryKey = 'id';
    protected $fillable = ['jenis','aktif'];

    public function penelitian() {
    	return $this->hasMany('App\Penelitian', 'id');
    }
}
