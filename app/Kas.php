<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kas extends Model
{
    public $fillable = [
        'user_id', 'jenis', 'kode_transaksi', 'debit', 'kredit', 'saldo', 'tanggal', 'pengelola',
    ];

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function scopeSearch($query, $q)
    {
        return $query->whereHas('user', function($query) use ($q) {
                    $query->where('name', 'like', '%' . $q . '%')
                        ->orWhere('no_anggota', 'like', '%' . $q . '%')
                        ->orWhere('email', 'like', '%' . $q . '%');
                });
    }
}
