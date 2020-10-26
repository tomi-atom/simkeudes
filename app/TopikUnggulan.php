<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TopikUnggulan extends Model
{
    protected $table = 'dp_topik_unggulan';
    protected $primaryKey = 'id';
    protected $fillable = ['keterangan','jenis','upload'];
}
