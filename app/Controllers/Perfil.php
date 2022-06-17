<?php

namespace App\Controllers;
//Añadido
use CodeIgniter\HTTP\IncomingRequest;
use App\Libraries\ApiLib;

class Perfil extends BaseController
{
    
    public function index() {
        $data ['empresa'] = [];
        $data["error"] = "";
//Si es de tipo admin puede añadir o cambiar foto de empresa,sino, no
        
        //obtenemos datos de la empresa del usuario
        $apiClient = new ApiLib($this->session->get('token'));
        $result = json_decode($apiClient->run("GET", "/empresas/".$this->session->get('idempresa'), []));
        //print_r($result->Empresa[0]->nombre);
        //echo "holaaaa";
        
        //die();
        //$data[''] = $data->Empresa[0]->nombre;
        
        $logoDeEmpresa;
        if(empty($result->Empresa[0]->logoempresa)){
            $logoDeEmpresa = "favicon.png";//Imagen por defecto
        }
        else{
            $logoDeEmpresa = $result->Empresa[0]->logoempresa;//El logo guardado en la BD
        }
        $data ['empresa'] = [
                'idempresa'=>$this->session->get('idempresa'),
                'nombreEmpresa' => $result->Empresa[0]->nombre,
                'direccionEmpresa' => $result->Empresa[0]->direccion,
                'tlfEmpresa' => $result->Empresa[0]->tlf,
                'logoEmpresa' => $logoDeEmpresa
            ];

        
        return view('perfil/perfiluserview',$data);
    }

    public function changePassword() {

		$data["error"] = "";
		if ($this->request->getMethod() == 'post') {

			if (empty($this->request->getVar('password1')) || empty($this->request->getVar('password2'))){
				var_dump($this->request->getVar('password1'), " - ",$this->request->getVar('password2'));
				$data["error"] = "¡Debes rellenar obligatoriamente los cambos con un *!.";
				return view('perfil/perfilChangePasswordView',$data);
			}
			else if($this->request->getVar('password1') != $this->request->getVar('password2')){				
				$data["error"] = "¡Las contraseñas deben coincidir!.";
				return view('perfil/perfilChangePasswordView',$data);
			}
			else if(!$this->validar_password($this->request->getVar('password1'))){
				$data["error"] = "Las contraseñas deben tener al menos 6 caracteres, una minúscula», mayúscula y un numero.";
				return view('perfil/perfilChangePasswordView',$data);
			} 
			else {

				$data = [
					'password' => $this->request->getVar('password1')
				];

				if(!empty($this->request->getVar('email'))) {
					$data['email'] = $this->request->getVar('email');
				}

				$apiClient = new ApiLib($this->session->get('token'));
				$result = json_decode($apiClient->run("PUT", "/usuarios/".$this->session->get('idusuario'), $data,true));
				if(!empty($result->usuario)) {
                    //var_dump($result->usuario);
					//Todo correcto, lo devolvemos al Perfil
					return redirect()->to(site_url('/Perfil/'));	
				} 
				else if(empty($result->usuario) && !empty($result->Error)) {
					$data['error'] = $result->Error;
					return view('perfil/perfilChangePasswordView',$data);
				} 
				else {
					$data['error'] = 'No se ha podido cambiar la contraseña';
					//Mostramos la vista con el error
					return view('perfil/perfilChangePasswordView',$data);
				}
			}
		}

		//return redirect()->to(site_url('/Usuario/'));
        //echo "Holaaaaa";
		return view('perfil/perfilChangePasswordView',$data);
	}

    public function upload() {

        $nombre=$_FILES['archivo']['name'];
        $guardado_tmp=$_FILES['archivo']['tmp_name'];
        //APPPATH."assetsUsers/"
        $mypath = "/var/www/webGrepaut/public/assets/pictures/";
        $extension = substr($nombre, strlen($nombre) - 4, 5);
        $nombreFinalArchivo = $this->session->get('idempresa').$extension;
        //var_dump($extension);
        if (strtoupper($extension) == ".JPG" || strtoupper($extension) == ".PNG" || strtoupper($extension) == ".GIF" || strtoupper($extension) == ".JPEG"){

            if (!file_exists($mypath)){
    
                mkdir($mypath, 0777, true);
    
                if (file_exists($mypath)) {

                    if (move_uploaded_file($guardado_tmp, $mypath.$nombreFinalArchivo)) {

                        //echo "Archivo guardado con exito";
                        //Llamada a la api para guardar la imagen en la BD
                        $this->updateLogoBD($nombreFinalArchivo,$this->session->get('idempresa')); 
                    } 
                    else {
                        echo "Error al guardar el archivo";
                    }
                }
            }
            else {
                if (move_uploaded_file($guardado_tmp, $mypath.$nombreFinalArchivo)) {

                    //echo "Archivo guardado con exito, ".$mypath.$nombreFinalArchivo;
                    $this->updateLogoBD($nombreFinalArchivo,$this->session->get('idempresa'));
                    return redirect()->to(site_url('/Perfil'));
                } 
                else {
                    echo "Error al guardar el archivo ".$nombre." en ".$mypath;
                }  
            }
        }
        else{
            echo "El fichero no cumple el formato  ".$nombre;
        }
        
        
    }

    function updateLogoBD($nombreFinalArchivo,$idempresa){
        //Guardar datos
        $data = [
            'logo' => $nombreFinalArchivo
        ];
        $apiClient = new ApiLib($this->session->get('token'));
        $result = json_decode($apiClient->run("PUT", "/empresas/".$idempresa, $data,true));
				                      
        //Todo correcto, lo devolvemos al listado
          
             
    }


    public function validar_password($password){
        if(strlen($password) < 6){			
            return false;
        }
        if (!preg_match('/[a-z]/',$password)){		
            //var_dump("No minusculas"." ".$password);
            return false;
        }
        if (!preg_match('/[A-Z]/',$password)){	
            //var_dump("No mayus"." ".$password);		
            return false;
        }
        if (!preg_match('/[0-9]/',$password)){		
            //var_dump("No numeros"." ".$password);	
            return false;
        }			
        return true;
    }

}

