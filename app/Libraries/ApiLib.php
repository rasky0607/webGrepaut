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

//#### Tabla Clientes ####

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

    public function DeleteClienteDeEmpresa($idcliente){

    }

//### ------- ###

//#### Tabla Coches ####

    public function CochesDeEmpresaGet(){
        $token = $_SESSION['token'];
        $idempresa = $_SESSION['idempresa'];
        $client = \Config\Services::curlrequest();

        $response = $client->request('GET', 'http://api.devsan.es/coches/empresa/'.$idempresa, [
            'headers' => [
                'token' => $token
            ]
        ]);

        $mijson = json_decode($response->getBody(),true);
        //print_r($mijson);
        return $mijson;
    }
//### ------- ###

//#### Tabla Servicios ####

    public function ServiciosDeEmpresaGet(){
        $token = $_SESSION['token'];
        $idempresa = $_SESSION['idempresa'];
        $client = \Config\Services::curlrequest();

        $response = $client->request('GET', 'http://api.devsan.es/servicios/empresa/'.$idempresa, [
            'headers' => [
                'token' => $token
            ]
        ]);

        $mijson = json_decode($response->getBody(),true);
        //print_r($mijson);
        return $mijson;
    }
//### ------- ###


//#### Tabla Reparaciones ####

    public function ReparacionesDeEmpresaGet(){
        $token = $_SESSION['token'];
        $idempresa = $_SESSION['idempresa'];
        $client = \Config\Services::curlrequest();

        $response = $client->request('GET', 'http://api.devsan.es/reparaciones/empresa/'.$idempresa, [
            'headers' => [
                'token' => $token
            ]
        ]);

        $mijson = json_decode($response->getBody(),true);
        //print_r($mijson);
        return $mijson;
    }
//### ------- ###


//#### Tabla serviciosReparaciones ####

    public function DetallesDeReparacionGet($idreparacion){
        $token = $_SESSION['token'];
        $idempresa = $_SESSION['idempresa'];
        $client = \Config\Services::curlrequest();

        $response = $client->request('GET', 'http://api.devsan.es/serviciosreparaciones/detalles/'.$idreparacion, [
            'headers' => [
                'token' => $token
            ]
        ]);

        $mijson = json_decode($response->getBody(),true);
        //print_r($mijson);
        return $mijson;
    }
//### ------- ###
    


//#### Tabla Facturas ####

    public function FacturasDeEmpresaGet(){
        $token = $_SESSION['token'];
        $idempresa = $_SESSION['idempresa'];
        $client = \Config\Services::curlrequest();

        $response = $client->request('GET', 'http://api.devsan.es/facturas/empresa/'.$idempresa, [
            'headers' => [
                'token' => $token
            ]
        ]);

        $mijson = json_decode($response->getBody(),true);
        //print_r($mijson);
        return $mijson;
    }
//### ------- ###

} 

