<?php

namespace App\Controllers;
//Añadido
use CodeIgniter\HTTP\IncomingRequest;
use App\Libraries\ApiLib;
use App\Helpers\my_functions_helper;

class Usuario extends BaseController {
	public function index() {

		//Si pasa o no pasa parametros por el buscador o filtro
		if ($this->request->getMethod() == 'post') {
			if(!empty($this->request->getVar('cadena'))){
				$dataFilter = $this->filtroUsuarios();
				return view('usuarios/gestionUsuariosView',$dataFilter);
			}
		}
				
		$apiClient = new ApiLib($this->session->get('token'));
		$data['usuarios'] = json_decode($apiClient->run("GET", "/usuarios/empresa/".$this->session->get('idempresa'), []));		
        $result = json_decode($apiClient->run("GET", "/empresas/".$this->session->get('idempresa'), []));     
        $data ['empresa'] = [
            'nombreEmpresa' => $result->Empresa[0]->nombre
        ];


        if(empty($data['usuarios']->Error)){
			return view('usuarios/gestionUsuariosView',$data);
		}
		else{
			$dataVacio['usuarios'] = [];
			return view('usuarios/gestionUsuariosView',$dataVacio);
		}
		
	}

	public function createUsuario() {

		$data["error"] = "";

		if ($this->request->getMethod() == 'post') {

			if (empty($this->request->getVar('nombre')) || empty($this->request->getVar('email')) || empty($this->request->getVar('password1')) || empty($this->request->getVar('password2'))){
				//var_dump($this->request->getVar('nombre'), " - ",$this->request->getVar('email'), " - ",$this->request->getVar('password1'), " - ",$this->request->getVar('password2'));
				$data["error"] = "¡Debes rellenar obligatoriamente los cambos con un *!.";
				return view('usuarios/newUsuarioView',$data);
			}
			else if($this->request->getVar('password1') != $this->request->getVar('password2')){				
				$data["error"] = "¡Las contraseñas deben coincidir!.";
				return view('usuarios/newUsuarioView',$data);
			}
			else if(!$this->validar_password($this->request->getVar('password1'))){
				$data["error"] = "Las contraseñas deben tener al menos 6 caracteres, una minúscula», mayúscula y un numero.";
				return view('usuarios/newUsuarioView',$data);
			} 
			else {

				$data = [
					'nombre' => $this->request->getVar('nombre'),
					'email' => $this->request->getVar('email'),
					'password' => $this->request->getVar('password1'),
					'idempresa' => $this->session->get('idempresa')
				];

				if(!empty($this->request->getVar('email'))) {
					$data['email'] = $this->request->getVar('email');
				}

				$apiClient = new ApiLib($this->session->get('token'));
				$result = json_decode($apiClient->run("POST", "/registro", $data));
				if(!empty($result->usuario)) {

					//Todo correcto, lo devolvemos al listado
					return redirect()->to(site_url('/Usuario/'));	
				} 
				else if(empty($result->usuario) && !empty($result->Error)) {
					$data['error'] = $result->Error;
					return view('usuarios/newUsuarioView',$data);
				} 
				else {
					$data['error'] = 'No se ha podido crear el usuario';
					//Mostramos la vista con el error
					return view('usuarios/newUsuarioView',$data);
				}
			}
		}

		//return redirect()->to(site_url('/Usuario/'));
		return view('usuarios/newUsuarioView',$data);
	}

	
	public function changePasswordUsuario() {

		$data["error"] = "";

		if ($this->request->getMethod() == 'post') {

			if (empty($this->request->getVar('password1')) || empty($this->request->getVar('password2'))){
				//var_dump($this->request->getVar('password1'), " - ",$this->request->getVar('password2'));
				$data["error"] = "¡Debes rellenar obligatoriamente los cambos con un *!.";
				return view('usuarios/changePasswordView',$data);
			}
			else if($this->request->getVar('password1') != $this->request->getVar('password2')){				
				$data["error"] = "¡Las contraseñas deben coincidir!.";
				return view('usuarios/changePasswordView',$data);
			}
			else if(!$this->validar_password($this->request->getVar('password1'))){
				$data["error"] = "Las contraseñas deben tener al menos 6 caracteres, una minúscula», mayúscula y un numero.";
				return view('usuarios/changePasswordView',$data);
			} 
			else {

				$data = [
					'nombre' => $this->request->getVar('nombre'),
					'email' => $this->request->getVar('email'),
					'password' => $this->request->getVar('password1'),
					'idempresa' => $this->session->get('idempresa')
				];

				if(!empty($this->request->getVar('email'))) {
					$data['email'] = $this->request->getVar('email');
				}

				$apiClient = new ApiLib($this->session->get('token'));
				$result = json_decode($apiClient->run("POST", "/registro", $data));
				if(!empty($result->usuario)) {

					//Todo correcto, lo devolvemos al listado
					return redirect()->to(site_url('/Usuario/'));	
				} 
				else if(empty($result->usuario) && !empty($result->Error)) {
					$data['error'] = $result->Error;
					return view('usuarios/changePasswordView',$data);
				} 
				else {
					$data['error'] = 'No se ha podido crear el usuario';
					//Mostramos la vista con el error
					return view('usuarios/changePasswordView',$data);
				}
			}
		}

		//return redirect()->to(site_url('/Usuario/'));
		return view('usuarios/changePasswordView',$data);
	}

    public function habilitarUser($id) {
		$data = [];
		$data['error'] = '';
		$data['id'] = $id;
		$apiClient = new ApiLib($this->session->get('token'));

		//Guardar datos
		$data = [
			'estado' => 'enable'
		];
		$result = json_decode($apiClient->run("PUT", "/usuarios/".$id,$data,true));
	
        return redirect()->to(site_url('/Usuario/'));		

	}

    public function deshabilitarUser($id) {
		$data = [];
		$data['error'] = '';
		$data['id'] = $id;
		$apiClient = new ApiLib($this->session->get('token'));

		//Guardar datos
		$data = [
			'estado' => 'disable'
		];
		$result = json_decode($apiClient->run("PUT", "/usuarios/".$id,$data,true));
		
		return redirect()->to(site_url('/Usuario/'));
	}


	public function validar_password($password){
			if(strlen($password) < 6){			
				return false;
			}
			if (!preg_match('/[a-z]/',$password)){		
				//var_dump("No minusculas"." ".$password);
				return false;
			}
			if (!preg_match('/[A-Z]/',$password)){	
				//var_dump("No mayus"." ".$password);		
				return false;
			}
			if (!preg_match('/[0-9]/',$password)){		
				//var_dump("No numeros"." ".$password);	
				return false;
			}			
			return true;
		}

	public function filtroUsuarios(){	
		//Si la cadena es vacia
		if(empty($this->request->getVar('cadena'))){
			return redirect()->to(site_url('/Usuario'));			
		}

		//Si la cadena no esta vacia
		$dataFind = [
			'email' => $this->request->getVar('cadena'),
			'idempresa' => $this->session->get('idempresa')
		];

		$apiClient = new ApiLib($this->session->get('token'));
		$data['usuarios'] = json_decode($apiClient->run("POST", "/usuarios/buscar",$dataFind));				
		$result = json_decode($apiClient->run("GET", "/empresas/".$this->session->get('idempresa'), []));     
		$data ['empresa'] = [
			'nombreEmpresa' => $result->Empresa[0]->nombre
		];
		
		if(empty($data['usuarios']->message)){
			//return view('usuarios/gestionUsuariosView',$data);
			return $data;
		}else{
			$dataVacio['usuarios'] = [];
			return $dataVacio;
			//return view('usuarios/gestionUsuariosView',$dataVacio);
		}
	}

	
}