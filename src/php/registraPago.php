<?php
header('Access-Control-Allow-Origin: *', true);
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Pragma: no-cache');
function __autoload($classname) {
    $filename = "clases/" . $classname . ".class.php";
    include_once($filename);
}

$nombre = utf8_encode($_POST["inquilino_nombre"]);
$grupo = utf8_encode($_POST["grupo"]);
$inquilino= strtoupper($_POST["inquilino_pago"]);
$monto = $_POST["monto"];
$comentario = utf8_encode($_POST["comentario"]);
$fechaInicial = $_POST["fechaInicial"];
$_x = $_POST["_x"];

 


    // comienza las validaciones simples
    $v = new validaciones();
// comienza las validaciones
$validaciones = $v->validaCURP($inquilino);
        if ($validaciones){
            $validaciones = $v->validaFecha($fechaInicial);
            if ($validaciones){
                // que no venga ningun valor nulos
                    if(!is_null($monto)){
                       
                            $conmay = new maysql();
                            $conmay->conecta_7p();
                            $r = new registro();
                            $resp = $r->registraPago($nombre, $grupo, $inquilino,  $monto, $comentario, $fechaInicial, $conmay);
                            $conmay->cierra_conexion(); 
                            if ($resp){
                                $resp = array("code"=>200,"msj" => 'Registro de Pago exitoso!!');
                            } else{
                                $resp = array("code"=>400,"msj" => 'Fallo el procedimiento almacenado');
                            }
                       
                    }else{ //cuando monto viene null 
                    $resp = array("code"=>400,"msj" => 'Monto invalido');
                }   
               
            }else{// cuando la fecha no es valida
                $resp = array("code"=>400,"msj" => 'fecha invalida');
            }
        }else{// cuando la curp no es valida
            $resp = array("code"=>400,"msj" => 'curp invalida');
        }
    
    
    //$resp = array("code"=>200,"msj" => $nombre);
    $resp=json_encode($resp);
    echo $resp;
?>