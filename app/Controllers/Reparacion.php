<?php

namespace App\Controllers;
//Añadido
use CodeIgniter\HTTP\IncomingRequest;
use App\Libraries\ApiLib;


class Reparacion extends BaseController {
	public function index() {
		$data = [];
		$apiClient = ApiLib::getInstance();

		$data['reparaciones'] = $apiClient->ReparacionesDeEmpresaGet();

		return view('reparaciones/reparacionList',$data);
	}

	public function createReparacion() {
		$data = [];
		
	}

	public function detallesReparacion($idreparacion){
		$apiClient = ApiLib::getInstance();

		$extraccion = $apiClient->DetallesDeReparacionGet($idreparacion);

		$data['datosReparacion'] = $extraccion['DatosReparacion'];
		$data['serviciosReparacion'] = $extraccion['serviciosReparacion'];
		//print_r($data['datosReparacion']);
		return view('reparaciones/serviciosReparacion',$data);
	}


	public function deleteReparacion($idreparacion) {
		$apiClient = ApiLib::getInstance();
		
	}

	public function editReparacion($idreparacion) {
		$apiClient = ApiLib::getInstance();
		
	}

	
}
