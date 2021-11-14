<?php
ini_set( 'display_errors', 1 );
error_reporting( E_ALL );
header('Access-Control-Allow-Origin: *', true);
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Pragma: no-cache');

    $cveCurp = strtoupper($_GET["cveCurp"]);

    // Definimos la función cURL
    function curl($url) {
        $ch = curl_init($url); // Inicia sesión cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); // Configura cURL para devolver el resultado como cadena
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Configura cURL para que no verifique el peer del certificado dado que nuestra URL utiliza el protocolo HTTPS
        $info = curl_exec($ch); // Establece una sesión cURL y asigna la información a la variable $info
        curl_close($ch); // Cierra sesión cURL
       if ($info){
        return $info;
       }else{
        return false;
       } 
    }

    function rip_tags($string) {
   
        // ----- remove HTML TAGs -----
        $string = preg_replace ('/<[^>]*>/', '', $string);
       
        // ----- remove control characters -----
        $string = str_replace("\r", '', $string);    // --- replace with empty space
        $string = str_replace("\n", '', $string);   // --- replace with empty space
        $string = str_replace("\t", '', $string);   // --- replace with empty space
       
        // ----- remove multiple spaces -----
        $string = trim(preg_replace('/ {2,}/', '', $string));
       
        return $string;
    
    }
    
   
   
   
   
        $html = utf8_encode(curl('http://renapo.sep.gob.mx/wsrenapo/MainControllerParam?curp='.$cveCurp.'&Submit=Enviar'));
        //$html = curl('http://sipso.sedesol.gob.mx/consultarCurp/consultaCurpR.jsp?cveCurp='.$cveCurp); //Convierte la información de la URL en cadena
        
       if ($html == false){
        $resp = array("code"=>400,"msj" => 'No cargo en renapo');
       }else{
        //agrego comas para identificar los campos mas adelante
        $html = str_replace("</div>","|</div>",$html);
        $items= strip_tags($html,'<tr class="inf_columna_con_color"><td width="23%"><div align="left">');
        $items = rip_tags($items);
        // $items= strip_tags($html,'<div align="left">');
        //separar la cadena en piezas para acceder a la info que necesito
        $pieces = explode("|", $items);
        //tratamiento a la fecha para desplegarla como se requiere
        $birthday = explode("/", $pieces[19]);
        //acomodo la respuesta para enviarla a la interfaz y pegarla en el formulario
        
        $feature = array(
            "tosho_morosho"=>$pieces,
            "nombre"=>$pieces[29].' '.$pieces[3].' '.$pieces[5],
            "birthday" => $birthday[2].','.$birthday[1].','.$birthday[0],
            "birthday_original"=>$pieces[19],
            "genero" => $pieces[37],
            "entidad_nac" => $pieces[13]
        );



        $resp = array("code"=>200,"msj" => $feature);

       }
        $resp=json_encode($resp);
        echo $resp;
?>