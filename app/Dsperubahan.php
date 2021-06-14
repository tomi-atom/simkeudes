<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dsperubahan extends Model
{
    protected $table = 'ds_perubahan';
    protected $primaryKey = 'id';
    protected $fillable = ['iddosen','nip','sinta','idpddk','struktur','fungsi','hindex','status'];

}
