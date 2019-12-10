<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cuenta extends Model
{
    protected $table = 'cuentas';
    public $timestamps = false;
    
    //One To Many
    public function movimientos(){
        return $this->hasMany('App\Movimiento');        
    }

    //Many To One
    public function persona(){
        return $this->belongsTo('App\Persona', 'persona_id');
    }
}
