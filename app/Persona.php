<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'personas';   
    public $timestamps = false;

    //One To Many
    public function cuentas(){
        return $this->hasMany('App\Cuenta');
    }
}
