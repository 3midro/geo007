<?php
    class busqueda{
        var $resp;


        function buscaEnListaNegra($curp, $conmay){
            $q ='SELECT curp, motivo, externo FROM black_list WHERE curp = "'.$curp.'";';
            $r = $conmay->consulta($q);
            $n = $conmay->filas($r);
            if ($n >= 1) {
                 $e = array();
                while ($fila = $conmay->vector($r)) {
                     $feature = array(
                        "curp" => utf8_encode($fila["curp"]),
                        "motivo"=>utf8_encode($fila["motivo"]),
                        "externa"=>utf8_encode($fila["externa"]));
                     array_push($e,$feature);
                }
                $this->resp = array(
                    "code"=>200,
                    "elementos" =>$e
                );
            }else{
                $this->resp = array(
                    "code"=>201,
                    "mensaje" => "Este usuario no se encuentra en lista negra"
                );
            }
            
            return $this->resp;

        }
        
        function comboInmuebles($conmay){
            $q ='SELECT u.idinmueble, count(idunidad) habitaciones, CONCAT(i.alias," - [",count(idunidad) ," HAB DISP]") alias from unidades u INNER JOIN inmuebles i ON i.idinmueble = u.idinmueble where idunidad not in (SELECT idunidad from leases where enddate is null) and i.activo =1 AND u.activo=1 GROUP BY u.idinmueble';
            //$q = 'SELECT u.idinmueble, count(idunidad) habitaciones, i.alias from unidades u INNER JOIN inmuebles i ON i.idinmueble = u.idinmueble where idunidad not in (SELECT idinmueble from leases where enddate is not null) and i.activo =1 GROUP BY u.idinmueble';
            //$q = 'SELECT idinmueble, alias from inmuebles where activo = 1 order by 1';
            $r = $conmay->consulta($q);
            $n = $conmay->filas($r);
            if ($n >= 1) {
                 $e = array();
                while ($fila = $conmay->vector($r)) {
                     $feature = array(
                        "value" => $fila["idinmueble"],
                        "habitaciones"=>$fila["habitaciones"],
                        "texto"=>utf8_encode($fila["alias"]));
                     array_push($e,$feature);
                }
            }
            $this->resp = array(
                    "code"=>200,
                    "elementos" =>$e
                );
            return $this->resp;
        }
        
        
        function comboUnidades($conmay, $idinmueble){
            $q ='SELECT idunidad,marketrent,alias from unidades where idunidad not in (SELECT idunidad from leases where enddate is null) and activo = 1 and idinmueble = '.$idinmueble;
            $r = $conmay->consulta($q);
            $n = $conmay->filas($r);
            if ($n >= 1) {
                 $e = array();
                while ($fila = $conmay->vector($r)) {
                     $feature = array(
                         "idinmueble" => $idinmueble,
                         "query" => $q,
                        "value" => $fila["idunidad"],
                        "renta"=>$fila["marketrent"],
                        "texto"=>utf8_encode($fila["alias"]));
                     array_push($e,$feature);
                }
            }
            $this->resp = array(
                    "code"=>200,
                    "elementos" =>$e
                );
            return $this->resp;
        }

        function comboInquilinos ($conmay){
            $q = "SELECT curp, nombre, CASE  WHEN curp in (SELECT inquilino from leases where enddate is null) THEN 'activo'  WHEN curp in (SELECT inquilino from leases where enddate is not null) THEN 'finalizado' ELSE 'libre' END grupo  from personas WHERE curp not in (SELECT curp_owner from inmuebles) and renapo = 1";
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
            $this->resp = array(
                    "code"=>200,
                    "elementos" =>$e
                );
            return $this->resp;
        }

        function comboInquilinos_addPago ($conmay){
           $q="SELECT l.inquilino curp, p.nombre, im.alias grupo, l.amount, SUM(i.saldo) saldo, l.idinmueble, i.concept FROM invoice i INNER JOIN leases l ON l.idlease=i.idlease INNER JOIN personas p ON l.inquilino = p.curp INNER JOIN inmuebles im ON im.idinmueble = l.idinmueble INNER JOIN unidades u ON u.idunidad = l.idunidad WHERE i.saldo>0 GROUP by curp";
            // $q = "SELECT l.inquilino curp, concat('$', l.amount, '.00 MXN - ',p.nombre) nombre, im.alias grupo, l.amount, l.saldo, l.idinmueble FROM invoice i INNER JOIN leases l ON l.idlease=i.idlease INNER JOIN personas p ON l.inquilino = p.curp INNER JOIN inmuebles im ON im.idinmueble = l.idinmueble INNER JOIN unidades u ON u.idunidad = l.idunidad WHERE i.estatus = 'OPEN'";
            $r = $conmay->consulta($q);
            $n = $conmay->filas($r);
            if ($n >= 1) {
                 $e = array();
                while ($fila = $conmay->vector($r)) {
                     $feature = array(
                        "curp" => utf8_encode($fila["curp"]),
                        "nombre"=>utf8_encode($fila["nombre"]),
                        "grupo"=>utf8_encode($fila["grupo"]),
                        "concepto"=>utf8_encode($fila["concept"]),
                        "idinmueble"=>$fila["idinmueble"],
                        "monto"=>$fila["amount"],
                        "saldo"=>$fila["saldo"]
                    );
                     array_push($e,$feature);
                }
            }
            $this->resp = array(
                    "code"=>200,
                    "elementos" =>$e
                );
            return $this->resp;
        }
        
        
        
        function find($bbox, $conmay){
            $q = 'CALL getDenue('.$bbox["_southWest"]["lat"].', '.$bbox["_northEast"]["lat"].', '.$bbox["_southWest"]["lng"].', '.$bbox["_northEast"]["lng"].' );';
            $r = $conmay->consulta($q);
            $n = $conmay->filas($r);
            if ($n >= 1) {
                 $e = array();
                 while ($fila = $conmay->vector($r)) {
                     $feature = array(
                        "type" => "Feature",
						"geometry" => array(
							"type"=>"Point", 
							"coordinates"=> array(
								floatval($fila["longitud"]),
								floatval($fila["latitud"])
							)),
						"properties" => array(
							"id" => $fila["id"],
							"nombre" => utf8_encode($fila["nombre"]),
                            "SCIAN" => $fila["SCIAN"],
                            "activo" => $fila["activo"],
                            "isfav" => 0
						)
				);
                     array_push($e,$feature);
                }
                
                $features = array(
                    "type"=> "FeatureCollection",
                     "features"=> $e
                );
                $this->resp = array(
                    "code"=>200,
                    "geoUE" =>$features
                );
            }else{
                $this->resp = array(
                    "code"=>204,
                    "geoUE" => null
                );
            }
            
            return $this->resp;
        }

        function findInmuebles($bbox, $conmay){
            $q = 'CALL getInmueblesBBOX('.$bbox["_southWest"]["lat"].', '.$bbox["_northEast"]["lat"].', '.$bbox["_southWest"]["lng"].', '.$bbox["_northEast"]["lng"].' );';
            $r = $conmay->consulta($q);
            $n = $conmay->filas($r);
            if ($n >= 1) {
                 $e = array();
                 while ($fila = $conmay->vector($r)) {
                     $feature = array(
                        "type" => "Feature",
                        "geometry" => array(
                            "type"=>"Point", 
                            "coordinates"=> array(
                                floatval($fila["longitud"]),
                                floatval($fila["latitud"])
                            )),
                        "properties" => array(
                            "id" => $fila["idinmueble"],
                            "nombre" => utf8_encode($fila["alias"]),
                            "direccion" => utf8_encode($fila["address"]),
                            "banos" => $fila["banos"],
                            "recamaras" => $fila["recamaras"],
                            "rec_disponibles" => $fila["disponibles"],
                            "casa" => $fila["filtro"],
                            "anfitrion" => utf8_encode($fila["curp_owner"]),
                            "precio" => utf8_encode($fila["precio"]),
                            "video" =>utf8_encode($fila["video"]),
                            "activo" => $fila["activo"],
                            "pro" => $fila["pro"]
                        )
                );
                     array_push($e,$feature);
                }
                
                $features = array(
                    "type"=> "FeatureCollection",
                     "features"=> $e
                );
                $this->resp = array(
                    "code"=>200,
                    "geoUE" =>$features
                );
            }else{
                $this->resp = array(
                    "code"=>204,
                    "geoUE" => null
                );
            }
            
            return $this->resp;
        }
        
        function findFavs($bbox, $iuser, $conmay){
        $q = 'CALL getDenueFavs('.$bbox["_southWest"]["lat"].', '.$bbox["_northEast"]["lat"].', '.$bbox["_southWest"]["lng"].', '.$bbox["_northEast"]["lng"].',\''.$iuser.'\' );';
            $r = $conmay->consulta($q);
            $n = $conmay->filas($r);
            if ($n >= 1) {
                 $e = array();
                 while ($fila = $conmay->vector($r)) {
                     $feature = array(
                        "type" => "Feature",
						"geometry" => array(
							"type"=>"Point", 
							"coordinates"=> array(
								floatval($fila["longitud"]),
								floatval($fila["latitud"])
							)),
						"properties" => array(
							"id" => $fila["id"],
							"nombre" => utf8_encode($fila["nombre"]),
                            "SCIAN" => $fila["SCIAN"],
                            "activo" => $fila["activo"],
                            "isfav" => $fila["isfav"]
						)
				);
                     array_push($e,$feature);
                }
                
                $features = array(
                    "type"=> "FeatureCollection",
                     "features"=> $e
                );
                $this->resp = array(
                    "code"=>200,
                    "geoUE" =>$features
                );
            }else{
                $this->resp = array(
                    "code"=>204,
                    "geoUE" => null
                );
            }
            
            return $this->resp;
        }
    }
?>