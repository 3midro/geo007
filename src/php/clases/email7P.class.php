<?php

class email7P {
    var $resp;

    function e7P($curp, $whats, $email, $id, $nombre, $precio) {
        $from= $email;
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";     
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";


    //$from = "usuario@sucorreo.com";
    $to = "mudateya@7p.geopanda.com.mx";
    $subject = $curp;
    //$message = file_get_contents('http://7p.geopanda.com.mx/pages/email.html');
    $message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">

<title>Email - 7P</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body style="margin: 0; padding: 0;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%"> 
        <tr>
            <td style="padding: 10px 0 30px 0;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc; border-collapse: collapse;">
                    <tr>
                        <td align="center" bgcolor="#FBFBFB" style="padding: 40px 0 30px 0; color: #153643; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;">
                            <img src="http://7p.geopanda.com.mx/img/paso-a-paso-arriendo-mi-auto.gif" alt="Creating Email Magic"  height="230" style="display: block;" />
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
                                        <b>¡Hay un prospecto de inquilino!</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                        Se ha registrado un prospecto de inquilino con la siguiente informaci&oacute;n.
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tr>
                                                <td width="260" valign="top">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td>
                                                                <img src="http://7p.geopanda.com.mx/img/left.gif" alt="" width="100%" height="140" style="display: block;" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding: 25px 0 0 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                                                <table>
                                                                    <tr>
                                                                        <td>CURP</td><td><b>'.$curp.'</b></td>      
                                                                    </tr>
                                                                    <tr>
                                                                        <td>EMAIL</td><td><b>'.$email.'</b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>WHATS</td><td><b>'.$whats.'</b></td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td style="font-size: 0; line-height: 0;" width="20">
                                                    &nbsp;
                                                </td>
                                                <td width="260" valign="top">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td>
                                                                <img src="http://7p.geopanda.com.mx/img/right.gif" alt="" width="100%" height="140" style="display: block;" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding: 25px 0 0 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                                                Se encuentra interesado en la vivienda <b>'.$id.'</b> identificada como <b>'.$nombre.'</b> con un precio de <b>'.$precio.'</b>.
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ee4c50" style="padding: 30px 30px 30px 30px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;" width="75%">
                                        &reg; Geopanda Studios, Aguascalientes 2019
                                    </td>
                                    <td align="right" width="25%">
                                        <table border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold;">
                                                    <a href="http://www.twitter.com/" style="color: #ffffff;">
                                                        <img src="http://7p.geopanda.com.mx/img/tw.gif" alt="Twitter" width="38" height="38" style="display: block;" border="0" />
                                                    </a>
                                                </td>
                                                <td style="font-size: 0; line-height: 0;" width="20">&nbsp;</td>
                                                <td style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold;">
                                                    <a href="http://www.twitter.com/" style="color: #ffffff;">
                                                        <img src="http://7p.geopanda.com.mx/img/fb.gif" alt="Facebook" width="38" height="38" style="display: block;" border="0" />
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>';

    //$headers = "From:" . $from;
    mail($to,$subject,$message, $headers);
        $to = "mudateya@7p.geopanda.com.mx";
        $subject = $curp;
        


         $this->resp = array(
                    "code"=>200,
                    "msj" => 'Email enviado a 7P'
                );
         return $this->resp;
    }

//email al usuario
function emailRegistro($curp, $whats, $email,$id, $nombre, $precio) {
        
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";     
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";


    $from = "mudateya@7p.geopanda.com.mx";
    $to = $email;
    $subject = "7P ha registrado tu informacion ";
    $message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Email - Registro</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body style="margin: 0; padding: 0;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%"> 
        <tr>
            <td style="padding: 10px 0 30px 0;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc; border-collapse: collapse;">
                    <tr>
                        <td align="center" bgcolor="#FBFBFB" style="padding: 40px 0 30px 0; color: #153643; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;">
                            <img src="http://7p.geopanda.com.mx/img/mudanza.gif" alt="Solicitud Recibida!!"  height="450" style="display: block;" />
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
                                        <b>¡Ve empacando tus cosas!</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                        Hemos registrado tus datos exitosamente, muy pronto nos pondremos en contacto contigo por medio de los siguientes datos de contacto.
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tr>
                                                <td width="260" valign="top">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td>
                                                                <img src="http://7p.geopanda.com.mx/img/web_hi_res_512_.png" alt="" width="60%" height="30%"  style="display: block;" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding: 25px 0 0 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                                                <table>
                                                                    <tr>
                                                                        <td>CURP</td><td><b>'.$curp.'</b></td>       
                                                                    </tr>
                                                                    <tr>
                                                                        <td>EMAIL</td><td><b>'.$email.'</b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>WHATS</td><td><b>'.$whats.'</b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>VIVIENDA</td><td><b>'.$nombre.'</b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>PRECIO</td><td><b>'.$precio.'</b></td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td style="font-size: 0; line-height: 0;" width="20">
                                                    &nbsp;
                                                </td>
                                                <td width="260" valign="top">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td>
                                                                <img src="http://7p.geopanda.com.mx/img/web_hi_res_512.png" alt="" width="150px"  style="display: block;" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding: 25px 0 0 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px; text-align: justify;">
                                                                Septimo Piso te da la m&aacute;s cordial de las bienvenidas, comienza a disfrutar tú estancia en '.$nombre.' sin deposito en garantia, sin aval y sin plazos forzosos</b>.
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#1b1b1b" style="padding: 30px 30px 30px 30px;color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;">
                            <p style="font-family: Arial, sans-serif; font-size: 24px;">
                                        Prepara la siguiente documentaci&oacute;n
                            </p>
                            <p>
                                <ul>
                                    <li>INE</li>
                                    <li>COMPROBANTE DE INGRESOS</li>
                                </ul>
                            </p>
                    </tr>
                    <!--<tr>
                        <td bgcolor="#4F4F4F" style="padding: 30px 30px 30px 30px;color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;">
                            <p style="font-family: Arial, sans-serif; font-size: 24px;">
                                        Ocuparas la siguiente documentaci&oacute;n
                            </p>
                            <p>
                                <ul>
                                    <li>INE</li>
                                    <li>COMPROBANTE DE INGRESOS</li>
                                </ul>
                            </p>
                    </tr>-->
                    <tr>
                        <td bgcolor="#6d6d6d" style="padding: 10px 30px 10px 30px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td style="color: #1b1b1b; font-family: Arial, sans-serif; font-size: 14px;" width="75%">
                                        &reg; Geopanda Studios, Aguascalientes 2019
                                    </td>
                                    <td align="right" width="25%">
                                        <table border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <!--<td style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold;">
                                                    <a href="http://www.twitter.com/" style="color: #ffffff;">
                                                        <img src="http://7p.geopanda.com.mx/img/fb_b.jpg" alt="Twitter" width="38" height="38" style="display: block;" border="0" />
                                                    </a>
                                                </td>-->
                                                <td style="font-size: 0; line-height: 0;" width="20">&nbsp;</td>
                                                <td style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold;">
                                                    <a href="http://www.twitter.com/" style="color: #ffffff;">
                                                        <img src="http://7p.geopanda.com.mx/img/logo4.png" alt="Facebook" width="38" height="38" style="display: block;" border="0" />
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>';

    
 
    mail($to,$subject,$message, $headers);
       
        $subject = $curp;
        


         $this->resp = array(
                    "code"=>200,
                    "msj" => 'Email enviado al Usuario'
                );
         return $this->resp;
    }
    
}

// FIN DE LA CLASE email7P
?>