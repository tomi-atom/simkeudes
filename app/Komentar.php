<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    protected $table = 'tb_komentar';
    protected $primaryKey = 'id';
    protected $fillable = ['idpelaksanaan','idsubpelaksanaan','prosalid','idreviewer','status','komentar'];
}
