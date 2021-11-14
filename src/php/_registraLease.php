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


    $idinmuble = $_POST["inmuebles"];
    $inquilino= strtoupper($_POST["inquilino"]);
    $unidad = $_POST["unidad"];
    $renta = $_POST["marketRent"];
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
                if(!is_null($idinmuble)){
                    if(!is_null($unidad)){
                        if(!is_null($renta)){
                            $conmay = new maysql();
                            $conmay->conecta_7p();
                            $r = new registro();
                            //$resp = $r->registraLease($inquilino, $unidad, $renta, $fechaInicial, $conmay);
                            $conmay->cierra_conexion();
                            if ($resp){
                                $resp = array("code"=>200,"msj" => 'Registro de Contrato exitoso!!');
                            } else{
                                $resp = array("code"=>400,"msj" => 'Fallo el procedimiento almacenado');
                            }
                            
                        }else{ //cuando renta viene null 
                            $resp = array("code"=>400,"msj" => 'monto de renta invalida');
                        }
                    }else{ //cuando unidad viene null 
                    $resp = array("code"=>400,"msj" => 'habitacion invalida');
                }   
                }else{ //cuando inmueble viene null 
                    $resp = array("code"=>400,"msj" => 'inmueble invalido');
                }
            }else{// cuando la fecha no es valida
                $resp = array("code"=>400,"msj" => 'fecha invalida');
            }
        }else{// cuando la curp no es valida
            $resp = array("code"=>400,"msj" => 'curp invalida');
        }
    
    $resp=json_encode($resp);
    echo $resp;
?>