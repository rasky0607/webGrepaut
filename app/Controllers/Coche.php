<?php

namespace App\Controllers;
//Añadido
use CodeIgniter\HTTP\IncomingRequest;
use App\Libraries\ApiLib;


class Coche extends BaseController {
	public function index() {
		$data = [];
		$apiClient = ApiLib::getInstance();

		$data['coches'] = $apiClient->CochesDeEmpresaGet();
		return view('coches/cocheList',$data);
	}

	public function createCliente() {
		$data = [];
		
	}


	public function deleteCoche($idcoche) {
		$apiClient = ApiLib::getInstance();
		
	}

	public function editCoche($idcoche) {
		$apiClient = ApiLib::getInstance();
		
	}


	
}
