<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlotingReviwer extends Model
{
    protected $table = 'tb_ploting_reviewer';
    protected $primaryKey = 'id';
    protected $fillable = ['prosalid','iddosen'];
}
