<?php
header('Access-Control-Allow-Origin: *', true);
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Pragma: no-cache');
function __autoload($classname) {
    $filename = "clases/" . $classname . ".class.php";
    include_once($filename);
}

$conmay = new maysql();
$conmay->conecta_7p();
$q = 'CALL getTransfers2pay();';
$r = $conmay->consulta($q);
$n = $conmay->filas($r);
if ($n >= 1) {
    $e = array();
    while ($fila = $conmay->vector($r)) {
        $feature = array(
            "no_registro"=>$fila["no_registro"],
            "nombre_completo"=>utf8_encode($fila["nombre_completo"]),
            "clabe"=>$fila["clabe"],
            "monto"=>$fila["monto"],
            "monto_des"=>"$".$fila["monto"]." MXN",
            "concepto"=>utf8_encode($fila["concepto"]),
            "email"=>utf8_encode($fila["email"]),
            "destino"=>$fila["destino"],
            "alias"=>utf8_encode($fila["alias"])
        );                  
            array_push($e,$feature);
        }

    
}


/*$data = array(
    array("First Name" => "Natly", "Last Name" => "Jones", "Email" => "natly@gmail.com", "Message" => "Test message by Natly"),
    array("First Name" => "Codex", "Last Name" => "World", "Email" => "info@codexworld.com", "Message" => "Test message by CodexWorld"),
    array("First Name" => "John", "Last Name" => "Thomas", "Email" => "john@gmail.com", "Message" => "Test message by John"),
    array("First Name" => "Michael", "Last Name" => "Vicktor", "Email" => "michael@gmail.com", "Message" => "Test message by Michael"),
    array("First Name" => "Sarah", "Last Name" => "David", "Email" => "sarah@gmail.com", "Message" => "Test message by Sarah")
);
*/
$resp=json_encode(array("data" => $e));
echo $resp;

?>