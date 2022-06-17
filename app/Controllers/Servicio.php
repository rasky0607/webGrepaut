<?php

namespace App\Controllers;
//Añadido
use CodeIgniter\HTTP\IncomingRequest;
use App\Libraries\ApiLib;


class Servicio extends BaseController {
	public function index() {
		$data = [];

		//Si pasa o no pasa parametros por el buscador o filtro
		if ($this->request->getMethod() == 'post') {
			if(!empty($this->request->getVar('cadena'))){
				$dataFilter = $this->filtroServicio();
				return view('servicios/servicioList',$dataFilter);
			}
		}

		$apiClient = new ApiLib($this->session->get('token'));
		$data['servicios'] = json_decode($apiClient->run("GET", "/servicios/empresa/".$this->session->get('idempresa'), []));

		return view('servicios/servicioList',$data);
	}

	public function createServicio() {
		$data = [];
		$apiClient = new ApiLib($this->session->get('token'));
		
		if ($this->request->getMethod() == 'post') {

			if (empty($this->request->getVar('nombre')) || empty($this->request->getVar('precio'))){

				$data['error'] = "¡Debes rellenar obligatoriamente los cambos con un *!.";
				return view('servicios/newServicio',$data);
			} 
			else {

				$data = [
					'nombre' => $this->request->getVar('nombre'),
					'precio' => $this->request->getVar('precio'),
					'empresa' => $this->session->get('idempresa'),
					'descripcion' => ''
				];

				if(!empty($this->request->getVar('descripcion'))) {
					$data['descripcion'] = $this->request->getVar('descripcion');
				}

				$result = json_decode($apiClient->run("POST", "/servicios", $data));
				if(!empty($result->Servicio)) {

				//Todo correcto, lo devolvemos al listado
					return redirect()->to(site_url('/Servicio'));
				} 
				else if(empty($result->Coche) && !empty($result->Error)) {
					$data['error'] = $result->Error;
					return view('servicios/newServicio',$data);
				} 
				else {
					$data['error'] = 'No se ha podido crear el servicio';
					//Mostramos la vista con el error
					return view('servicios/newServicio',$data);
				}
			}

		}

		return view('servicios/newServicio',$data);	
	}


	public function deleteServicio($idservicio) {

		$apiClient = new ApiLib($this->session->get('token'));
		$apiClient->run("DELETE", "/servicios/".$idservicio, []);
		return redirect()->to(site_url('/Servicio'));
	}

	public function editServicio($idservicio) {
		$data = [];
		$data['idservicio'] = $idservicio;
		$apiClient = new ApiLib($this->session->get('token'));
		$datosServicio = json_decode($apiClient->run("GET", "/servicios/datos/".$idservicio, []));

		//Prepara datos para pintar en la vista
		foreach ($datosServicio as $item) {

			$data["nombre"] = $item->nombre;
			$data["precio"] = $item->precio;
			$data["descripcion"] = $item->descripcion;
		}


		
		if ($this->request->getMethod() == 'post') {

			if (empty($this->request->getVar('nombre')) || empty($this->request->getVar('precio'))){

				$data['error'] = "¡Debes rellenar obligatoriamente los cambos con un *!.";
				return view('servicios/editServicio',$data);
			} 
			else {

				$data = [
					'nombre' => $this->request->getVar('nombre'),
					'precio' => $this->request->getVar('precio'),
					'empresa' => $this->session->get('idempresa'),
					'descripcion' => ''
				];

				if(!empty($this->request->getVar('descripcion'))) {
					$data['descripcion'] = $this->request->getVar('descripcion');
				}

				$result = json_decode($apiClient->run("PUT", "/servicios/".$idservicio, $data,true));
				if(!empty($result->Servicio)) {

				//Todo correcto, lo devolvemos al listado
					return redirect()->to(site_url('/Servicio'));
				} 
				else if(empty($result->Coche) && !empty($result->Error)) {
					$data['error'] = $result->Error;
					return view('servicios/editServicio',$data);
				} 
				else {
					$data['error'] = 'No se ha podido crear el servicio';
					//Mostramos la vista con el error
					return view('servicios/editServicio',$data);
				}
			}

		}

		return view('servicios/editServicio',$data);
	}

	public function filtroServicio(){	
		//Si la cadena es vacia
		if(empty($this->request->getVar('cadena'))){
			return redirect()->to(site_url('/Servicio'));			
		}


		$apiClient = new ApiLib($this->session->get('token'));
		$data['servicios'] = json_decode($apiClient->run("GET", "/servicios/buscar/".$this->session->get('idempresa')."/".$this->request->getVar('cadena'), []));				     
		
		if(empty($data['servicios']->Error)){
			//return view('usuarios/gestionUsuariosView',$data);
			return $data;
		}else{
			$dataVacio['servicios'] = [];
			return $dataVacio;
			//return view('usuarios/gestionUsuariosView',$dataVacio);
		}
	}
	
}
