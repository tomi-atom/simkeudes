<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatatanHarian extends Model
{
    protected $table = 'tb_catatan_harian';
    protected $primaryKey = 'id';
    protected $fillable = ['prosalid','status','upload'];
}
