<?php

class validaciones {

    function validaCURP($valor) {

         if(strlen($valor)==18){ 
            $letras     = substr($valor, 0, 4);
            $numeros    = substr($valor, 4, 6);         
            $sexo       = substr($valor, 10, 1);
            $mxState    = substr($valor, 11, 2); 
            $letras2    = substr($valor, 13, 3); 
            $homoclave  = substr($valor, 16, 2);
            $mxStates = [         
            'AS','BS','CL','CS','DF','GT',         
            'HG','MC','MS','NL','PL','QR',         
            'SL','TC','TL','YN','NE','BC',         
            'CC','CM','CH','DG','GR','JC',         
            'MN','NT','OC','QT','SP','SR',         
            'TS','VZ','ZS'];     
            //valida que el estado corresponda
            if(!in_array(strtoupper($mxState),$mxStates)){
                return false;
            }
            //valida el sexo  
            $sexoCurp = ['H','M'];     
            if(!in_array(strtoupper($sexo),$sexoCurp)){
                return false;
            }
            if(ctype_alpha($letras) && ctype_alpha($letras2) && ctype_digit($numeros) ){ 
                return true; 
            }         
            //return false;
         }else{
             return false; 
        } 
    }

    function validaFecha($fecha){
        $partes = explode('-', $fecha);
        $dia = $partes[2];
        $mes = $partes[1];
        $anio = $partes[0];
        if (checkdate($mes, $dia, $anio)){
            return true;
        }
        return false;
    }

    function validaWHATS($whats){
       if (ctype_digit($whats) && strlen($whats)==10){
            return true;
        }
        return false;
    }

    function validaEMAIL($email){
        return (false !== filter_var($email, FILTER_VALIDATE_EMAIL));
    }

    
}

// FIN DE LA CLASE Validaciones
?>