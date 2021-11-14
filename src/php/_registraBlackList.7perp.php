<?php
header('Access-Control-Allow-Origin: *', true);
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Pragma: no-cache');
function __autoload($classname) {
    $filename = "clases/" . $classname . ".class.php";
    include_once($filename);
}

$curp= strtoupper($_POST["curp"]);
$motivo = $_POST["motivo"];
$externo = $_POST["externo"];


//echo "CURP RECIBIDA EN PHP: ".$curp;
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
    $resp = array("code"=>200,"msj" => $curp.' registrada exitosamente');
}else{
    $resp = array("code"=>400,"msj" => 'CURP invalido');
}

$resp=json_encode($resp);
echo $resp;

?>