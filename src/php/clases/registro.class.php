<?php

class registro {
    var $resp;
   
    function registraPersonaBlackList($curp, $motivo, $externo, $conmay){
        $q = 'CALL SP_7P_ERP_addPersonaBlackList("'.$curp.'", "'.$motivo.'", '.$externo.');';
        $r = $conmay->consulta($q);
        $this->resp = true;
        return $this->resp;
    }

    function registraLease($curp, $curp_owner, $idinmueble, $idunidad, $inmuebletxt, $unidadtxt, $precioregular, $prontopago, $startdate, $deposito, $depositconcept, $descuento, $discountdate, $discountconcept, $conmay) { 
        $q= 'CALL SP_7P_ERP_addLEASE("'.$curp.'", "'.$curp_owner.'",'.$idinmueble.', '.$idunidad.', "'.$inmuebletxt.'","'.$unidadtxt.'",'.$precioregular.','.$prontopago.',"'.$startdate.'",'.$deposito.',"'.$depositconcept.'",'.$descuento.',"'.$discountdate.'","'.$discountconcept.'" );';
        $r = $conmay->consulta($q);
        $this->resp = true;
        return $this->resp;
    }




    function registraPago($nombre, $grupo, $inquilino,  $monto, $comentario, $fechaInicial, $conmay) { 
        $q= 'CALL addPAYMENT("'.$inquilino.'", '.$monto.', "'.$comentario.'", "'.$fechaInicial.'" );';
        $r = $conmay->consulta($q);
        if (!$r) {
            $this->resp = "Falló CALL: (" . $conmay->errno . ") " . $conmay->error;
        }else{
            $fila = $conmay->vector($r);
            if ($fila["Vresp"]!=false){
                $filled_folio = sprintf("%05d", $fila["Vresp"]);
                require('fpdf/fpdf.php');
                $pdf=new FPDF();
                $pdf->AddPage();
                $pdf->SetFont('Arial','',8);
                // FECHA Y FOLIO
                $pdf->Cell(135,5,'FECHA','LTR',0,'L');
                $pdf->Cell(60,5,'FOLIO','LTR',1,'L');
                $pdf->SetTextColor(84,84,84);
                $pdf->SetFont('Arial','B',22);
                $pdf->Cell(135,10,date('d/m/Y',strtotime($fechaInicial)),'LBR',0,'C');
                $pdf->SetFont('Arial','B',35);
                $pdf->SetTextColor(248,0,64);
                $pdf->Cell(60,10, '7P'.$filled_folio,'LBR',1,'R');
                $pdf->SetTextColor(0,0,0);
                $pdf->SetFont('Arial','',8);
                $formatterES = new NumberFormatter("es", NumberFormatter::SPELLOUT);
                $pdf->Cell(135,5,'RECIBIMOS DE','LTR',0,'L');
                $pdf->Cell(60,5,'CURP','LTR',1,'L');
                $pdf->SetFont('Arial','B',14);
                $pdf->SetTextColor(84,84,84);
                $pdf->Cell(135,10,$nombre,'LBR',0,'C');
                $pdf->Cell(60,10,$inquilino,'LBR',1,'C');
                // que habita
                $pdf->SetTextColor(0,0,0);
                $pdf->SetFont('Arial','',8);
                $pdf->Cell(195,5,'QUE HABITA EN LA VIVIENDA','LTR',1,'L');               
                $pdf->SetFont('Arial','B',14);
                $pdf->SetTextColor(84,84,84);
                $pdf->Cell(195,10,strtoupper($grupo),'LBR',1,'C');
               

                // cantidad
                $pdf->SetTextColor(0,0,0);
                $pdf->SetFont('Arial','',8);
                $pdf->Cell(135,5,'LA CANTIDAD DE','LTR',0,'L');
                $pdf->Cell(60,5,'MXN','LTR',1,'L');
                $pdf->SetFont('Arial','B',14);
                $pdf->SetTextColor(84,84,84);
                $pdf->Cell(135,10,strtoupper($formatterES->format($monto)).' PESOS MXN','LBR',0,'C');
                $pdf->Cell(60,10,'$ '.$monto .' MXN','LBR',1,'C');

              // x concepto de
              $pdf->SetTextColor(0,0,0);
              $pdf->SetFont('Arial','',8);
              $pdf->Cell(195,5,'POR CONCEPTO DE','LTR',1,'L');               
              $pdf->SetFont('Arial','B',12);
              $pdf->SetTextColor(84,84,84);
              $pdf->MultiCell(195,5,strtoupper($comentario),'LBR','J',false);
               //fecha generacion
               $pdf->SetTextColor(0,0,0);
               $pdf->SetFont('Arial','',7);
              $pdf->Cell(195,5,'GENERATED AT '.strtoupper(date('l jS \of F Y h:i:s A')),1,1,'C');               
              
                //$pdf->Cell(40,10,'¡Mi primera página pdf con FPDF!');
                $pdf->Output('clases/fpdf/recibos/7P'.$filled_folio.'.pdf','F', true);
               
                $this->resp = true;
            }else{
                $this->resp = false;
            }
        }
        return $this->resp;
    }    

   

    


    function registraPersona($curp, $whats, $numfav, $email, $conmay) {     
         $q = 'CALL addPersonaT("'.$curp.'", "'.$whats.'", '.$numfav.', "'.$email.'" );';
         $r = $conmay->consulta($q);
         //$n = $conmay->filas($r);
         /*if ($n >= 1) {
            // si lo registro
           // $this->resp = array("code"=>200,"msj" => 'Registro de '.$curp.' exitoso');
             $this->resp = true;
         }else{
            // no lo registro y no debe enviar email
            //$this->resp = array("code"=>201,"msj" => .$curp.' existente');
            $this->resp = false;
         }*/
         $this->resp = true;
         return $this->resp;
    }

   
    function registraPersonaErp($curp, $blacklits, $renapo, $ine,  $nombre, $birthday, $entidad_nac, $genero, $celular, $email, $conmay) {     
        $q = 'CALL addPersonaERP("'.$curp.'", '.$blacklits.','.$renapo.','.$ine.', "'.$nombre.'", "'.$birthday.'", "'.$entidad_nac.'","'.$genero.'","'.$celular.'","'.$email.'");';
        $r = $conmay->consulta($q);
        $this->resp = true;
        return $this->resp;
   }
    
}

// FIN DE LA CLASE registro
?>