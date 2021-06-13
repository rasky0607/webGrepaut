<?php

namespace App\Controllers;
//Añadido
use CodeIgniter\HTTP\IncomingRequest;
use App\Libraries\ApiLib;


class Cliente extends BaseController {
	public function index() {
		$data = [];
		$apiClient = ApiLib::getInstance();

		$data['clientes'] = $apiClient->ClientesDeEmpresaGet();
		//print_r($data['clientes'][0]);
		//print_r($data['clientes'][0]['nombre']);
		//echo $data['clientes']['nombre'];
		return view('clientes/clienteList',$data);
	}

		public function createCliente() {
		$data = [];
		
	}


	public function deleteCliente($idcliente) {
		//echo "el id es ".$idcliente;
		$apiClient = ApiLib::getInstance();
		$apiClient->DeleteClienteDeEmpresa($idcliente);
	}

	public function editCliente($idcliente) {
		$apiClient = ApiLib::getInstance();
		
	}

	
}
