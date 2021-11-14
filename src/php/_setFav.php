<?php
header('Access-Control-Allow-Origin: http://localhost:8000', false);
function __autoload($classname) {
    $filename = "clases/" . $classname . ".class.php";
    include_once($filename);
}
//recibe variables
$iuser= $_GET["iuser"];
$denue= $_GET["denue"];
$f = new favoritos();
$conmay = new maysql();
$conmay->conecta_vinom();
$resp = $f->manageFav($iuser, $denue, $conmay);
$conmay->cierra_conexion();
$resp=json_encode($resp);
echo $resp;

?>