<?php

namespace App\Controllers;
//Añadido
use CodeIgniter\HTTP\IncomingRequest;
use App\Libraries\ApiLib;


class Reparacion extends BaseController {
	public function index() {
		$data = [];

		$apiClient = new ApiLib($this->session->get('token'));
		$data['reparaciones'] = json_decode($apiClient->run("GET", "/reparaciones/empresa/".$this->session->get('idempresa'), []));
		return view('reparaciones/reparacionList',$data);
	}

	public function createReparacion() {
		$data = [];
		$apiClient = new ApiLib($this->session->get('token'));
		$data['usuarios'] = json_decode($apiClient->run("GET", "/usuarios/empresa/".$this->session->get('idempresa'), []));
		$data['coches'] = json_decode($apiClient->run("GET", "/coches/empresa/".$this->session->get('idempresa'), []));

		if ($this->request->getMethod() == 'post') {
			$data = [
					'idcoche' => $this->request->getVar('idcoche'),
					'idusuario' => $this->request->getVar('idusuario')
				];

				//peticion
				$result = json_decode($apiClient->run("POST", "/reparaciones", $data));
				
				if(!empty($result->Reparacion)){
					return redirect()->to(site_url('/Reparacion'));
				}
				else {
					$data['error'] = 'No se ha podido crear la reparación';
					return view('reparaciones/newReparacion',$data);
				}
		}

		
		return view('reparaciones/newReparacion',$data);
	}

	public function deleteReparacion($idreparacion) {
		$apiClient = new ApiLib($this->session->get('token'));
		$result = $apiClient->run("DELETE", "/reparaciones/".$idreparacion, []);		
		return redirect()->to(site_url('/Reparacion'));	
	}

	public function editReparacion($idreparacion, $idusuario, $idcoche) {
		$data = [];
		$data['idreparacion'] = $idreparacion;
		$data['idusuario'] = $idusuario;
		$data['idcoche'] = $idcoche;

		$apiClient = new ApiLib($this->session->get('token'));
		$data['usuarios'] = json_decode($apiClient->run("GET", "/usuarios/empresa/".$this->session->get('idempresa'), []));
		$data['coches'] = json_decode($apiClient->run("GET", "/coches/empresa/".$this->session->get('idempresa'), []));

		if ($this->request->getMethod() == 'post') {
			$data = [
					'idcoche' => $this->request->getVar('idcoche'),
					'idusuario' => $this->request->getVar('idusuario')
				];

				//peticion
				$result = json_decode($apiClient->run("PUT", "/reparaciones/".$idreparacion, $data, true));
				
				if(!empty($result->Reparacion)){
					return redirect()->to(site_url('/Reparacion'));
				}
				else {
					$data['error'] = 'No se ha podido editar la reparación';
					return view('reparaciones/newReparacion',$data);
				}
		}

		return view('reparaciones/editReparacion',$data);
	}

	public function detallesReparacion($idreparacion){
		$data['idreparacion'] = $idreparacion;
		$apiClient = new ApiLib($this->session->get('token'));
		$data['extraccion'] = json_decode($apiClient->run("GET", "/serviciosreparaciones/detalles/".$idreparacion, []));
		

		$data['datosReparacion'] = $data['extraccion']->DatosReparacion;
		$data['serviciosReparacion'] = $data['extraccion']->serviciosReparacion;
		//print_r($data['datosReparacion']);
		return view('reparaciones/serviciosReparacionList',$data);
	}

	public function facturarReparacion($idreparacion){
		$apiClient = new ApiLib($this->session->get('token'));
		$result = json_decode($apiClient->run("POST", "/facturas/".$idreparacion, []));
		if(!empty($result->Error)){
			return redirect()->to(site_url('/Reparacion'));
		}
		else {
			return redirect()->to(site_url('/Factura'));
		}
		
	}

	//### Tabla ServicioReparaciones ###
	public function createServicioReparacion($idreparacion) {
		$data = [];
		$data['idreparacion'] = $idreparacion;
		$apiClient = new ApiLib($this->session->get('token'));
		$info['servicios'] = json_decode($apiClient->run("GET", "/servicios/empresa/".$this->session->get('idempresa'), []));
		$info['idreparacion'] = $idreparacion;

		if ($this->request->getMethod() == 'post') {

			if (empty($this->request->getVar('idservicio'))) {

				$data['error'] = "¡Debes rellenar obligatoriamente los cambos con un *!.";
				return view('reparaciones/newServicioReparacion',$data);
			} 
			else {
				$data = [
					'idreparacion' => $idreparacion,
					'servicio' => $this->request->getVar('idservicio')
					
				];

				if(!empty($this->request->getVar('precioModificado'))) {
					$data['precioServicio'] = $this->request->getVar('precioModificado');
				}
				
				$result = json_decode($apiClient->run("POST", "/serviciosreparaciones", $data));

				if(!empty($result->servicioReparacion)) {

				//Todo correcto, lo devolvemos al listado
					return redirect()->to(site_url('/Reparacion/detallesReparacion/'.$idreparacion));
				} 
				else if(empty($result->servicioReparacion) && !empty($result->Error)) {
					$info['error'] = $result->Error;

					return view('reparaciones/newServicioReparacion',$info);
				} 
				else {
					$info['error'] = 'No se ha podido crear el servicio';
					//Mostramos la vista con el error
					return view('reparaciones/newServicioReparacion',$info);
				}


			}
		} 


		return view('reparaciones/newServicioReparacion',$info);
	}

	public function editServicioReparacion($idreparacion, $numerotrabajo) {
		$apiClient = new ApiLib($this->session->get('token'));
		$extracion = json_decode($apiClient->run("GET", "/serviciosreparaciones/datos/".$idreparacion."/".$numerotrabajo, []));
		$idservicio = $extracion[0]->servicio;
		$data = [];
		$data['idreparacion'] = $idreparacion;
		$data['idservicio'] = $idservicio;
		$data['numerotrabajo'] = $numerotrabajo;
		
		$info['servicios'] = json_decode($apiClient->run("GET", "/servicios/empresa/".$this->session->get('idempresa'), []));

		$info['idreparacion'] = $idreparacion;
		$info['idservicioEscogido'] = $idservicio;
		$info['numerotrabajo'] = $numerotrabajo;
	
		if ($this->request->getMethod() == 'post') {

			if (empty($this->request->getVar('idservicio'))) {

				$data['error'] = "¡Debes rellenar obligatoriamente los cambos con un *!.";
				return view('reparaciones/newServicioReparacion',$data);
			} 
			else {
				$data = [
					'idreparacion' => $idreparacion,
					'servicio' => $this->request->getVar('idservicio')
					
				];
				//.$idreparacion."/".$numerotrabajo
				if(!empty($this->request->getVar('precioModificado'))) {
					$data['precio'] = $this->request->getVar('precioModificado');
				}
				
				$result = json_decode($apiClient->run("PUT", "/serviciosreparaciones/".$idreparacion."/".$numerotrabajo, $data, true));

				if(!empty($result->servicioreparacion)) {

				//Todo correcto, lo devolvemos al listado
					return redirect()->to(site_url('/Reparacion/detallesReparacion/'.$idreparacion));
				} 
				else if(empty($result->servicioreparacion) && !empty($result->Error)) {
					$info['error'] = $result->Error;

					return view('reparaciones/editServicioReparacion',$info);
				} 
				else {
					$info['error'] = 'No se ha podido actualizar el servicio';
					//Mostramos la vista con el error
					return view('reparaciones/editServicioReparacion',$info);
				}


			}
		} 

		return view('reparaciones/editServicioReparacion',$info);
	}

	public function deleteServicioReparacion($idreparacion, $numerotrabajo) {
		$apiClient = new ApiLib($this->session->get('token'));
		$apiClient->run("DELETE", "/serviciosreparaciones/".$idreparacion."/".$numerotrabajo, []);
		return redirect()->to(site_url('/Reparacion/detallesReparacion/'.$idreparacion));
	}

	//### FIN Tabla ServicioReparaciones ###


	
}
