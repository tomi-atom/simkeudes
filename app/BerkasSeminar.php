<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BerkasSeminar extends Model
{
    protected $table = 'tb_berkas_seminar';
    protected $primaryKey = 'id';
    protected $fillable = ['prosalid','status','upload'];

}
