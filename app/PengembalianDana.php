<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PengembalianDana extends Model
{
    protected $table = 'tb_pengembalian_dana';
    protected $primaryKey = 'id';
    protected $fillable = ['prosalid','status','upload'];
}
