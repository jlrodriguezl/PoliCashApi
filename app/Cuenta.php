<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cuenta extends Model
{
    protected $table = 'cuentas';
    //Many To One
    public function personas(){
        return $this->belongsTo('App\Persona','tipo_id, identificacion');
    }

    //One To Many
    public function movimientos(){
        return $this->hasMany('App\Movimiento');
    }
}
