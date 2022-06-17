<?php
use App\Libraries\ApiLib;

function mydd($var)
{
	var_dump("<pre>", $var, "</pre>");
	die();
}

function mydump($var)
{
	var_dump("<pre>", $var, "</pre>");
}

//FIltros
/*function filtrado($tabla, $idempresa, $cadena,$token){
	$data = [];
	switch ($tabla) {
		case 'usuarios':
			$dataFind = [
				'email' => $cadena,
				'idempresa' => $idempresa
			];

			$apiClient = new ApiLib($token);
			$data['usuarios'] = json_decode($apiClient->run("POST", "/usuarios/buscar",$dataFind));		
			$result = json_decode($apiClient->run("GET", "/empresas/".$idempresa, []));     
			$data ['empresa'] = [
				'nombreEmpresa' => $result->Empresa[0]->nombre
			];
			
		break;
		case 'facturas':
			echo "i es igual a 1";
		break;
		case 'facturas':
			echo "i es igual a 1";
		break;
		case 'facturas':
			echo "i es igual a 1";
		break;
		case 'facturas':
			echo "i es igual a 1";
		break;
		case 'facturas':
			echo "i es igual a 1";
		break;
		case 'facturas':
			echo "i es igual a 1";
		break;
		case 'facturas':
			echo "i es igual a 2";
		break;
	}
	return $data;

}*/