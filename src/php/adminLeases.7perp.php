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
        $curp_owner= strtoupper($_POST["curp_owner"]);
        $idinmueble = $_POST["idinmueble"];
        $idunidad = $_POST["idunidad"];
        $inmuebletxt= strtoupper($_POST["inmueble"]);
        $unidadtxt= strtoupper($_POST["unidadtxt"]);
        $precioregular = $_POST["precioregular"];
        $prontopago = $_POST["prontopago"];
        $startdate= $_POST["startdate"];
        $deposito = $_POST["deposito"];
        $depositconcept= strtoupper($_POST["depositconcept"]);
        $descuento = $_POST["descuento"];
        $discountdate = $_POST["discountdate"];
        $discountconcept= strtoupper($_POST["discountconcept"]);
        
        $depositconcept= ($depositconcept=="")?"NA":$depositconcept;
        $discountconcept= ($discountconcept=="")?"NA":$discountconcept;
       
        
        /*(IN `_CURP` VARCHAR(20), IN `_IDINMUEBLE` INT(2), IN `_IDUNIDAD` INT(2), IN `_INMUEBLETXT` VARCHAR(50), IN `_UNIDADTXT` VARCHAR(50), 
        IN `_PRECIOREGULAR` FLOAT, IN `_PRONTOPAGO` FLOAT, IN `_FECHA` DATE, IN `_DEPOSITO` FLOAT, IN `_DEPOSITCONCEPT` TEXT, IN `_DESCUENTO` FLOAT,
         IN `_DESCUENTODATE` DATE, IN `_DESCUENTOCONCEPT` TEXT)*/

        
         $conmay = new maysql();
         $conmay->conecta_7p();
         $r = new registro();
         $resp = $r->registraLease($curp, $curp_owner, $idinmueble, $idunidad, $inmuebletxt, $unidadtxt, $precioregular, $prontopago, $startdate, $deposito, $depositconcept, $descuento, $discountdate, $discountconcept, $conmay);
         //$idlease = $conmay->idinsertado();
         $conmay->cierra_conexion(); 
         $resp = array("code"=>200,"msj" => 'Contrato generado exitosamente!!');
        
      
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