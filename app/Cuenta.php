<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cuenta extends Model
{
    protected $table = 'cuentas';

    //One To Many
    public function movimientos(){
        return $this->hasMany('App\Movimiento');        
    }

    //Many To One
    public function personas(){
        return $this->belongsTo('App\Persona', 
                        'tipo_id, identificacion');
    }
}
