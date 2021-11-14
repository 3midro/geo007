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

       /* cantidad: "0"
categoria: "0"
concepto: "sdasadsas"
cuenta: "1"
cuenta_destino: "2"
fecha: "2021-11-09"
saldo_current: "0.00"
saldo_updated: "0"
tipo_movimiento: "T"*/

        $cantidad = $_POST["cantidad"];
        $categoria = $_POST["categoria"];
        $concepto= strtoupper($_POST["concepto"]);
        $cuenta = $_POST["cuenta"];
       
        $fecha = $_POST["fecha"];
        $saldo_current = $_POST["saldo_current"];
        $saldo_updated = $_POST["saldo_updated"];
        $tipo_movimiento = strtoupper($_POST["tipo_movimiento"]);



        
         $conmay = new maysql();
         $conmay->conecta_7p();

switch($tipo_movimiento){
    case "I": case "E": case "A":
        $q= "INSERT INTO cat_cuentas_movimientos (cuenta, fecha, idcategoria,tipomovimiento,cantidad,saldo_previo,nuevo_saldo,comentarios) 
        VALUES( $cuenta, '$fecha',$categoria, '$tipo_movimiento', $cantidad, $saldo_current, $saldo_updated, '$concepto');";  
        break;
        case "T":
            $cuenta_destino = $_POST["cuenta_destino"];
            $saldo_destino = $_POST["saldo_destino"];
            $nuevo_saldo = floatval($saldo_destino) + floatval($cantidad);
            
         /*   $q= "INSERT INTO cat_cuentas_movimientos (cuenta, fecha, idcategoria,tipomovimiento,cantidad,saldo_previo,nuevo_saldo,comentarios) 
        VALUES( $cuenta, '$fecha',$categoria, 'TE', $cantidad, $saldo_current, $saldo_updated, '$concepto');
        INSERT INTO cat_cuentas_movimientos (cuenta, fecha, idcategoria,tipomovimiento,cantidad,saldo_previo,nuevo_saldo,comentarios) 
        VALUES( $cuenta_destino, '$fecha',$categoria, 'TI', $cantidad, $saldo_destino, $nuevo_saldo, '$concepto')";*/

$q= "INSERT INTO cat_cuentas_movimientos (cuenta, fecha, idcategoria,tipomovimiento,cantidad,saldo_previo,nuevo_saldo,comentarios) 
VALUES( $cuenta, '$fecha',$categoria, 'TE', $cantidad, $saldo_current, $saldo_updated, '$concepto'),( $cuenta_destino, '$fecha',$categoria, 'TI', $cantidad, $saldo_destino, $nuevo_saldo, '$concepto');";

            break;
}

       

       
               
         $r = $conmay->consulta($q);

        /* $r = new registro();
         $resp = $r->registraLease($curp, $curp_owner, $idinmueble, $idunidad, $inmuebletxt, $unidadtxt, $precioregular, $prontopago, $startdate, $deposito, $depositconcept, $descuento, $discountdate, $discountconcept, $conmay);*/
 
         $idmov = $conmay->idinsertado();
         $conmay->cierra_conexion(); 
         $resp = array("code"=>200,"msj" => 'Registro '.$idmov.' generado exitosamente!!', "query" => $q);
        
      
        break;
    case 'get': //consulta     
        $listado = $_GET["listado"];
        $conmay = new maysql();
        $conmay->conecta_7p();

            switch ($listado){
                case "movimientos_x_cuenta":
                    $cuenta = $_GET["cuenta"];
                    $q = 'SELECT cm.*, ccc.categoria,ccc.icon,ccc.color  FROM cat_cuentas_movimientos cm LEFT join cat_cuentas_categorias ccc on cm.idcategoria = ccc.idcategoria WHERE cm.cuenta = '.$cuenta.' ORDER BY cm.movimiento DESC;';
                    $r = $conmay->consulta($q);
                    $n = $conmay->filas($r);
                    if ($n >= 1) {
                        $e = array();
                        while ($fila = $conmay->vector($r)) {
                            $feature = array(
                                "movimiento"=>$fila["movimiento"],
                                "fecha"=>$fila["fecha"],
                                "timemark"=>$fila["timemark"],
                                "idcategoria"=>$fila["idcategoria"],
                                "comentarios"=>utf8_encode($fila["comentarios"]),
                                "categoria"=>utf8_encode($fila["categoria"]),
                                "cantidad"=>$fila["cantidad"],
                                "saldo_previo"=>$fila["saldo_previo"],
                                "nuevo_saldo"=>$fila["nuevo_saldo"],
                                "tipomovimiento"=>utf8_encode($fila["tipomovimiento"]),
                                "icon"=>utf8_encode($fila["icon"]),
                                "color_categoria"=>utf8_encode($fila["color"])
                                );
                            array_push($e,$feature);
                        }
                    }
                    $resp = array(
                        "code"=>200,
                        "elementos" =>$e,
                        "query"=> $q
                    );
                    break;
                case "saldos_x_cuenta":
                    $q = 'SELECT cc.cat_cuenta, cc.alias, cc.banco, T1.folio, T2.fecha, T2.idcategoria, T2.tipomovimiento, T2.cantidad, T2.saldo_previo, T2.nuevo_saldo, T2.comentarios, cc.suma_al_total from cat_cuentas cc LEFT JOIN (SELECT cuenta, max(movimiento) as folio FROM cat_cuentas_movimientos GROUP by cuenta ) as T1 ON cc.cat_cuenta = T1.cuenta LEFT join cat_cuentas_movimientos AS T2 ON T1.folio = T2.movimiento;';
                    $r = $conmay->consulta($q);
                    $n = $conmay->filas($r);
                    if ($n >= 1) {
                        $e = array();
                        while ($fila = $conmay->vector($r)) {

                            $saldo =(is_null($fila["nuevo_saldo"]))?0:$fila["nuevo_saldo"];
                            $diferencia = $saldo - $fila["saldo_previo"];
                            $feature = array(
                                "idcuenta"=>$fila["cat_cuenta"],
                                "alias"=>utf8_encode($fila["alias"]),
                                "banco"=>utf8_encode($fila["banco"]),
                                "saldo"=>$saldo,
                                "diferencia"=>$diferencia,
                                "fecha"=>$fila["fecha"],
                                "balance"=>$fila['suma_al_total']
                                );
                            array_push($e,$feature);
                        }
                    }
                    $resp = array(
                        "code"=>200,
                        "elementos" =>$e,
                        "query"=> $q
                    );
                    break;
                    case "gastos_x_mes":
                        $q="SELECT cm.idcategoria,cc.categoria,cc.tipo, sum(cm.cantidad) as gasto_total, concat(YEAR(cm.fecha) , '/',MONTH(cm.fecha)) as fecha, cc.color FROM cat_cuentas_movimientos cm LEFT JOIN cat_cuentas_categorias cc ON cc.idcategoria = cm.idcategoria WHERE cm.tipomovimiento = 'E' AND YEAR(cm.fecha) = YEAR(CURRENT_DATE()) AND MONTH(cm.fecha) = MONTH(CURRENT_DATE()) GROUP BY cm.idcategoria;";
                        $r = $conmay->consulta($q);
                        $n = $conmay->filas($r);
                        if ($n >= 1) {
                            $e = array();
                            while ($fila = $conmay->vector($r)) {
                              
                                $feature = array(
                                    "idcategoria"=>$fila["idcategoria"],
                                    "categoria"=>utf8_encode($fila["categoria"]),
                                    "tipo"=>utf8_encode($fila["tipo"]),
                                    "gasto_total"=>$fila["gasto_total"],
                                    "fecha"=>$fila["fecha"],
                                    "color"=>$fila["color"]
                                    );
                                array_push($e,$feature);
                            }
                        }
                        $resp = array(
                            "code"=>200,
                            "elementos" =>$e,
                            "query"=> $q
                        );
                        break;
                        case "ingresos_x_mes":
                            $q="SELECT cm.idcategoria,cc.categoria,cc.tipo, sum(cm.cantidad) as gasto_total, concat(YEAR(cm.fecha) , '/',MONTH(cm.fecha)) as fecha, cc.color FROM cat_cuentas_movimientos cm LEFT JOIN cat_cuentas_categorias cc ON cc.idcategoria = cm.idcategoria WHERE cm.tipomovimiento = 'I' AND YEAR(cm.fecha) = YEAR(CURRENT_DATE()) AND MONTH(cm.fecha) = MONTH(CURRENT_DATE()) GROUP BY cm.idcategoria;";
                            $r = $conmay->consulta($q);
                            $n = $conmay->filas($r);
                            if ($n >= 1) {
                                $e = array();
                                while ($fila = $conmay->vector($r)) {
                                  
                                    $feature = array(
                                        "idcategoria"=>$fila["idcategoria"],
                                        "categoria"=>utf8_encode($fila["categoria"]),
                                        "tipo"=>utf8_encode($fila["tipo"]),
                                        "gasto_total"=>$fila["gasto_total"],
                                        "fecha"=>$fila["fecha"],
                                        "color"=>$fila["color"]
                                        );
                                    array_push($e,$feature);
                                }
                            }
                            $resp = array(
                                "code"=>200,
                                "elementos" =>$e,
                                "query"=> $q
                            );
                            break;
            }
            $conmay->cierra_conexion(); 
           // $resp = array("code"=>200,"msj" => 'Registro '.$idmov.' generado exitosamente!!', "query" => $q);
    break;
    case 'put': //actualizacion
    break;
    case 'delete': //eliminar
    break;
    default:
        $resp = array("code"=>400,"msj" => 'No se envió la operación a realizar correctamente');
    break;
}
//imprime la salida
$resp=json_encode($resp);
echo $resp;

?>