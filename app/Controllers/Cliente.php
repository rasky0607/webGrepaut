<?php

namespace App\Controllers;
//Añadido
use CodeIgniter\HTTP\IncomingRequest;
use App\Libraries\ApiLib;


class Cliente extends BaseController {
	public function index() {
		//Si pasa o no pasa parametros por el buscador o filtro	
		if ($this->request->getMethod() == 'post') {	
			if(!empty($this->request->getVar('cadena'))){
				$dataFilter = $this->filtroCliente();
				return view('clientes/clienteList',$dataFilter);
			}
		}

		$data = [];
		$apiClient = new ApiLib($this->session->get('token'));
		$data['clientes'] = json_decode($apiClient->run("GET", "/clientes/empresa/".$this->session->get('idempresa'), []));

		
		return view('clientes/clienteList', $data);
	}

	//Muestra un listado de coches que pertenecen a un cliente
	public function detallesCochesEnPropiedad($idcliente,$nombreCliente) {
		$data = [];
		$apiClient = new ApiLib($this->session->get('token'));
		$data['coches'] = json_decode($apiClient->run("GET", "/coches/cliente/".$idcliente, []));
		$data['nombreCliente'] = $nombreCliente;
		$data['idcliente'] = $idcliente;
		
		return view('clientes/detallesClienteCochesPropiedad',$data);
	}

	public function createCliente() {
		$data["error"] = "";

		if ($this->request->getMethod() == 'post') {

			if (empty($this->request->getVar('nombre')) || empty($this->request->getVar('apellido')) || empty($this->request->getVar('tlf'))){

				$error = "¡Debes rellenar obligatoriamente los cambos con un *!.";
				return view('clientes/newCliente',['error' => $error]);
			} 
			else {

				$data = [
					'nombre' => $this->request->getVar('nombre'),
					'apellido' => $this->request->getVar('apellido'),
					'empresa' => $this->session->get('idempresa'),
					'tlf' => $this->request->getVar('tlf')
				];

				if(!empty($this->request->getVar('email'))) {
					$data['email'] = $this->request->getVar('email');
				}

				$apiClient = new ApiLib($this->session->get('token'));
				$result = json_decode($apiClient->run("POST", "/clientes", $data));
				if(!empty($result->Cliente)) {

					//Todo correcto, lo devolvemos al listado
					return redirect()->to(site_url('/Cliente'));
				} 
				else if(empty($result->Cliente) && !empty($result->Error)) {
					$data['error'] = $result->Error;
					return view('clientes/newCliente',$data);
				} 
				else {
					$data['error'] = 'No se ha podido crear el cliente';
					//Mostramos la vista con el error
					return view('clientes/newCliente',$data);
				}
			}
		}

		return view('clientes/newCliente',$data);
	}


	public function deleteCliente($idcliente) {
		$apiClient = new ApiLib($this->session->get('token'));
		$apiClient->run("DELETE", "/clientes/".$idcliente, []);
		return redirect()->to(site_url('/Cliente'));
	}

	//PENDIENTE
	public function editCliente($idcliente) {

		$data["error"] = "";
		$data["idcliente"] = $idcliente;


		$apiClient = new ApiLib($this->session->get('token'));
		$datosCliente = json_decode($apiClient->run("GET", "/clientes/datos/".$idcliente, []));

		//Prepara datos para pintar en la vista
		foreach ($datosCliente as $item) {

			$data["nombre"] = $item->nombre;
			$data["apellido"] = $item->apellido;
			$data["tlf"] = $item->tlf;
			$data["email"] = $item->email;
		}

		
		if ($this->request->getMethod() == 'post') {
			if (empty($this->request->getVar('nombre')) || empty($this->request->getVar('apellido')) || empty($this->request->getVar('tlf'))) {

				$data["error"] = "¡Debes rellenar obligatoriamente los cambos con un *!.";

			}else {

				//Guardar datos
				$datosActualizados = [
					'nombre' => $this->request->getVar('nombre'),
					'empresa' => $this->session->get('idempresa'),
					'apellido' => $this->request->getVar('apellido'),
					'tlf' => $this->request->getVar('tlf'),
					'email' => $this->request->getVar('email')
				];

				$result = json_decode($apiClient->run("PUT", "/clientes/".$idcliente, $datosActualizados,true));
				
				if(!empty($result->Cliente)) {
					
					//Todo correcto, lo devolvemos al listado
					return redirect()->to(site_url('/Cliente'));

				}else {
							
					$data["error"] = $result->Error;
					
					return view("clientes/editCliente",$data);
				}
			} 
		}

		return view("clientes/editCliente",$data);
		
	}

	public function filtroCliente(){	
		//Si la cadena es vacia
		if(empty($this->request->getVar('cadena'))){
			return redirect()->to(site_url('/Cliente'));			
		}
		//Separamos el nombre y apellidos y le añadimos a los apellidos una " _ " para que lo entienda la url como Gonzalez_Ramirez
		$nombreYApellidos = $this->separadorNombreYApellido($this->request->getVar('cadena'));

		$apiClient = new ApiLib($this->session->get('token'));
		$data['clientes'] = json_decode($apiClient->run("GET", "/clientes/buscar/".$this->session->get('idempresa')."/".$nombreYApellidos['nombre']."/".$nombreYApellidos['apellidos'], []));				
		/*$result = json_decode($apiClient->run("GET", "/empresas/".$this->session->get('idempresa'), []));     
		$data ['empresa'] = [
			'nombreEmpresa' => $result->Empresa[0]->nombre
		];*/
		//var_dump($data['clientes']->message);
		if(empty($data['clientes']->message)){
			//return view('usuarios/gestionUsuariosView',$data);
			return $data;
		}else{
			$dataVacio['clientes'] = [];
			return $dataVacio;
			//return view('usuarios/gestionUsuariosView',$dataVacio);
		}
	}

	function separadorNombreYApellido($cadena){

		$result = explode(" ", $cadena);
		$nombre = "";
		$apellidos = "";
		//echo count($result);
		for($i=0; $i < count($result); $i++){
			if($i==0){
				$nombre = $result[$i];
			}else if($i< count($result)-1 && $i != 0){				
				$apellidos .= $result[$i].'_'; 
			}else{
				$apellidos .= $result[$i];
			}
			
		}
		$data ['nombre'] = $nombre;
		$data ['apellidos'] = $apellidos;
		return $data;
	}

	

	
}
