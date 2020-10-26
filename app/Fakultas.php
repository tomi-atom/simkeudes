<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
    protected $table = 'adm_fakultas';
    protected $primaryKey = 'id';
    protected $fillable = ['idpt','fakultas','sinonim','dekan','nip','aktif'];
    
    
}
