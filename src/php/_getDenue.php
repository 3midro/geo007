<?php
header('Access-Control-Allow-Origin: http://localhost:8000', false);
function __autoload($classname) {
    $filename = "clases/" . $classname . ".class.php";
    include_once($filename);
}
//recibe variables
$bbox= $_GET["bbox"];
$iuser= $_GET["iuser"];
$b = new busqueda();
$conmay = new maysql();
$conmay->conecta_vinom();
if (is_null($iuser)){
    $resp = $b->find($bbox, $conmay);
}else{
    $resp = $b->findFavs($bbox, $iuser, $conmay);
}


$conmay->cierra_conexion();
$resp=json_encode($resp);
echo $resp;

?>