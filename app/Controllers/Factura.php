<?php

namespace App\Controllers;
//Añadido
use CodeIgniter\HTTP\IncomingRequest;
use App\Libraries\ApiLib;


class Factura extends BaseController {
	public function index() {
		$data = [];
		$apiClient = new ApiLib($this->session->get('token'));
		$data['facturas'] = json_decode($apiClient->run("GET", "/facturas/empresa/".$this->session->get('idusuario'), []));

		return view('facturas/facturaList',$data);
	}

	public function detallesFactura($numerofactura,$idreparacion) {

		$data['idreparacion'] = $idreparacion;
		$data['numerofactura'] = $numerofactura;
		$apiClient = new ApiLib($this->session->get('token'));
		$data['extraccion'] = json_decode($apiClient->run("GET", "/serviciosreparaciones/detalles/".$idreparacion, []));
		

		$data['datosReparacion'] = $data['extraccion']->DatosReparacion;
		$data['serviciosReparacion'] = $data['extraccion']->serviciosReparacion;
		//print_r($data['datosReparacion']);
		return view('facturas/detallesFactura',$data);
		
	}


	public function anularFactura($idreparacion) {
		$apiClient = new ApiLib($this->session->get('token'));
		json_decode($apiClient->run("PUT", "/facturas/anularlareparacion/".$idreparacion, [],true));
		return redirect()->to(site_url('/Factura'));	
	}

	
}
