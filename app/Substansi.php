<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Substansi extends Model
{
    protected $table = 'tb_subtansi';
    protected $primaryKey = 'id';
    protected $fillable = ['unggah'];
}
