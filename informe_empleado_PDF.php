<?php
include('config.php');
require_once('tcpdf/tcpdf.php');

class MYPDF extends TCPDF {
    
  public function Header(){
        $bMargin = $this->getBreakMargin();
        $auto_page_break = $this->AutoPageBreak;
        $this->SetAutoPageBreak(false, 0);
        //$img_file = 'assets/imagenes/1.png';
        $img_file = dirname( __FILE__ ) .'/assets/imagenes/banner.png';
        $this->Image($img_file, 5, 8, 200, 25, '', '', '', false, 300, '', false, false, 0);
        $this->SetAutoPageBreak($auto_page_break, $bMargin);
        $this->setPageMark();
    }

     public function Footer() { 

     // $this->SetY(-10);
      //$this->Image('assets/imagenes/footer.PNG' , 5 ,52, 200 , 15,'PNG', '');
      /*$this->SetFont('helvetica','I',8);
      $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C'); */
    } 

}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, 'mm', 'Letter', true, 'UTF-8', false);
 
//establecer margenes
$pdf->SetMargins(25, 35, 25);
$pdf->SetHeaderMargin(20);
$pdf->setPrintFooter(true);
$pdf->setPrintHeader(true); //activar el Header
$pdf->SetAutoPageBreak(false);  //IMPORTANTISIMO,permite bajar un elemento y eliminar el crear otra otra.
 
//informacion del pdf
$pdf->SetCreator('UrianViera');
$pdf->SetAuthor('UrianViera');


$pdf->AddPage();

$sqlCliente      = ("SELECT * FROM solicitudesclientes ORDER BY id DESC LIMIT 1");
$resultadoClient = mysqli_query($con, $sqlCliente);
$totalCliente    = mysqli_num_rows($resultadoClient);
$dataFilaCliente = mysqli_fetch_assoc($resultadoClient);

if($totalCliente >0){
$pdf->SetFont('helvetica','B',10); 
$pdf->SetFillColor(0, 0, 0, 100);
$pdf->SetTextColor(0, 0, 0, 100);
$pdf->SetXY(115, 25);
$pdf->Write(0, 'Santa Cruz, '. $dataFilaCliente['fechaSolicitud']);

$pdf->Image('assets/imagenes/cuerpoPageOne.PNG',10,40,190);

$pdf->SetFont('helvetica','B',11); 
$pdf->SetXY(15, 46);
$pdf->Cell(200,0, $dataFilaCliente['nombreArquitecto'],0,0,'');

$pdf->SetXY(63, 59);
$pdf->Cell(200,0, $dataFilaCliente['numberCotizacion'],0,0,'');


$pdf->SetXY(5, 280);
$pdf->Image('assets/imagenes/footer.PNG', '', '', 200, 15, '', '', 'T', false, 300, '', false, false, 1, false, false, false); 

$pdf->SetFont('helvetica','B',9); 
$pdf->SetXY(20, 106);
$pdf->Cell(200,0, $dataFilaCliente['hormigon'],0,0,'');

$pdf->SetXY(47, 106);
$pdf->Cell(200,0, $dataFilaCliente['residencia'],0,0,'');

$pdf->SetXY(70, 106);
$pdf->Cell(200,0, $dataFilaCliente['axido_max'],0,0,'');

$pdf->SetXY(92, 106);
$pdf->Cell(200,0, $dataFilaCliente['asent_cm'],0,0,'');

$pdf->SetXY(112, 106);
$pdf->Cell(200,0, $dataFilaCliente['cant_aprox'],0,0,'');

$pdf->SetXY(132, 106);
$pdf->Cell(200,0, $dataFilaCliente['precio_uni'],0,0,'');

$pdf->SetXY(157, 106);
$pdf->Cell(200,0, $dataFilaCliente['totalPrecio'],0,0,'');


//Segunda Pagina
$pdf->AddPage();

$pdf->Image('assets/imagenes/cuerpoPageTwo.PNG',10,40,190);
$pdf->SetFont('helvetica','B',10); 
$pdf->SetXY(115, 25);
$pdf->Write(0, 'Santa Cruz, '. $dataFilaCliente['fechaSolicitud']);


$pdf->SetFont('Helvetica', 'B', 11, '', 'false');
$pdf->SetFillColor(0, 0, 0, 100);
$pdf->SetTextColor(0, 0, 0, 100);

$pdf->SetXY(5, 174);
$pdf->Cell(200,0, $dataFilaCliente['nombreArquitecto'],0,0,'C');

$pdf->SetXY(5, 175);
$pdf->Cell(200,0, '_______________________________ ',0,0,'C');
$pdf->SetXY(5, 180);
$pdf->Cell(200,0, 'Representante Comercial ',0,0,'C');

$pdf->SetXY(5, 185);
$pdf->Cell(200,0, 'Tlf. ' . $dataFilaCliente['telfArquitecto'],0,0,'C');

$pdf->SetXY(5, 190);
$pdf->Cell(200,0, 'HORMIBOLIVIA SRL. ',0,0,'C');


//Informacion del cliente
$pdf->SetXY(5, 230);
$pdf->Cell(200,0, '---------------------------------------------------- ',0,0,'C');

$pdf->SetXY(5, 235);
$pdf->Cell(200,0, 'Firma de Conformidad del Cliente ',0,0,'C');

$pdf->SetXY(5, 240);
$pdf->Cell(200,0, 'Nombre: '. $dataFilaCliente['nombreCliente'],0,0,'C');

$pdf->SetXY(5, 245);
$pdf->Cell(200,0, 'Tlf. ' . $dataFilaCliente['tlfCliente'],0,0,'C');
$pdf->SetFont('Helvetica', 'B', 10, '', 'false');
$pdf->SetXY(5, 250);
$pdf->Cell(200,0, 'Fecha: ' . $dataFilaCliente['fechaNormal'],0,0,'C');
//Fin Inf. del cliente

//Codigo QR
//$pdf->Image('QR/temp/'.$dataFilaCliente['codigoSolicitu'].'.PNG',10,40,10, 'C');


$pdf->SetXY(155, 230);
$pdf->Image('QR/temp/'.$dataFilaCliente['codigoSolicitu'].'.PNG', '', '', 40, 40, '', '', 'T', false, 300, '', false, false, 0, false, false, false); 


$pdf->SetXY(5, 280);
$pdf->Image('assets/imagenes/footer.PNG', '', '', 200, 15, '', '', 'T', false, 300, '', false, false, 1, false, false, false); 

}


$pdf->Output('Cliente_'.$dataFilaCliente['cedulaCliente'].'.pdf', 'I');

?>
