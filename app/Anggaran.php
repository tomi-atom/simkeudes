<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Anggaran extends Model
{
    protected $table = 'tb_anggaran';
    protected $primaryKey = 'id';
    protected $fillable = ['batas'];

}
