<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LuaranAkhir extends Model
{
    protected $table = 'tb_luaran_akhir';
    protected $primaryKey = 'id';
    protected $fillable = ['prosalid','status','upload'];
}
