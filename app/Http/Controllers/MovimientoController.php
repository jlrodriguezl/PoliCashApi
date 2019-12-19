<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Movimiento;
use App\Cuenta;
class MovimientoController extends Controller
{
    public function registrarMov(Request $request)
    {
       //Recibir lo que viene por POST
       //Por defecto será null si no llega
       $json = $request->input('json', null);
       //Codificar el json en un objeto reconocido por PHP
       $params = json_decode($json);
        
       //Asignar valores a variables php
       $tipo_movi = (!is_null($json) && isset($params->tipoMovimiento)) ? $params->tipoMovimiento : null;
       $fecha_movi = (!is_null($json) && isset($params->fechaMovimiento)) ? $params->fechaMovimiento : null;
       $desc_movi = (!is_null($json) && isset($params->descMovimiento)) ? $params->descMovimiento : null;
       $valor_movi = (!is_null($json) && isset($params->valorMovimiento)) ? $params->valorMovimiento : null;
       $estado_movi = (!is_null($json) && isset($params->estadoMovimiento)) ? $params->estadoMovimiento : null;
       $cod_aut_movi = (!is_null($json) && isset($params->codigoAuth)) ? $params->codigoAuth : null;
       $detalle_movi = (!is_null($json) && isset($params->detMovimiento)) ? $params->detMovimiento : null;
       $cuenta_id = (!is_null($json) && isset($params->idCuenta)) ? $params->idCuenta : null;
       
       //Crear el movimiento       
       $movimiento = new Movimiento();
       $movimiento->tipo_movi = $tipo_movi;
       $movimiento->fecha_movi = $fecha_movi;
       $movimiento->desc_movi = $desc_movi;
       $movimiento->valor_movi = $valor_movi;
       $movimiento->estado_movi = $estado_movi;
       $movimiento->cod_aut_movi = $cod_aut_movi;
       $movimiento->detalle_movi = $detalle_movi;
       $movimiento->cuenta_id = $cuenta_id; 

       //Validaciones de obligatoriedad en BD
       if(!is_null($tipo_movi) && !is_null($fecha_movi) && !is_null($desc_movi) && !is_null($valor_movi) 
                    && !is_null($estado_movi) && !is_null($cuenta_id)){
            try{                 
                //Registrar Movimiento
                $movimiento->save();
                //Actualizar Saldo
                $cuenta = Cuenta::where('id', $cuenta_id)->first();  
                          
                if($movimiento->tipo_movi == 'C'){
                    $cuenta->saldo = $cuenta->saldo + $movimiento->valor_movi;
                }else{
                    $cuenta->saldo = $cuenta->saldo - $movimiento->valor_movi;
                }

                try{
                    $cuenta->save();
                    $data = array(
                        'cuenta' => $cuenta,
                        'status' => 'success',
                        'code' => 200
                    );
                }catch(\Exception $e){                    
                    $data = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => $e->getMessage()
                    );
                }
            }catch(\Exception $e){                    
                $data = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => $e->getMessage()
                );
            }          
        }else{
            $data = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Faltan datos por diligenciar'
            );
        }
        return response()->json($data, 200);
    }
<<<<<<< HEAD
<<<<<<< HEAD
    public function consultarMov($idCuenta){
        $movs = Movimiento::Where('cuenta_id','=',$idCuenta)->get();
        return response ()->json(

        array(
            'movimientos' =>  $movs,
            'status' => 'success',
      ),200
    );
  }
}
=======
=======
>>>>>>> origin/dev_edwin

    public function consultarMov($idCuenta){
        $movs = Movimiento::where('cuenta_id', '=', $idCuenta)->get();
        return response()->json(
            array(
<<<<<<< HEAD
                'movimientos' => $movs,
=======
                'movimientos'=> $movs,
>>>>>>> origin/dev_edwin
                'status' => 'success'
            ), 200
        );
    }
<<<<<<< HEAD
} 
>>>>>>> origin/dev
=======
}
>>>>>>> origin/dev_edwin
