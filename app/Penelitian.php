<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penelitian extends Model
{
    protected $table = 'tb_penelitian';
    protected $primaryKey = 'id';
    protected $fillable = ['status'];

    public function posisi() {
    	return $this->belongsTo('App\Posisi', 'status');
    }

}
