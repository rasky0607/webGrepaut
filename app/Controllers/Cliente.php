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

		return view('clientes/clienteList',$data);
	}

	//Muestra un listado de coches que pertenecen a un cliente
	public function detallesCochesEnPropiedad($idcliente,$nombreCliente) {
		$data = [];
		$apiClient = ApiLib::getInstance();
		$data['nombreCliente'] = $nombreCliente;
		$data['idcliente'] = $idcliente;
		$data['coches'] = $apiClient->CochesDeClienteGet($idcliente);
		return view('clientes/detallesClienteCochesPropiedad',$data);
	}


	//NO VA
	public function createCliente() {
		$data["error"] = "";

		if ($this->request->getMethod() == 'post') {

			if (empty($this->request->getVar('nombre')) || empty($this->request->getVar('apellido')) || empty($this->request->getVar('tlf'))){

				$data["error"] = "¡Debes rellenar obligatoriamente los cambos con un *!.";
			} 
			else {

				$nombre = $this->request->getVar('nombre');
				$apellido = $this->request->getVar('apellido');
				$tlf = $this->request->getVar('tlf');
				$email = $this->request->getVar('email');

				$apiClient = ApiLib::getInstance();

				if($apiClient->CreateClienteDeEmpresaPost($nombre,$apellido,$tlf,$email)) {

					//Todo correcto, lo devolvemos al listado
					return redirect()->to(site_url('/Cliente'));
				}else {

					//Mostramos la vista con el error
					return view('clientes/newCliente',$data);
				}
			}
		}

		return view('clientes/newCliente',$data);
	}


	public function deleteCliente($idcliente) {
		$apiClient = ApiLib::getInstance();
		$apiClient->DeleteClienteDeEmpresa($idcliente);
	}

	public function editCliente($idcliente) {

		$data["error"] = "";
		$data["idcliente"] = $idcliente;
		$apiClient = ApiLib::getInstance();
		$result = $apiClient->ClienteDatosGet($idcliente);

		//Prepara datos para pintar en la vista
		foreach ($result as $item) {

			$data["nombre"] = $item["nombre"];
			$data["apellido"] = $item["apellido"];
			$data["tlf"] = $item["tlf"];
			$data["email"] = $item["email"];
		}
		
		if ($this->request->getMethod() == 'post') {
			if (empty($this->request->getVar('nombre')) || empty($this->request->getVar('apellido')) || empty($this->request->getVar('tlf'))) {

				$data["error"] = "¡Debes rellenar obligatoriamente los cambos con un *!.";

			}else {

				//Guardar datos
				$nombre = $this->request->getVar('nombre');
				$apellido = $this->request->getVar('apellido');
				$tlf = $this->request->getVar('tlf');
				$email = $this->request->getVar('email');
				if($apiClient->ActualizarCliente($idcliente,$nombre,$apellido,$tlf,$email)) {

					//Todo correcto, lo devolvemos al listado
					return redirect()->to(site_url('/Cliente'));

				}else {
					
					return view("clientes/editCliente",$data);
				}
			} 
		}

		return view("clientes/editCliente",$data);
		
	}



	

	
}
