<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Keluaran extends Model
{
    protected $table = 'adm_luaran';
    protected $primaryKey = 'id';
    protected $fillable = ['kategori','jenis','target','aktif'];

    public function luaran() {
    	return $this->hasMany('App\Luaran', 'id');
    }
    public function luaranakhir() {
    	return $this->hasMany('App\LuaranAkhir', 'id');
    }
}
