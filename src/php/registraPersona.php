<?php
ini_set( 'display_errors', 1 );
error_reporting( E_ALL );
header('Access-Control-Allow-Origin: *', true);
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Pragma: no-cache');
function __autoload($classname) {
    $filename = "clases/" . $classname . ".class.php";
    include_once($filename);
}



$curp= strtoupper($_POST["curp"]);
$email = $_POST["email"];
$whats = $_POST["whats"];
$numfav = $_POST["numfav"];
$id = $_POST["id"];
$nombre = $_POST["nombre"];
$precio = $_POST["precio"];

// comienza las validaciones simples
$v = new validaciones();
// comienza las validaciones
$validaciones = $v->validaCURP($curp);

if ($validaciones){
	// whats
	$validaciones = $v->validaWHATS($whats);	
	if ($validaciones){
		//email
		$validaciones = $v->validaEMAIL($email);
		if ($validaciones){
			//registra a la persona si no existe, si existe no la registra
				$conmay = new maysql();
				$conmay->conecta_7p();
				$r = new registro();
				$resp = $r->registraPersona($curp, $whats, $numfav, $email, $conmay);
				$conmay->cierra_conexion(); 
			
				if ($resp){ // si hace el registro debe notificar a plataforma y usuario
					// envia el email a geopanda
					$e = new email7P();
					$resp = $e->e7P($curp, $whats, $email, $id, $nombre, $precio);
					if (!empty($email)){
						//envia el email al usuario de que su petición ha sido recibida
						$resp = $e->emailRegistro($curp, $whats, $email, $id, $nombre, $precio);		
					}
					$resp = array("code"=>200,"msj" => 'Registro de '.$curp.' exitoso'); 
				}else{
					$resp = array("code"=>200,"msj" => $curp.' existente');
				}
		}else{// else email
			$resp = array("code"=>400,"msj" => 'Email invalido');
		}
	}else{//else del whats
		$resp = array("code"=>400,"msj" => 'Whats invalido');
	}
}else{// else de la curp
	$resp = array("code"=>400,"msj" => 'CURP invalido');
}
$resp=json_encode($resp);
echo $resp;

?>