<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pendidikan extends Model
{
    public $table = 'pendidikan';
    public $fillable = [
        'id', 'jenis',
    ];



    public function user()
    {
        return $this->belongsTo(\App\User::class,'pendidikan');
    }


}