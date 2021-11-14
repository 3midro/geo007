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

/*birthday: "1984-02-18"
celular: ""
curp: "saae840218hasrrd09"
email: ""
entidad_nac: "AS"
genero: "H"
nombre: "EDUARDO SARELLANO ARTEAGA"
renapo: []
_renapo: 0
_x: 0.8318003439687007 */

$curp= strtoupper($_POST["curp"]);
$nombre = strtoupper($_POST["nombre"]);
$renapo = $_POST["_renapo"];
$birthday = $_POST["birthday"];
$email = strtoupper($_POST["email"]);
$celular = $_POST["celular"];
$entidad_nac = strtoupper($_POST["entidad_nac"]);
$genero = strtoupper($_POST["genero"]);
// comienza las validaciones simples
$v = new validaciones();
// comienza las validaciones
$validaciones = $v->validaCURP($curp);

if ($validaciones){
	// whats
	$validaciones = $v->validaWHATS($celular);	
	if ($validaciones){
		//email
		$validaciones = $v->validaEMAIL($email);
		if ($validaciones){
			//registra a la persona si no existe, si existe no la registra
				$conmay = new maysql();
				$conmay->conecta_7p();
				$r = new registro();
				$resp = $r->registraPersonaErp($curp, $nombre, $renapo, $birthday, $email, $celular, $entidad_nac, $genero, $conmay);
				$conmay->cierra_conexion(); 
			
				if ($resp){ // si hace el registro debe notificar a plataforma y usuario
					// envia el email a geopanda
					/*$e = new email7P();
					$resp = $e->e7P($curp, $whats, $email, $id, $nombre, $precio);
					if (!empty($email)){
						//envia el email al usuario de que su petición ha sido recibida
						$resp = $e->emailRegistro($curp, $whats, $email, $id, $nombre, $precio);		
					}*/
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