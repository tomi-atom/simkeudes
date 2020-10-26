<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $table = 'adm_program';
    protected $primaryKey = 'id';
    protected $fillable = ['kategori','program','aktif'];

    public function proposal() {
    	return $this->hasMany('App\Proposal', 'id');
    }
}
