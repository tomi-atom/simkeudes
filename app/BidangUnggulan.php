<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BidangUnggulan extends Model
{
    protected $table = 'dp_bidang_unggulan';
    protected $primaryKey = 'id';
    protected $fillable = ['keterangan','jenis','upload'];
}
