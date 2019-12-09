<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use App\Persona;

class PersonaController extends Controller
{
    public function registrar(Request $request)
    {
        //Recibir lo que viene por POST
        $json = $request->input('json', null);
        //Codificar json en objeto de PHP
        $params = \json_decode($json);
        //Asignar valores a variables php
        $id = (!is_null($json) && isset($params->id)) ? 
            $params->id : null;
        $tipo_id = (!is_null($json) && isset($params->tipo_id)) ? 
            $params->tipo_id : null;
        $nombres = (!is_null($json) && isset($params->nombres)) ? 
            $params->nombres : null;
        $apellidos = (!is_null($json) && isset($params->apellidos)) ? 
            $params->apellidos : null;
        $celular = (!is_null($json) && isset($params->celular)) ? 
            $params->celular : null;
        $correo = (!is_null($json) && isset($params->correo)) ? 
            $params->correo : null;
        $password = (!is_null($json) && isset($params->password)) ? 
            $params->password : null;    

        //Armar objeto Persona
        $per = new Persona();
        $per->id = $id;
        $per->tipo_id = $tipo_id;
        $per->nombres = $nombres;
        $per->apellidos = $apellidos;
        $per->celular = $celular;
        $per->correo = $correo;
        //Encriptar Contraseña
        $pwd = hash('sha256', $password);
        $per->password = $pwd;
        
        //Validar si el usuario ya existe
        $per_existe = Persona::where('id', '=', $id)->first();

        if(!isset($per_existe)){
            //Guardar usuario
            try{
                $per->save();
            }catch(Exception $e){
                $data = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => $e->getMessage()
                );
            }
            //Respuesta
            $data = array(
                'status' => 'ok',
                'code' => 200,
                'message' => 'Usuario registrado correctamente'
            );
        }else{
            $data = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'El usuario ya existe'
            );
        }
        return response()->json($data, 200);
    }

    public function login(Request $request)
    {
        echo "Acción Login";
        die();
    }
}
