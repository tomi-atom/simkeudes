<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DokumenRenstra extends Model
{
    protected $table = 'dp_dokumen_renstra';
    protected $primaryKey = 'id';
    protected $fillable = ['keterangan','jenis','upload'];
}
