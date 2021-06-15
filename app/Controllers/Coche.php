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

	public function createCoche() {
		$data = [];
		$apiClient = ApiLib::getInstance();
		$data['clientes'] = $apiClient->ClientesDeEmpresaGet();
		
		return view('coches/newCoche',$data);
		
	}


	public function deleteCoche($idcoche) {
		$apiClient = ApiLib::getInstance();
		
	}

	public function editCoche($idcoche,$idcliente) {
		$data = [];
		$data['error'] = '';
		$data['idcoche'] = $idcoche;
		$data['idcliente'] = $idcliente;
		$apiClient = ApiLib::getInstance();
		//clientes para el desplegable de la edicion
		$data['clientes'] = $apiClient->ClientesDeEmpresaGet();
		//Rellena campos de datos del vehiculo
		$result = $apiClient->CochesDatosGet($idcoche);

		//Prepara datos para pintar en la vista
		foreach ($result as $item) {

			$data["matricula"] = $item["matricula"];
			$data["marca"] = $item["marca"];
			$data["modelo"] = $item["modelo"];
		}
	
		if ($this->request->getMethod() == 'post') {
			if (empty($this->request->getVar('matricula')) || empty($this->request->getVar('marca')) || empty($this->request->getVar('idcliente'))) {

				$data["error"] = "¡Debes rellenar obligatoriamente los cambos con un *!.";

			}else {

				//Guardar datos
				$matricula = $this->request->getVar('matricula');
				$marca = $this->request->getVar('marca');
				$modelo = $this->request->getVar('modelo');
				$idclienteNuevo = $this->request->getVar('idcliente');
				

				if($apiClient->ActualizarCoche($idcliente,$matricula,$marca,$modelo)) {

					//Todo correcto, lo devolvemos al listado
					return redirect()->to(site_url('/Coche'));

				}else {
					
					return view('coches/editCoche',$data);
				}
			} 
		}


		return view('coches/editCoche',$data);
	}


	
}
