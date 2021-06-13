<?php

namespace App\Controllers;
//Añadido
use CodeIgniter\HTTP\IncomingRequest;
use App\Libraries\ApiLib;
use App\Libraries\ClientLib;

class Login extends BaseController
{

	public function index() {
		$data = [];
		$data["error"] = "";
		return view("login", $data);

		
	}

	public function InicioDeSession(){
		$data = [];
		if(isset($_POST['email']) && isset($_POST['password'])){
			$apiClient = ApiLib::getInstance();
			//Correcto no hay errores				
			if($apiClient->InicioDeSessionPost($_POST['email'],$_POST['password'])){
				return redirect()->to(site_url('/Home/'));
				//echo "Entraste!";
				
				
			}
			else{
				$data['error'] = "Error de inicio de sesion";
				return view('login',$data);
			}
		}

	}

	public function logout() {
		$apiClient = ApiLib::getInstance();
		$apiClient->destroySession();
		return redirect()->to(site_url('/Login'));
	}


	public function test(){
		$apiClient = new ApiLib();
		$apiClient->ClientesDeEmpresaGet($_SESSION['token'],$_SESSION['idempresa']);
	}


	/* MI testeo de primera peticion a la api
	public function milogin(){
		if(isset($_POST['email'])){
			$client = \Config\Services::curlrequest();
				
				$response = $client->request('POST', 'http://api.devsan.es/login', [
					'form_params' => [
							'email' => $_POST['email'],
							'password' => $_POST['password']
					]
			]);
	
		
				//echo $response->getStatusCode();
				//echo $response->getBody();
				//echo $response->getHeader('Content-Type');
				//echo $response->getBody();
				$resultado = json_decode($response->getBody(),true);
				print_r($resultado);
				echo "<br> pos 0  ". $resultado['message'];
				echo "<br> pos 1  ". $resultado['token']; 

				

				
				
		}
	}*/
}
