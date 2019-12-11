<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use App\Persona;
use App\Cuenta;

class PersonaController extends Controller
{
    public function registrar(Request $request)
    {       
       //Recibir lo que viene por POST
       //Por defecto será null si no llega
       $json = $request->input('json', null);
       //Codificar el json en un objeto reconocido por PHP
       $params = json_decode($json);
        
       //Asignar valores a variables php
       $id = (!is_null($json) && isset($params->id)) ? $params->id : null;
       $tipo_id = (!is_null($json) && isset($params->tipo_id)) ? $params->tipo_id : null;
       $nombres = (!is_null($json) && isset($params->nombres)) ? $params->nombres : null;
       $apellidos = (!is_null($json) && isset($params->apellidos)) ? $params->apellidos : null;
       $celular = (!is_null($json) && isset($params->celular)) ? $params->celular : null;
       $correo = (!is_null($json) && isset($params->correo)) ? $params->correo : null;
       $password = (!is_null($json) && isset($params->password)) ? $params->password : null;
    
       //Validaciones de obligatoriedad en BD
       if(!is_null($id) && !is_null($tipo_id) && !is_null($nombres) && !is_null($apellidos) 
                    && !is_null($celular) && !is_null($correo) && !is_null($password)){
            //Crear el usuario
            $persona = new Persona();
            $persona->id = $id;
            $persona->tipo_id = $tipo_id;
            $persona->nombres = $nombres;
            $persona->apellidos = $apellidos;
            $persona->celular = $celular;
            $persona->correo = $correo;

            //Generar contraseña cifrada
            $pwd = hash('sha256', $password);
            $persona->password = $pwd;            
            
            //Validar que el usuario no exista en la BD
            $isset_per = Persona::where('id', '=', $id)->first();
            
            if(!isset($isset_per)){                
                //Guardar Usuario
                try{
                    $persona->save();
                    //Registrar cuenta con saldo 0
                    $cuenta = new Cuenta();
                    $cuenta->id = $persona->celular;
                    $cuenta->saldo = 0;
                    $cuenta->tipo_cuenta = "CA";
                    $cuenta->persona_id = $id;
                    try{
                        $cuenta->save();
                        //Respuesta
                        $data = array(
                            'status' => 'OK',
                            'code' => 200,
                            'message' => 'Usuario registrado correctamente'
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
                    'message' => 'Usuario ya existe'
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

    public function login(Request $request)
    {
       //Recibir lo que viene por POST
       //Por defecto será null si no llega
       $json = $request->input('json', null);
       //Codificar el json en un objeto reconocido por PHP
       $params = json_decode($json);
        
       //Generar contraseña cifrada
       $pwd = hash('sha256', $params->contrasena);       

       $user = Persona::where(
           array(
               'tipo_id' =>  $params->tipoId,
               'id' => $params->identificacion,
               'password' => $pwd
           )
        )->first();

        if(!is_null($user)){
            $data =  1;
        }else{
            $data = 0;
        }
        return $data;
    }
}
