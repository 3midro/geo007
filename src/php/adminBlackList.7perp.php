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
        $motivo = $_POST["motivo"];
        $externo = $_POST["externo"];
        // comienza las validaciones simples
        $v = new validaciones();
        // comienza las validaciones
        $validaciones = $v->validaCURP($curp);
        if ($validaciones){
            $conmay = new maysql();
            $conmay->conecta_7p();
            $r = new registro();
            $resp = $r->registraPersonaBlackList($curp, $motivo, $externo, $conmay);
            $conmay->cierra_conexion(); 
            $resp = array("code"=>200,"msj" => $curp.' registrada en lista negra exitosamente');
        }else{
            $resp = array("code"=>400,"msj" => 'CURP invalido');
        }
        break;
    case 'get': //consulta
        $curp= strtoupper($_GET["curp"]);
        $v = new validaciones();
        // comienza las validaciones
        $validaciones = $v->validaCURP($curp);
        if ($validaciones){
            $b = new busqueda();
            $conmay = new maysql();
            $conmay->conecta_7p();
            $resp = $b->buscaEnListaNegra($curp, $conmay);
            $conmay->cierra_conexion(); 
        }else{
            $resp = array("code"=>400,"msj" => 'CURP invalido');
        }
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