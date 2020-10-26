<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Luaran extends Model
{
    protected $table = 'tb_luaran';
    protected $primaryKey = 'id';
    protected $fillable = ['idluaran'];

    public function keluaran() {
    	return $this->belongsTo('App\Keluaran', 'idluaran');
    }
}
