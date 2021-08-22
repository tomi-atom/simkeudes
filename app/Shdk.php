<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shdk extends Model
{
    public $table = 'shdk';
    public $fillable = [
        'id', 'jenis',
    ];



    public function user()
    {
        return $this->belongsTo(\App\User::class,'shdk');
    }


}