<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RancanganPenelitian extends Model
{
    protected $table = 'tb_rancangan_penelitian';
    protected $primaryKey = 'id';
    protected $fillable = ['prosalid','status','upload'];
}
