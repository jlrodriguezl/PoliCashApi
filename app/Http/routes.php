<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
use App\Persona;

Route::get('/', function () {
    $personas = Persona::all();    
    foreach($personas as $persona){       
        echo $persona->nombres."<br />";       
        foreach($persona->cuentas as $cuenta){
            echo $cuenta->saldo;
        }
    }    
    return view('welcome');
});
