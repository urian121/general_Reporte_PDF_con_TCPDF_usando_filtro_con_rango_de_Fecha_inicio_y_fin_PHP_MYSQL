<?php
require_once('tcpdf/tcpdf.php');
require("config.php");
$tokenCliente = $_REQUEST['tokenCliente'];

$codPedido = substr($tokenCliente, 0, 5);

//SQL para buscar el Logo de la empresa de dicho cliente, primero busco el di del cliente
$sqlCli   = ("SELECT producto_id, fecha, hours FROM pedidostemporales WHERE tokenCliente='".$tokenCliente."'");
$queryCli = mysqli_query($con, $sqlCli);
$DataCli  = mysqli_fetch_array($queryCli);


//ahora consulto el id del producto
$sqlProd   = ("SELECT cliente_id FROM productos WHERE id='".$DataCli['producto_id']."'");
$queryProd = mysqli_query($con, $sqlProd);
$DataProd  = mysqli_fetch_array($queryProd);
$DataProd['cliente_id'];


$sqlLogo   = ("SELECT * FROM logo WHERE cliente_id='".$DataProd['cliente_id']."' AND statuslogo='1'  ");
$queryLogo = mysqli_query($con, $sqlLogo);
$totalLogo = mysqli_num_rows($queryLogo);
$DataLogo  = mysqli_fetch_array($queryLogo);
//$url_log   = $DataLogo['logo'];
 


ob_end_clean(); //limpiar la memoria


class MYPDF extends TCPDF
{
       /* function Header()
        {
           $this->Image('panel/'.$url_log, 5, 5, 30 );
            $this->SetFont('Arial','B',15);
            $this->Cell(30);
            $this->Cell(120,10, 'Reporte De Estados',0,0,'C');
            $this->Ln(20);
        } */

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

 
//agregar pag 1
$pdf->AddPage();

$pdf->SetFont('helvetica','B',10); 
$pdf->SetXY(150, 20);
$pdf->Write(0, 'Código: '. $codPedido);
$pdf->SetXY(150, 25);
$pdf->Write(0, 'Fecha: '. $DataCli['fecha']);
$pdf->SetXY(150, 30);
$pdf->Write(0, 'Hora: '. $DataCli['hours']);


$pdf->Ln(20);
$pdf->Cell(40,26,'',0,0,'C');
//$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('helvetica','B',12); 
$pdf->Cell(100,6,'RESUMEN DE MI PEDIDO',0,0,'C');


$pdf->Ln(10);

//Valido si exite el logo y lo tiene activo pues entro en esta condicion.
if ($totalLogo >0) {
    $logo = 'panel/'.$DataLogo['logo'];
    $pdf->Image($logo, 25, 20, 25, '', '', '', '', false, 300, '', false, false, 0, false, false, false);
}


$pdf->SetFillColor(232,232,232);
$pdf->SetFont('helvetica','B',12); //LA b ES PARA NEGRITA
$pdf->Cell(30,6,'Cantidad',1,0,'C',1);
$pdf->Cell(100,6,'Producto',1,0,'C',1);
$pdf->Cell(40,6,'SubTotal',1,1,'C',1);


$pdf->SetFont('helvetica','',10);


$sqlTotalSolicitud = ("SELECT 
    p.id,
    p.precio,
    p.nombreProduct,
    pt.producto_id,
    pt.tokenCliente,
    pt.cantidad,
    pt.nuevoPrecioTotal
    FROM productos as p, pedidostemporales AS pt
    WHERE p.id=pt.producto_id AND tokenCliente='".$tokenCliente."' ");
    $jqueryDeudaSolicitud   = mysqli_query($con, $sqlTotalSolicitud); 


/****Total a Pagar *****/
$SqlDeuda = ("SELECT 
    p.id, p.precio,
    p.nombreProduct,
    pt.producto_id,
    pt.tokenCliente,
    pt.cantidad,
    SUM(p.precio * pt.cantidad) AS totalPagar 
    FROM productos as p, pedidostemporales AS pt
    WHERE p.id=pt.producto_id AND tokenCliente='".$tokenCliente."' ");
    $jqueryDeuda   = mysqli_query($con, $SqlDeuda); 
    $dataDeuda     = mysqli_fetch_array($jqueryDeuda); 


while ($dataP = mysqli_fetch_array($jqueryDeudaSolicitud)) {
        $pdf->Cell(30,6,($dataP['cantidad']),1,0,'C');
        $pdf->Cell(100,6,$dataP['nombreProduct'],1,0,'C');
        $pdf->Cell(40,6,('$ '. number_format($dataP['nuevoPrecioTotal'])),1,1,'C');
    }


//TOTAL A PAGAR
$pdf->Ln(10);

$pdf->Cell(40,26,'',0,0,'C');
$pdf->SetFont('helvetica','B',12); 
$pdf->Cell(100,6,'TOTAL A PAGAR: $ '.number_format($dataDeuda['totalPagar'], 0,'','.'),0,0,'C');

/*
$pdf->SetFont('helvetica','B',13); 
$pdf->SetXY(135, 88);
$pdf->SetTextColor(220, 20, 60);
$pdf->Write(0, number_format($dataDeuda['totalPagar'], 0,'','.'));
*/


$pdf->Output('Resumen_Pedido_.'.date('dmy').'.pdf', 'I'); 
//la D es para forzar la descargarnd del pdf y La I funciona como un target

?>
