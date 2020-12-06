<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NilaiAkhirLuaranLainnya extends Model
{
    protected $table = 'n_akhir_luaranlainnya';
    protected $primaryKey = 'id';
    protected $fillable = ['prosalid','iddosen','jenis','komentar'];

}
