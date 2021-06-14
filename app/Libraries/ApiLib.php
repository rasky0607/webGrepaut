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
    public function ClienteDatosGet($idcliente){
        $token = $_SESSION['token'];
        $client = \Config\Services::curlrequest();

        $response = $client->request('GET', 'http://api.devsan.es/clientes/datos/'.$idcliente, [
            'headers' => [
                'token' => $token
            ]
        ]);

        $mijson = json_decode($response->getBody(),true);
        //print_r($mijson);

        return $mijson;
    }


    //Obtenemos los clientes de una empresa
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

    //PENDIENTE
    public function CreateClienteDeEmpresaPost($nombre,$apellidos,$tlf,$email){
        $token = $_SESSION['token'];
        $idempresa = $_SESSION['idempresa'];
        $client = \Config\Services::curlrequest();

        //Peticion  
        $response = $client->request('POST', 'http://api.devsan.es/clientes', [
            'headers' => [
                'token' => $token
            ],

            'form_params' => [
               'nombre' => $nombre,
               'empresa' => $idempresa,
               'apellido' => $apellido,
               'tlf' => $tlf,
               'email' => $email
           ]
       ]);
        //Json de respuesta
        $mijson = json_decode($response->getBody(),true);
        print_r($mijson);
        if($response->getStatusCode() == 200) {
            //Todo correcto
            return true;
        }else {
            return false;
        }
        
    }
    //PENDIENTE
    public function ActualizarCliente($idcliente,$nombre,$apellido,$tlf,$email){
        $token = $_SESSION['token'];
        $idempresa = $_SESSION['idempresa'];
        $client = \Config\Services::curlrequest();

        //Peticion  
        $response = $client->request('PUT', 'http://api.devsan.es/clientes'.$idcliente, [
            'headers' => [
                'token' => $token
            ],

            'form_params' => [
               'nombre' => $nombre,
               'empresa' => $idempresa,
               'apellido' => $apellido,
               'tlf' => $tlf,
               'email' => $email
           ]
       ]);
        //Json de respuesta
        $mijson = json_decode($response->getBody(),true);
        print_r($mijson);

        if($response->getStatusCode() == 200) {
            //Todo correcto
            return true;
        }else {
            return false;
        }
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

    public function CochesDatosGet($idcoche){
        $token = $_SESSION['token'];
        $idempresa = $_SESSION['idempresa'];
        $client = \Config\Services::curlrequest();

        $response = $client->request('GET', 'http://api.devsan.es/coches/datos/'.$idcoche, [
            'headers' => [
                'token' => $token
            ]
        ]);

        $mijson = json_decode($response->getBody(),true);
        //print_r($mijson);
        return $mijson;
    }

    public function CochesDeClienteGet($idcliente){
        $token = $_SESSION['token'];
        $client = \Config\Services::curlrequest();

        $response = $client->request('GET', 'http://api.devsan.es/coches/cliente/'.$idcliente, [
            'headers' => [
                'token' => $token
            ]
        ]);

        $mijson = json_decode($response->getBody(),true);
        //print_r($mijson);
        return $mijson;
    }

    public function ActualizarCoche($idcliente,$matricula,$marca,$modelo){
        
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

