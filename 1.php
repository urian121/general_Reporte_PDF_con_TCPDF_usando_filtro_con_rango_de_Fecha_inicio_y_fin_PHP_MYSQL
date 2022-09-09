<?php
require_once('tcpdf/tcpdf.php');

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

	public function Header() {
        $this->Image('assets/img/logo1.jpg', 5, 5, 30);
       /* $this->Cell(30);
        $this->Cell(120,10, 'Reporte De Estados',0,0,'C');
        $this->Ln(20);*/
	}

	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
		$this->setY(-15);
		// Set font
		$this->setFont('helvetica', 'I', 8);
		// Page number
		$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	}
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

//establecer margenes
$pdf->SetMargins(25, 35, 25);
$pdf->SetHeaderMargin(20);
$pdf->setPrintFooter(false);
$pdf->setPrintHeader(true); //para eliminar la linea superio del pdf por defecto y tambien ej hearder
$pdf->SetAutoPageBreak(false);  //IMPORTANTISIMO,permite bajar un elemento y eliminar el crear otra otra.

// set default header data
$pdf->setHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);


// add a page
$pdf->AddPage();


$pdf->Output('example_003.pdf', 'I');

