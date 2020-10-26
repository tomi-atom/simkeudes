<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Peneliti extends Model
{
    protected $table = 'tb_peneliti';
    protected $primaryKey = 'id';
    protected $fillable = ['nidn','sinta','nip','nama','email','jantina','idpt','idfakultas','idprodi','idpddk','fungsi','pakar','rumpunilmu','hindex','tanggungan','foto','status','super','aktif'];

    public function universitas() {
    	return $this->belongsTo('App\Universitas', 'idpt');
    }

    public function fakultas() {
        return $this->belongsTo('App\Fakultas', 'idfakultas');
    }

    public function prodi() {
        return $this->belongsTo('App\Prodi', 'idprodi');
    }


    public function pendidikan() {
    	return $this->belongsTo('App\Pendidikan', 'idpddk');
    }

    public function fungsional() {
        return $this->belongsTo('App\Fungsional', 'fungsi');
    }

    public function rumpun() {
        return $this->belongsTo('App\Rumpun', 'rumpunilmu');
    }
    
}
