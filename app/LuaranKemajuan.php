<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LuaranKemajuan extends Model
{
    
    protected $table = 'tb_luaran_kemajuan';
    protected $primaryKey = 'id';
    protected $fillable = ['idketua','id_penelitian','idluaran','kategori','publish','urllink','upload',];

    public function keluaran() {
    	return $this->belongsTo('App\Keluaran', 'idluaran');
    }
}
