<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    protected $table = 'movimientos';
    public $timestamps = false;

    //Many To One
    public function cuenta(){
        return $this->belongsTo('App\Cuenta', 
                        'cuenta_id');
    }
}
