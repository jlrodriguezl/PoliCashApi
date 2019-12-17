<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Cuenta;

class CuentaController extends Controller
{
    public function consultarCuenta($id){
        $cuenta = Cuenta::where('persona_id', '=', $id)->first();
        return response()->json(
            array(
                'cuenta' => $cuenta,
                'status' => 'success'
            ), 200
        );
    }
}
