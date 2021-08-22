<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pekerjaan extends Model
{
    public $table = 'pekerjaan';
    public $fillable = [
        'id', 'jenis',
    ];



    public function user()
    {
        return $this->belongsTo(\App\User::class,'pekerjaan');
    }


}