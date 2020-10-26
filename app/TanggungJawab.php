<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TanggungJawab extends Model
{
    protected $table = 'tb_tanggung_jawab';
    protected $primaryKey = 'id';
    protected $fillable = ['prosalid','status','upload'];
}
