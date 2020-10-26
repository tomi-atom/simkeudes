<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mataanggaran extends Model
{
    protected $table = 'adm_anggaran';
    protected $primaryKey = 'id';
    protected $fillable = ['jenis','batas','aktif'];

}
