<?php

namespace App\Controllers;
//Añadido
use CodeIgniter\HTTP\IncomingRequest;
use App\Libraries\ApiLib;

include APPPATH.'Libraries/fpdf183/fpdf.php';



class Factura extends BaseController {
	public function index() {
		$data = [];
		//Si pasa o no pasa parametros por el buscador o filtro
		if ($this->request->getMethod() == 'post') {
			if(!empty($this->request->getVar('cadena'))){
				$dataFilter = $this->filtroFacturas();
				return view('facturas/facturaList',$dataFilter);
			}
		}

		$apiClient = new ApiLib($this->session->get('token'));
		$data['facturas'] = json_decode($apiClient->run("GET", "/facturas/empresa/".$this->session->get('idusuario'), []));

		//TEST LIBRERIA PDF
		//$this->p();
		
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

	function filtroFacturas(){	
		//Si la cadena es vacia
		if(empty($this->request->getVar('cadena'))){
			return redirect()->to(site_url('/Factura'));			
		}

		$apiClient = new ApiLib($this->session->get('token'));
		$data['facturas'] = json_decode($apiClient->run("GET", "/facturas/empresa/buscar/".$this->session->get('idempresa')."/".$this->request->getVar('cadena'),[]));				

		if(empty($data['facturas']->Error)){
			//return view('usuarios/gestionUsuariosView',$data);
			return $data;
		}else{
			$dataVacio['facturas'] = [];
			return $dataVacio;
			//return view('usuarios/gestionUsuariosView',$dataVacio);
		}
	}
	
	
	function p (){
		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',16);
		$pdf->Cell(40,10,'Hello World!');
		$pdf->Output();
	}

	
}
