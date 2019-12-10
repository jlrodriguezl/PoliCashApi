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
       $tipo_movi = (!is_null($json) && isset($params->tipo_movi)) ? $params->tipo_movi : null;
       $fecha_movi = (!is_null($json) && isset($params->fecha_movi)) ? $params->fecha_movi : null;
       $desc_movi = (!is_null($json) && isset($params->desc_movi)) ? $params->desc_movi : null;
       $valor_movi = (!is_null($json) && isset($params->valor_movi)) ? $params->valor_movi : null;
       $estado_movi = (!is_null($json) && isset($params->estado_movi)) ? $params->estado_movi : null;
       $cod_aut_movi = (!is_null($json) && isset($params->cod_aut_movi)) ? $params->cod_aut_movi : null;
       $detalle_movi = (!is_null($json) && isset($params->detalle_movi)) ? $params->detalle_movi : null;
       $cuenta_id = (!is_null($json) && isset($params->cuenta_id)) ? $params->cuenta_id : null;
       
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
}