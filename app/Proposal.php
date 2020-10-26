<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    protected $table = 'tb_proposal';
    protected $primaryKey = 'id';
    protected $fillable = ['periodeusul','idprogram', 'idskema', 'idilmu', 'idfokus', 'idtema', 'idtopik'];

    public function periode() {
    	return $this->belongsTo('App\Periode', 'periodeusul');
    }

    public function program() {
        return $this->belongsTo('App\Program', 'idprogram');
    }

    public function skema() {
    	return $this->belongsTo('App\Skema', 'idskema');
    }

    public function rumpun() {
        return $this->belongsTo('App\Rumpun', 'idilmu');
    }

    public function fokus() {
        return $this->belongsTo('App\Fokus', 'idfokus');
    }

    public function tema() {
        return $this->belongsTo('App\Tema', 'idtema');
    }

    public function topik() {
        return $this->belongsTo('App\Topik', 'idtopik');
    }

}
