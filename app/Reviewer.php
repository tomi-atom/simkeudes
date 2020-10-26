<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reviewer extends Model
{
    protected $table = 'tb_reviewer';
    protected $primaryKey = 'id';
    protected $fillable = ['iddosen','periode','jenis'];

}
