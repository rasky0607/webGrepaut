<?php

namespace App\Controllers;
//Añadido
use CodeIgniter\HTTP\IncomingRequest;
use App\Libraries\ApiLib;


class Coche extends BaseController {
	public function index() {
		$apiClient = new ApiLib($this->session->get('token'));
		$data['coches'] = json_decode($apiClient->run("GET", "/coches/empresa/".$this->session->get('idempresa'), []));
		
		if ($this->request->getMethod() == 'post') {
			if(!empty($this->request->getVar('cadena'))){
				$dataFilter = $this->filtroCoche();
				return view('coches/cocheList',$dataFilter);
			}
		}

		if(empty($data['coches']->Error)){
			return view('coches/cocheList',$data);
		}else{
			$dataVacio['coches'] = [];
			return view('coches/cocheList',$dataVacio);
		}
		
	}

	public function createCoche() {
		$data = [];
		$apiClient = new ApiLib($this->session->get('token'));
		//para el desplegable de de los posibles clientes
		$data['clientes'] = json_decode($apiClient->run("GET", "/clientes/empresa/".$this->session->get('idempresa'), []));
		if ($this->request->getMethod() == 'post') {

			if (empty($this->request->getVar('matricula')) || empty($this->request->getVar('marca')) || empty($this->request->getVar('idcliente'))){

				$data['error'] = "¡Debes rellenar obligatoriamente los cambos con un *!.";
				return view('coches/newCoche',$data);
			} 
			else {
				//Comprobamos si existe un coche con la misma matricula en esta empresa y si es asi, no dejamos crearlo
				$cocheExitente = $this->comprobarCocheConMismaMatriculaMismaEmpresa($this->request->getVar('matricula'));
				if(count($cocheExitente['coches']) == 0){
					$data = [
						'matricula' => $this->request->getVar('matricula'),
						'marca' => $this->request->getVar('marca'),
						'idcliente' => $this->request->getVar('idcliente'),
						'modelo' => ''
					];
					
	
					if(!empty($this->request->getVar('modelo'))) {
						$data['modelo'] = $this->request->getVar('modelo');
					}
	
					$result = json_decode($apiClient->run("POST", "/coches", $data));
					if(!empty($result->Coche)) {
	
					//Todo correcto, lo devolvemos al listado
						return redirect()->to(site_url('/Coche'));
					} 
					else if(empty($result->Coche) && !empty($result->Error)) {
						$data['error'] = $result->Error;
						return view('coches/newCoche',$data);
					} 
					else {
						$data['error'] = 'No se ha podido crear el vehículo';
						//Mostramos la vista con el error
						return view('coches/newCoche',$data);
					}

				}
				else{
					$data['error'] = 'Ya existe un vehiculo con esa  matricula en la empresa';
						//Mostramos la vista con el error
						return view('coches/newCoche',$data);
				}				
			}

		} 

		//$result = json_decode($apiClient->run("GET", "/coches/empresa/".$this->session->get('idempresa'),
		
		return view('coches/newCoche',$data);
		
	}


	public function deleteCoche($idcoche) {
		$apiClient = new ApiLib($this->session->get('token'));
		$apiClient->run("DELETE", "/coches/".$idcoche, []);
		return redirect()->to(site_url('/Coche'));
		
	}

	public function editCoche($idcoche,$idcliente) {
		$data = [];
		$data['error'] = '';
		$data['idcoche'] = $idcoche;
		$data['idcliente'] = $idcliente;
		$apiClient = new ApiLib($this->session->get('token'));

		//clientes para el desplegable de la edicion
		$data["clientes"] = json_decode($apiClient->run("GET", "/clientes/empresa/".$this->session->get('idempresa'), []));
		
		//Rellena campos de datos del vehiculo
		$datosCoche = json_decode($apiClient->run("GET", "/coches/datos/".$idcoche, []));
		
		//Prepara datos para pintar en la vista
		foreach ($datosCoche as $item) {

			$data["matricula"] = $item->matricula;
			$data["marca"] = $item->marca;
			$data["modelo"] = $item->modelo;
			$data["idcliente"] = $item->idcliente;
		}

		if ($this->request->getMethod() == 'post') {
			if (empty($this->request->getVar('matricula')) || empty($this->request->getVar('marca')) || empty($this->request->getVar('idcliente'))) {

				$data["error"] = "¡Debes rellenar obligatoriamente los cambos con un *!.";

			}else {

				//Comprobamos si existe un coche con la misma matricula en esta empresa y si es asi, no dejamos crearlo
				$cocheExitente = $this->comprobarCocheConMismaMatriculaMismaEmpresa($this->request->getVar('matricula'));

				if(count($cocheExitente['coches']) == 0 || $cocheExitente['coches'][0]->matricula == $data["matricula"] ){
					//Guardar datos
					$data = [
						'matricula' => $this->request->getVar('matricula'),
						'marca' => $this->request->getVar('marca'),
						'idcliente' => $this->request->getVar('idcliente'),
						'modelo' => ''
					];
					if(!empty($this->request->getVar('modelo'))) {
						$data['modelo'] = $this->request->getVar('modelo');
					}
					
					$result = json_decode($apiClient->run("PUT", "/coches/".$idcoche, $data,true));

					if(!empty($result->Coche)) {

					//Todo correcto, lo devolvemos al listado
						return redirect()->to(site_url('/Coche'));
					} 
					else if(empty($result->Coche) && !empty($result->Error)) {
						$data['error'] = $result->Error;
						return view('coches/editCoche',$data);
					} 
					else {
						$data['error'] = 'No se ha podido crear el vehículo';
						//Mostramos la vista con el error
						return view('coches/editCoche',$data);
					}

				}
				else{
					$data['error'] = 'Ya existe un vehiculo con esa  matricula en la empresa';
					//Mostramos la vista con el error
					return view('coches/editCoche',$data);
				}

			} 
		}


		return view('coches/editCoche',$data);
	}

	public function filtroCoche(){	
		//Si la cadena es vacia
		if(empty($this->request->getVar('cadena'))){
			return redirect()->to(site_url('/Coche'));			
		}

		$apiClient = new ApiLib($this->session->get('token'));
		$data['coches'] = json_decode($apiClient->run("GET", "/coches/empresa/".$this->session->get('idempresa')."/".$this->request->getVar('cadena'), []));				
		/*$result = json_decode($apiClient->run("GET", "/empresas/".$this->session->get('idempresa'), []));     
		$data ['empresa'] = [
			'nombreEmpresa' => $result->Empresa[0]->nombre
		];*/
		
		if(empty($data['coches']->message)){
			//return view('usuarios/gestionUsuariosView',$data);
			return $data;
		}else{
			$dataVacio['coches'] = [];
			return $dataVacio;
			//return view('usuarios/gestionUsuariosView',$dataVacio);
		}
	}

	/*Un parche cutre, que comprueba que en una misma empresa, no existe dos coches con la misma matricula,
	 ya que esta no es clave, ni unica por tema de compatibilidad de lumen en la api al crear las tablas*/
	function comprobarCocheConMismaMatriculaMismaEmpresa($matricula){
		$apiClient = new ApiLib($this->session->get('token'));
		$data['coches'] = json_decode($apiClient->run("GET", "/coches/empresa/comprobar/".$this->session->get('idempresa')."/".$matricula, []));
		return $data;
	}
	
}
