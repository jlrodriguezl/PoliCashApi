<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    protected $table = 'movimientos';

    //Many To One
    public function cuentas(){
        return $this->belongsTo('App\Cuenta', 
                        'id_cuenta');
    }
}
