<?php

namespace App\Controllers;
//Añadido
use CodeIgniter\HTTP\IncomingRequest;
use App\Libraries\ApiLib;


class Factura extends BaseController {
	public function index() {
		$data = [];
		$apiClient = ApiLib::getInstance();
		$data['facturas'] = $apiClient->FacturasDeEmpresaGet();

		return view('facturas/facturaList',$data);
	}

	public function detallesFactura($numerofactura,$idreparacion) {
		
		$apiClient = ApiLib::getInstance();
		$extraccion = $apiClient->DetallesDeReparacionGet($idreparacion);//Es el mimso metodo para reparaciones que facturas
		$data['numerofactura'] = $numerofactura;
		$data['datosReparacion'] = $extraccion['DatosReparacion'];
		$data['serviciosReparacion'] = $extraccion['serviciosReparacion'];
		return view('facturas/detallesFactura',$data);
		
	}

	public function crearFactura($idreparacion) {
		$data = [];
		
	}

	public function anularFactura($idreparacion) {
		$apiClient = ApiLib::getInstance();
		
	}

	
}
