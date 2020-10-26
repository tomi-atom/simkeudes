<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SkSeminar extends Model
{
    protected $table = 'tb_sk_seminar';
    protected $primaryKey = 'id';
    protected $fillable = ['prosalid','status','upload'];
}
