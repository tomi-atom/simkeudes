<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Keanggotaan extends Model
{
    protected $table = 'tb_keanggota';
    protected $primaryKey = 'id';
    protected $fillable = ['idketua','idpenelitian','anggotaid','peran','tugas','setuju'];

}
