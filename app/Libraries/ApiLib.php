<?php

namespace App\Libraries;

use App\Libraries\EventLib;



class ApiLib {

	public $url = "http://api.devsan.es";
	public $token;

	public function __construct($token = "", $email = "", $password = "") {
		if(!empty($token)){
			$this->token = $token;
		}
	}

	function run($method, $endpoint, $data, $urlEncode = false){
		$endpoint = $this->url . $endpoint;
		$curl = curl_init();

		switch ($method){
			case "POST":
			curl_setopt($curl, CURLOPT_POST, 1);
			if ($data) {
				if($urlEncode) {
					curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
				}
				else {
					curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
				}
			}
			break;
			case "PUT":
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
			if ($data){
				if($urlEncode) {
					curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));	
				}
				else {
					curl_setopt($curl, CURLOPT_POSTFIELDS, $data);	
				}		 					
			}
			break;
			case "DELETE":
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
			break;
			default:
			if ($data)
				$endpoint = sprintf("%s?%s", $endpoint, http_build_query($data));
			break;
		}

		// CONFIG
		curl_setopt($curl, CURLOPT_URL, $endpoint);

		if(!empty($this->token)) {
			curl_setopt($curl, CURLOPT_HTTPHEADER, array(
				'token: ' . $this->token
			));
		}
		
		
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		
		// EXECUTE:
		$result = curl_exec($curl);

		if(!$result){
			die("Conexion con la API Fallida");
		}

		curl_close($curl);
		
		return $result;
	}

	function inicioDeSession($email , $password) {
		$data = [
			'email' => $email,
			'password' => $password
		];

		$response = $this->run("POST", "/login", $data, true);

		return json_decode($response);
	}
} 

