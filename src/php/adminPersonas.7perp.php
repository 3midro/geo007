<?php
header('Access-Control-Allow-Origin: *', true);
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Pragma: no-cache');
function __autoload($classname) {
    $filename = "clases/" . $classname . ".class.php";
    include_once($filename);
}


//obtiene la operacion a realizar en base a ello solicita los parametros requeridos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Logica para solicitudes POST
    $operacion = $_POST["operacion"];
} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Logica para solicitudes GET
    $operacion = $_GET["operacion"];
}


switch($operacion){
    case 'post': //alta
        $curp= strtoupper($_POST["curp"]);

        $blacklits = $_POST["blacklist"];
        $renapo = $_POST["renapo"];
        $ine = $_POST["ine"];
        
        $nombre = strtoupper($_POST["nombre"]);
        $birthday = $_POST["birthday"];
        $entidad_nac = strtoupper($_POST["entidad_nac"]);
        $genero = strtoupper($_POST["genero"]);
        
        $celular = $_POST["celular"];
        $email = $_POST["email"];


        $v = new validaciones();
        // comienza las validaciones
        //$validaciones = $v->validaCURP($curp);
        
       // if ($validaciones){
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
                        $resp = $r->registraPersonaErp($curp, $blacklits, $renapo, $ine,  $nombre, $birthday, $entidad_nac, $genero, $celular, $email, $conmay);
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
        //}else{// else de la curp
           // $resp = array("code"=>400,"msj" => 'CURP invalido');
      //  }


        
        break;
    case 'get': //consulta
       
    break;
    case 'put': //actualizacion
    break;
    case 'delete': //eliminar
    break;
    default:
        $resp = array("code"=>400,"msj" => 'No se envió l aoperación a realizar correctamente');
    break;
}
//imprime la salida
$resp=json_encode($resp);
echo $resp;

?>