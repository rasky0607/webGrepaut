<?php

namespace App\Controllers;
//Añadido
use CodeIgniter\HTTP\IncomingRequest;
use App\Libraries\ApiLib;


class Servicio extends BaseController {
	public function index() {
		$data = [];
		$apiClient = ApiLib::getInstance();

		$data['servicios'] = $apiClient->ServiciosDeEmpresaGet();

		return view('servicios/servicioList',$data);
	}

	public function createServicio() {
		$data = [];
		
	}


	public function deleteServicio($idservicio) {
		$apiClient = ApiLib::getInstance();
		
	}

	public function editServicio($idservicio) {
		$apiClient = ApiLib::getInstance();
		
	}

	
}
