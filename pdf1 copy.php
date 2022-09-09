<?php
require_once('tcpdf/tcpdf.php');
date_default_timezone_set('America/Bogota');

$usuario  = "root";
$password = "";
$servidor = "localhost";
$basededatos = "bd_groomers";
$con = mysqli_connect($servidor, $usuario, $password) or die("No se ha podido conectar al Servidor");
mysqli_query($con,"SET SESSION collation_connection ='utf8_unicode_ci'");
$db = mysqli_select_db($con, $basededatos) or die("Upps! Error en conectar a la Base de Datos");


$tokenCliente     = $_REQUEST['ts'];
$userId           = $_REQUEST['userId'];
$emailCli         = $_REQUEST['emailCli'];
$cliente          = $_REQUEST['cliente'];

$codPedido        = substr($tokenCliente, 0, 5);


ob_end_clean(); //limpiar la memoria

class MYPDF extends TCPDF{
      
    	public function Header() {
		// Logo
		$image_file ='assets/img/logo1.jpg';
		$this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		// Set font
		$this->setFont('helvetica', 'B', 20);
		// Title
		$this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
	}


}

//iniciando un nuevo pdf
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, 'mm', 'Letter', true, 'UTF-8', false);
 
//establecer margenes
$pdf->SetMargins(25, 35, 25);
$pdf->SetHeaderMargin(20);
$pdf->setPrintFooter(false);
$pdf->setPrintHeader(false); //para eliminar la linea superio del pdf por defecto y tambien ej hearder
$pdf->SetAutoPageBreak(false);  //IMPORTANTISIMO,permite bajar un elemento y eliminar el crear otra otra.
 
//informacion del pdf
$pdf->SetCreator('UrianViera');
$pdf->SetAuthor('UrianViera');
//$pdf->SetTitle('Factura de Pedido');


$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
 
//tipo de fuente y tamanio
$pdf->SetFont('helvetica', '', 12);

$sqlCli   = ("SELECT producto_id, fecha, hours FROM pedidostemporales WHERE tokenCliente='UpQR0UqcZeQgwarKhwxhw7jDxxR4QT'");
$queryCli = mysqli_query($con, $sqlCli);
$DataCli  = mysqli_fetch_array($queryCli);



//agregar pag 1
$pdf->AddPage();

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
$pdf->Write(0, 'Nombre: '. $cliente);
$pdf->SetXY(15, 30);
$pdf->Write(0, 'Email: '. $emailCli);



$pdf->Ln(20);
$pdf->Cell(40,26,'',0,0,'C');
//$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('helvetica','B',12); 
$pdf->Cell(100,6,'RESUMEN DEL PEDIDO',0,0,'C');


$pdf->Ln(10);


$logo = 'http://groomersacademy.com.co/images/logoCorreo.jpg';
$pdf->Image($logo, 95, 5, 25, '', '', '', '', false, 300, '', false, false, 0, false, false, false);



$pdf->SetFillColor(232,232,232);
$pdf->SetFont('helvetica','B',12); //LA b ES PARA NEGRITA
$pdf->Cell(30,6,'Cantidad',1,0,'C',1);
$pdf->Cell(100,6,'Producto',1,0,'C',1);
$pdf->Cell(40,6,'Puntos',1,1,'C',1);


$pdf->SetFont('helvetica','',10);

//SQL LISTA DEL PEDIDO
$sqlTotalSolicitud = ("SELECT 
    prod . * ,
    prod.id AS prodId,
    fot . *,
    pedtemp .* ,
    pedtemp.id AS tempId
FROM 
    products AS prod,
    fotoproducts AS fot,
    pedidostemporales AS pedtemp
WHERE 
    prod.id = fot.products_id 
    AND prod.id=pedtemp.producto_id
    AND pedtemp.tokenCliente='".$tokenCliente."'
");
$jqueryMisProducts   = mysqli_query($con, $sqlTotalSolicitud); 


/****Total a Pagar *****/
$SqlDeuda = 
("SELECT 
    p.id,
    p.puntos,
    p.nameProd,
    pt.producto_id,
    pt.tokenCliente,
    pt.cantidad,
SUM(p.puntos * pt.cantidad) AS totalPagar 
FROM 
    products as p,
    pedidostemporales AS pt
WHERE 
    p.id=pt.producto_id
    AND tokenCliente='".$tokenCliente."'
");
$jqueryDeuda    = mysqli_query($con, $SqlDeuda); 
$dataDeuda      = mysqli_fetch_array($jqueryDeuda);



while ($dataP = mysqli_fetch_array($jqueryMisProducts)) {
        $pdf->Cell(30,6,($dataP['cantidad']),1,0,'C');
        $pdf->Cell(100,6,$dataP['nameProd'],1,0,'C');
        $pdf->Cell(40,6,(number_format($dataP['nuevoPrecioTotal'])),1,1,'C');
    }


//TOTAL A PAGAR
$pdf->Ln(10);

$pdf->Cell(40,26,'',0,0,'C');
$pdf->SetFont('helvetica','B',12); 
$pdf->Cell(100,6,'TOTAL DE PUNTOS:  '.number_format($dataDeuda['totalPagar'], 0,'','.'),0,0,'C');


$pdf->Output('Resumen_Pedido_'.date('d_m_y').'.pdf', 'I'); 
//la D es para forzar la descargarnd del pdf y La I funciona como un target
