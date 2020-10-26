<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PenggunaanAnggaran extends Model
{
    protected $table = 'tb_penggunaan_anggaran';
    protected $primaryKey = 'id';
    protected $fillable = ['prosalid','status','upload'];
}
