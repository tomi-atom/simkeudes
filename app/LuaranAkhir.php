<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LuaranAkhir extends Model
{
    protected $table = 'tb_luaran_akhir';
    protected $primaryKey = 'id';
    protected $fillable = ['idluaran','prosalid','status','upload'];
    public function keluaran() {
    	return $this->belongsTo('App\Keluaran', 'idluaran');
    }
}
