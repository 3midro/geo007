<?php
header('Access-Control-Allow-Origin: *', true);
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Pragma: no-cache');
function __autoload($classname) {
    $filename = "clases/" . $classname . ".class.php";
    include_once($filename);
}

///obtiene la operacion a realizar en base a ello solicita los parametros requeridos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Logica para solicitudes POST
    $operacion = $_POST["operacion"];
    $combo = $_POST["combo"];
} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Logica para solicitudes GET
    $operacion = $_GET["operacion"];
    $combo = $_GET["combo"];
}


switch($combo){
    case 'addcontrato.f7.html_comboCurp': //addcontrato.f7.html_comboCurp //lista las curps y las agrupa de acuerdo a su situacion con respecto a 7P

        $conmay = new maysql();
        $conmay->conecta_7p();
        
        $q= "SELECT curp, nombre, 
        CASE  WHEN curp in (SELECT inquilino from leases where enddate is null) THEN 'vigente' 
        WHEN curp in (SELECT inquilino from leases where enddate is not null) THEN 'antiguo'
        WHEN curp in (SELECT curp from black_list) THEN 'blacklist'
        WHEN curp in (SELECT curp_owner from inmuebles) THEN 'propietarios' 
        ELSE 'nuevo' END grupo  
        from personas";
       
        $r = $conmay->consulta($q);

        $n = $conmay->filas($r);
        if ($n >= 1) {
             $e = array();
            while ($fila = $conmay->vector($r)) {
                 $feature = array(
                    "curp" => utf8_encode($fila["curp"]),
                    "nombre"=>utf8_encode($fila["nombre"]),
                    "grupo"=>utf8_encode($fila["grupo"]));
                 array_push($e,$feature);
            }
        }
        $resp = array(
                "code"=>200,
                "elementos" =>$e,
                "query"=> $q
            );
       
        $conmay->cierra_conexion(); 
        
        break;
    case 'addcontrato.f7.html_comboUnidades': //addcontrato.f7.html_comboUnidades //lista de unidades para el contrato
       
        $conmay = new maysql();
        $conmay->conecta_7p();
        
        $q= "SELECT u.idinmueble, i.alias inmueble, u.idunidad,u.alias, u.marketRent, u.prontopago, i.curp_owner, 
        CASE  WHEN u.idunidad in (SELECT idunidad from leases where enddate is null) THEN 'ocupado' 
        WHEN (u.activo <> 1) THEN 'inactivo' 
        ELSE 'disponible' END grupo  
        from unidades u
        LEFT join inmuebles i ON i.idinmueble = u.idinmueble";
       
        $r = $conmay->consulta($q);

        $n = $conmay->filas($r);
        if ($n >= 1) {
             $e = array();
            while ($fila = $conmay->vector($r)) {
                 $feature = array(
                    "idinmueble" => $fila["idinmueble"],
                    "inmueble"=>utf8_encode($fila["inmueble"]),
                    "idunidad" => $fila["idunidad"],
                    "alias"=>utf8_encode($fila["alias"]),
                    "curp_owner"=>utf8_encode($fila["curp_owner"]),
                    "marketRent" => $fila["marketRent"],
                    "prontopago" => $fila["prontopago"],
                    "grupo"=>utf8_encode($fila["grupo"]));
                 array_push($e,$feature);
            }
        }
        $resp = array(
            "code"=>200,
            "elementos" =>$e,
            "query"=> $q
        );
       
        $conmay->cierra_conexion(); 
    break;
    case 'addpago.f7.html_comboCurp':
        $conmay = new maysql();
        $conmay->conecta_7p();
        
        $q= "SELECT * FROM (
            (SELECT sum(i.saldo) saldo, CONCAT('$',sum(i.saldo),' MXN - ', p.nombre) texto, i.curp, p.nombre, 'inquilinos' as grupo 
       FROM invoice i
       LEFT join personas p on i.curp = p.curp 
       WHERE i.saldo > 0 and (idlease is not NULL or idlease != '') and (idinmueble is NOT NULL or idinmueble !='') AND (i.curp is NOT NULL OR i.curp != '') 
       GROUP by i.curp
       )
            UNION
            (SELECT sum(i.saldo) saldo, CONCAT('$',sum(i.saldo),' MXN - ', p.nombre) texto, i.curp curp, p.nombre, 'propietarios' as grupo 
       FROM invoice i
       LEFT join personas p on i.curp = p.curp
        WHERE saldo > 0 and idlease IS NULL AND (i.curp is not null or i.curp != '') and (idinmueble is not null or idinmueble != '')
       GROUP by i.curp
       )
    
        
           UNION
             (SELECT sum(saldo) saldo, CONCAT('$',sum(saldo),' MXN - ', 'CARTERA VENCIDA - INCOBRABLE') texto, 'NA' curp, 'NA' nombre, 'incobrable' as grupo 
       FROM `invoice`  WHERE saldo > 0 and (curp is null or curp ='') and (idlease is null or idlease ='') AND (idinmueble is null or idinmueble ='') 
       )
       
       ) 
        collection ORDER BY saldo DESC";
       
        $r = $conmay->consulta($q);

        $n = $conmay->filas($r);
        if ($n >= 1) {
             $e = array();
            while ($fila = $conmay->vector($r)) {
                 $feature = array(
                    "saldo" => utf8_encode($fila["saldo"]),
                    "texto"=>utf8_encode($fila["texto"]),
                    "curp"=>utf8_encode($fila["curp"]),
                    "nombre"=>utf8_encode($fila["nombre"]),
                    "grupo"=>utf8_encode($fila["grupo"]));
                 array_push($e,$feature);
            }
        }
        $resp = array(
                "code"=>200,
                "elementos" =>$e,
                "query"=> $q
            );
       
        $conmay->cierra_conexion(); 


    break;

    case 'addpago.f7.html_comboInvoicesXcurp':
        $curp = $_GET["curp"];
        $conmay = new maysql();
        $conmay->conecta_7p();
        
        $q= "SELECT * FROM invoice  
        LEFT join cat_tipo_invoice on invoice.idtipoinvoice = cat_tipo_invoice.idtipoinvoice 
        WHERE saldo > 0 and curp = '".$curp."' ORDER by idinvoice DESC";
       
        $r = $conmay->consulta($q);

        $n = $conmay->filas($r);
        if ($n >= 1) {
             $e = array();
            while ($fila = $conmay->vector($r)) {
                 $feature = array(
                    "idinvoice" => $fila["idinvoice"],
                    "idlease" => $fila["idlease"],
                    "idinmueble" => $fila["idinvoice"],
                    "curp"=>utf8_encode($fila["curp"]),
                    "invoiceduedate"=>utf8_encode($fila["invoiceduedate"]),
                    "amount" => $fila["amount"],
                    "saldo" => $fila["saldo"],
                    "concepto"=>utf8_encode($fila["concept"]),
                    "grupo" => $fila["idtipoinvoice"],
                    "descripcion"=>utf8_encode($fila["descripcion"]));
                 array_push($e,$feature);
            }
        }
        $resp = array(
            "code"=>200,
            "elementos" =>$e,
            "query"=> $q
        );
       
        $conmay->cierra_conexion(); 
    break;

    case 'addcargo.f7.html_comboCurp':
        $conmay = new maysql();
        $conmay->conecta_7p();
        
        $q= "SELECT * FROM ( 
            (SELECT curp, nombre, 'propietarios' grupo FROM personas WHERE curp IN ( SELECT distinct(curp_owner) FROM leases where enddate is null and curp_owner is not null ))
             UNION 
             (SELECT curp, nombre, 'inquilinos' grupo FROM personas WHERE curp IN ( SELECT distinct(inquilino) FROM leases where enddate is null and inquilino is not null ))
         ) collection ORDER BY grupo DESC";
       
        $r = $conmay->consulta($q);

        $n = $conmay->filas($r);
        if ($n >= 1) {
             $e = array();
            while ($fila = $conmay->vector($r)) {
                 $feature = array(
                    "nombre"=>utf8_encode($fila["nombre"]),
                    "curp"=>utf8_encode($fila["curp"]),
                    "grupo" =>utf8_encode($fila["grupo"])
                    );
                 array_push($e,$feature);
            }
        }
        $resp = array(
            "code"=>200,
            "elementos" =>$e,
            "query"=> $q
        );
       
        $conmay->cierra_conexion(); 
        break;

        case 'addpago.f7.html_comboTipoInvoice':
            $conmay = new maysql();
            $conmay->conecta_7p();
            
            $q= "SELECT  idtipoinvoice, descripcion FROM cat_tipo_invoice WHERE activo = 1;";
           
            $r = $conmay->consulta($q);
    
            $n = $conmay->filas($r);
            if ($n >= 1) {
                 $e = array();
                while ($fila = $conmay->vector($r)) {
                     $feature = array(
                        "idtipoinvoice"=>$fila["idtipoinvoice"],
                        "descripcion"=>utf8_encode($fila["descripcion"])
                        );
                     array_push($e,$feature);
                }
            }
            $resp = array(
                "code"=>200,
                "elementos" =>$e,
                "query"=> $q
            );
            $conmay->cierra_conexion(); 
            break;
            case "addAccountingMovement.f7.html_comboCategorias":
                $tipo_movimiento = $_GET["tipo_movimiento"];
                $conmay = new maysql();
                $conmay->conecta_7p();
                
                $q= "SELECT * FROM cat_cuentas_categorias where tipo = '".$tipo_movimiento."' and activo = 1;";  
               
                $r = $conmay->consulta($q);
        
                $n = $conmay->filas($r);
                if ($n >= 1) {
                     $e = array();
                    while ($fila = $conmay->vector($r)) {
                         $feature = array(
                            "idcategoria"=>$fila["idcategoria"],
                            "categoria"=>utf8_encode($fila["categoria"]),
                            "icon"=>$fila["icon"],
                            );
                         array_push($e,$feature);
                    }
                }
                $resp = array(
                    "code"=>200,
                    "elementos" =>$e,
                    "query"=> $q
                );
                $conmay->cierra_conexion(); 
                break;
                case "addAccountingMovement.f7.html_comboCuentas":
                    $conmay = new maysql();
                $conmay->conecta_7p();
                
                $q= "SELECT cc.cat_cuenta, cc.alias, cc.banco, T1.folio, T2.fecha, T2.idcategoria, T2.tipomovimiento, T2.cantidad, T2.saldo_previo, T2.nuevo_saldo, T2.comentarios from cat_cuentas cc LEFT JOIN (SELECT cuenta, max(movimiento) as folio FROM cat_cuentas_movimientos GROUP by cuenta ) as T1 ON cc.cat_cuenta = T1.cuenta LEFT join cat_cuentas_movimientos AS T2 ON T1.folio = T2.movimiento;";  
               
                $r = $conmay->consulta($q);
        
                $n = $conmay->filas($r);
                if ($n >= 1) {
                     $e = array();
                    while ($fila = $conmay->vector($r)) {
                         $feature = array(
                            "cuenta"=>$fila["cat_cuenta"],
                            "alias"=>utf8_encode($fila["alias"]),
                            "banco"=>utf8_encode($fila["banco"]),
                            "last_movement"=>$fila["folio"],
                            "saldo"=>$fila["nuevo_saldo"]
                            );
                         array_push($e,$feature);
                    }
                }
                $resp = array(
                    "code"=>200,
                    "elementos" =>$e,
                    "query"=> $q
                );
                $conmay->cierra_conexion(); 
                    break;
   
    default:
        $resp = array("code"=>400,"msj" => 'No se envió  el combo a construir correctamente');
    break;
}
$resp=json_encode($resp);
echo $resp;


?>