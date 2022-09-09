<?php
require_once('tcpdf/tcpdf.php');
require_once('config.php');
date_default_timezone_set('America/Bogota');


ob_end_clean(); //limpiar la memoria

class MYPDF extends TCPDF{
      
    	public function Header() {
            $bMargin = $this->getBreakMargin();
            $auto_page_break = $this->AutoPageBreak;
            $this->SetAutoPageBreak(false, 0);
            $img_file = dirname( __FILE__ ) .'/assets/img/logo.png';
            $this->Image($img_file, 85, 8, 20, 25, '', '', '', false, 30, '', false, false, 0);
            $this->SetAutoPageBreak($auto_page_break, $bMargin);
            $this->setPageMark();
	}


}

//iniciando un nuevo pdf
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, 'mm', 'Letter', true, 'UTF-8', false);
 
//establecer margenes
$pdf->SetMargins(25, 35, 25);
$pdf->SetHeaderMargin(20);
$pdf->setPrintFooter(false);
$pdf->setPrintHeader(true); //para eliminar la linea superio del pdf por defecto y tambien ej hearder
$pdf->SetAutoPageBreak(false);  //IMPORTANTISIMO,permite bajar un elemento y eliminar el crear otra otra.
 
//informacion del pdf
$pdf->SetCreator('UrianViera');
$pdf->SetAuthor('UrianViera');
$pdf->SetTitle('Factura de Pedido');


$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
 

//agregar la primera pagina
$pdf->AddPage();
//tipo de fuente y tamaño de letra
$pdf->SetFont('helvetica','B',10); 
$pdf->SetXY(150, 20);
$pdf->Write(0, 'Código: 0014ABC');
$pdf->SetXY(150, 25);
$pdf->Write(0, 'Fecha: '. date('d-m-Y'));
$pdf->SetXY(150, 30);
$pdf->Write(0, 'Hora: '. date('h:i A'));


$pdf->SetFont('helvetica','B',10); 
$pdf->SetXY(15, 20);
$pdf->Write(0, 'Cliente Grommer');
$pdf->SetXY(15, 25);
$pdf->Write(0, 'Nombre: 654654');
$pdf->SetXY(15, 30);
$pdf->Write(0, 'Email: 54654645');



$pdf->Ln(20);
$pdf->Cell(40,26,'',0,0,'C');
//$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('helvetica','B',12); 
$pdf->Cell(100,6,'RESUMEN DEL PEDIDO',0,0,'C');


$pdf->Ln(10); //Salto de Linea

/*
$logo = 'http://groomersacademy.com.co/images/logoCorreo.jpg';
$pdf->Image($logo, 95, 5, 25, '', '', '', '', false, 300, '', false, false, 0, false, false, false);
*/


$pdf->SetFillColor(232,232,232);
$pdf->SetFont('helvetica','B',12); //LA b ES PARA NEGRITA
$pdf->Cell(40,6,'Nombre',1,0,'C',1);
$pdf->Cell(60,6,'Email',1,0,'C',1);
$pdf->Cell(35,6,'Sueldo',1,0,'C',1);
$pdf->Cell(35,6,'Fecha Ingreso',1,1,'C',1); 
/*El 1 despues de  Fecha Ingreso indica que hasta alli 
llega la linea */

$pdf->SetFont('helvetica','',10);


//SQL
$sqlTrabajadores = ('SELECT * FROM trabajadores ORDER BY fecha_ingreso ASC');
$query = mysqli_query($con, $sqlTrabajadores);
$i =1;
while ($dataRow = mysqli_fetch_array($query)) {
        $pdf->Cell(40,6,($dataRow['nombre']),1,0,'C');
        $pdf->Cell(60,6,$dataRow['email'],1,0,'C');
        $pdf->Cell(35,6,('$ '. $dataRow['sueldo']),1,0,'C');
        $pdf->Cell(35,6,(date('m-d-Y', strtotime($dataRow['fecha_ingreso']))),1,1,'C');
    }


$pdf->Output('Resumen_Pedido_'.date('d_m_y').'.pdf', 'I'); 
//la D es para forzar la descargarnd del pdf y La I funciona como un target
