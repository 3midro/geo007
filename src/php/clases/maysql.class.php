<?php

class Maysql {

    var $conexion;
    var $error_conexion = "Ups!! ocuri&oacute; un error";

    //inicia conexion con el servidor

     function conecta_7P() {
        if (!isset($this->conexion)) {
            //$ser = "localhost";  $usr = "root";  $pwd = ""; $bbd = "dbvinom"; // localhost
            $ser = "localhost";  $usr = "geopanda_lectura";  $pwd = "bBPFl@sHK^Xu"; $bbd = "geopanda_7p"; // produccion
            $this->conexion = (mysqli_connect($ser, $usr, $pwd, $bbd)) or die(mysqli_connect_errno()); // original, muestra error
        }
    }

//realiza la consulta recepcionada
    function consulta($consulta) {
        //$consulta=stripslashes($consulta);
       // $consulta=mysql_real_escape_string($consulta);
        $resultado = mysqli_query($this->conexion, $consulta);
        if (!$resultado) {
            echo 'MySql Error: ' . mysql_error() . " $consulta"; //original
            //echo $this->error_conexion;
            exit;
        }
        return $resultado;
    }

    function cierra_conexion() {
        // echo 'MySql Close: ';
        mysqli_close($this->conexion);
    }

    function f_afectadas() {
        return mysqli_affected_rows($this->conexion);
    }

    function idinsertado() {
        return mysqli_insert_id($this->conexion);
    }

    //devuelve un vector de la consulta
    function vector($consulta) {
        return mysqli_fetch_array($consulta);
    }

    //retorna el numero de registros para la consulta
    function filas($consulta) {
        return mysqli_num_rows($consulta);
    }

    //metodos adicionales

    function imprime($resp) {
        $resp = json_encode($resp);
        echo $resp;
        $this->cierra_conexion();
        exit();
    }




}

// FIN DE LA CLASE MAYSQL
?>