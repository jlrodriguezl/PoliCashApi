<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use App\Personas;

class PersonaController extends Controller
{
    public function registrar (Request $request)
{
    //Recibir lo que viene por POST
    $json = $request-> input ('json',null);
    //codificar json en objeto de PHP
    $params = \json_decode($json);
    //Asignar valores a variables php
         $id = (!is_null($json) && isset($params->id)) ?
    $params->id : null;
         $tipo_id = (!is_null($json) && isset($params->tipo_id)) ?
    $params->tipo_id : null;  
    $nombres = (!is_null($json) && isset($params->nombres)) ?
    $params->nombres : null;  
    $apellidos = (!is_null($json) && isset($params->apellidos)) ?
    $params->apellidos: null;  
    $celular = (!is_null($json) && isset($params->celular)) ?
    $params->celular : null;  
     $correo = (!is_null($json) && isset($params->correo)) ?
    $params->correo : null;  
    $password = (!is_null($json) && isset($params->password)) ?
    $params->password : null;  
    //Armar objeto persona
    $per = new Personas();
    $per-> id = id;
    $per-> tipo_id = tipo_id;
    $per-> nombres = nombres;
    $per-> apellidos = apellidos;
    $per-> celular = celular;
    $per-> correo= correo;
    //Encriptar contraseña
    $pwd = hash ('sha256',$password);
    $per ->password =$pwd;

    //validar si el usuario ya existe

    $per_existe = Persona::Where ('id','=',$id)->first ();
    if(!isset($per_existe)){
        //guardar usuario
        try{
            $persona->save();

        }catch(exception $e){
            $data = array(
                'status' => 'error',
                'code' => 400,
                'message'=> $e->getMessage()




            );
        }
        //Respuesta
        $data = array(
            'status' => 'okey',
            'code' => 200,
            'message'=> 'usuario resgistrado correctamente'
        );
    }
    return response()-> json($data,200);

 
}

public function login (Request $request)
{
    echo"Accion Login";
    die();
}

}

