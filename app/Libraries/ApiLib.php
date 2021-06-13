<?php

namespace App\Libraries;
use App\Libraries\ClientLib;

class ApiLib {
    private static $instance;

    public static function getInstance(){
        session_start();
        if(is_null($instance)){
            $instance = new ApiLib();
        }
        return $instance;
    }

    //Destruimos la session y el objeto de la clase
    public function destroySession(){
        session_destroy();
        $instance = null;
    }


    public function InicioDeSessionPost($email , $password){
        $dataSession = [];
        $client = \Config\Services::curlrequest();
			//Peticion	
        $response = $client->request('POST', 'http://api.devsan.es/login', [
           'form_params' => [
             'email' => $email,
             'password' => $password
         ]
     ]);
            //Json de respuesta
        $mijson = json_decode($response->getBody(),true);
        if($response->getStatusCode() == 200) {
            $dataSession['user'] = $email;
            $dataSession['token'] = $mijson['token'];
            $dataSession['id'] = $mijson['id'];
            $dataSession['idempresa'] = $mijson['idempresa'];
            $_SESSION = $dataSession;

            return true;
        }
        else {                
            return false;
        }
    }

    //Obtenemos los clientes de una empresa
    //Ejemplo de obtencion de datos por un get pasando parametros por el header
    public function ClientesDeEmpresaGet(){

        $token = $_SESSION['token'];
        $idempresa = $_SESSION['idempresa'];
        $client = \Config\Services::curlrequest();

        $response = $client->request('GET', 'http://api.devsan.es/clientes/empresa/'.$idempresa, [
            'headers' => [
                'token' => $token
            ]
        ]);

        $mijson = json_decode($response->getBody(),true);
        //print_r($mijson);
        return $mijson;
    }

    //Ejemplo de obtencion de datos por un get pasando parametros por el header
    public function UsuariosDeUnaEmpresaGet($token,$idempresa){
        $client = \Config\Services::curlrequest();

        $response = $client->request('GET', 'http:api.devsan.es/usuariosempresas/empresa/'.$idempresa, [
            'headers' => [
                'token' => $token,
            ]
        ]);

        $mijson = json_decode($response->getBody(),true);
        print_r($mijson);
    }

    
} 

