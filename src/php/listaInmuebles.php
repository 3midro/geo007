<?php
header('Access-Control-Allow-Origin: *', true);
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Pragma: no-cache');
function __autoload($classname) {
    $filename = "clases/" . $classname . ".class.php";
    include_once($filename);
}
//recibe variables
//$_x= $_GET["_x"];
$b = new busqueda();
$conmay = new maysql();
$conmay->conecta_7p();
$resp = $b->comboInmuebles($conmay);
//$conmay->cierra_conexion();
$resp=json_encode($resp);
echo $resp;


?>