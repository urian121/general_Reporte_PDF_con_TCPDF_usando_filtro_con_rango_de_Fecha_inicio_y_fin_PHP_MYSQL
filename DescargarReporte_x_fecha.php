<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> <!--Importante--->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Descargar</title>
    <style>
    .color{
        background-color: #9BB;  
    }
</style>
</head>
<body>
    
<?php
include('config.php');
$fecha = date("d_m_Y");


/**PARA FORZAR LA DESCARGA DEL EXCEL */
header("Content-Type: text/html;charset=utf-8");
header("Content-Type: application/vnd.ms-excel charset=iso-8859-1");
$filename = "ReporteExcel_" .$fecha. ".xls";
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Disposition: attachment; filename=" . $filename . "");


/***RECIBIENDO LAS VARIABLE DE LA FECHA */
$fechaInit = date("Y-m-d", strtotime($_POST['fecha_ingreso']));
$fechaFin  = date("Y-m-d", strtotime($_POST['fechaFin']));


/*
$sqlTrabajadores = ("select * from trabajadores where (fecha_ingreso>='$fechaInit' and fecha_ingreso<='$fechaFin') order by fecha_ingreso desc");
$sqlTrabajadores = ("SELECT * FROM trabajadores WHERE fecha_ingreso BETWEEN '$fechaInit' AND '$fechaFin' order by fecha_ingreso desc
$sqlTrabajadores = ("SELECT * FROM `trabajadores` WHERE fecha_ingreso BETWEEN '$fechaInit' AND '$fechaFin'
$sqlTrabajadores = ("select * from trabajadores where fecha_ingreso >= '$fechaInit' and fecha_ingreso < '$fechaFin';
$sqlTrabajadores = ("SELECT * FROM trabajadores WHERE fecha_ingreso BETWEEN '$fechaInit' AND '$fecha2' ORDER BY fecha_ingreso DESC
*/                       

$sqlTrabajadores = ("SELECT * FROM trabajadores WHERE (fecha_ingreso>='$fechaInit' and fecha_ingreso<='$fechaFin') ORDER BY fecha_ingreso ASC");
$query = mysqli_query($con, $sqlTrabajadores);
?>


<table style="text-align: center;" border='1' cellpadding=1 cellspacing=1>
<thead>
    <tr style="background: #D0CDCD;">
    <th>#</th>
    <th class="color">NOMBRE</th>
    <th class="color">APELLIDO</th>
    <th class="color">EMAIL</th>
    <th class="color">TELEFONO</th>
    <th class="color">SUELDO</th>
    <th class="color">FECHA DE INGRESO</th>
    </tr>
</thead>
<?php
$i =1;
    while ($dataRow = mysqli_fetch_array($query)) { ?>
    <tbody>
        <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo $dataRow['nombre']; ?></td>
            <td><?php echo $dataRow['apellido']; ?></td>
            <td><?php echo $dataRow['email'] ; ?></td>
            <td><?php echo $dataRow['telefono'] ; ?></td>
            <td><?php echo $dataRow['sueldo'] ; ?></td>
            <td><?php echo $dataRow['fecha_ingreso'] ; ?></td>
        </tr>
    </tbody>
    
<?php } ?>
</table>

</body>
</html>