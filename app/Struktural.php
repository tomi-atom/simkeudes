<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Struktural extends Model
{
    protected $table = 'adm_struktural';
    protected $primaryKey = 'id';
    protected $fillable = ['struktural'];
}
