<?php
    class favoritos{
        var $resp;
        
        function manageFav($iuser, $denue, $conmay){
            $q = "SELECT setFav('".$iuser."', ".$denue.") as r;";
            $r = $conmay->consulta($q);
            $n = $conmay->filas($r);
            if ($n >= 1) {
                while ($fila = $conmay->vector($r)) {
                    $icn=($fila["r"] === '1')?'favorite':'favorite_border';
                }
                $this->resp = array(
                    "code"=>200,
                    "icono" => $icn
                );
            }else{
                $this->resp = array(
                    "code"=>204,
                    "msj" => "Petición incompleta"
                );
            }
            
            return $this->resp;
        }
    }
?>