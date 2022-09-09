<?php
sleep(1);
include('config.php');

/**
 * Nota: Es recomendable guardar la fecha en formato año - mes y dia (2022-08-25)
 * No es tan importante que el tipo de fecha sea date, puede ser varchar
 * La funcion strtotime:sirve para cambiar el forma a una fecha,
 * esta espera que se proporcione una cadena que contenga un formato de fecha en Inglés US,
 * es decir año-mes-dia e intentará convertir ese formato a una fecha Unix dia - mes - año.
*/

$fechaInit = date("Y-m-d", strtotime($_POST['f_ingreso']));
$fechaFin  = date("Y-m-d", strtotime($_POST['f_fin']));

$sqlTrabajadores = ("SELECT * FROM trabajadores WHERE  `fecha_ingreso` BETWEEN '$fechaInit' AND '$fechaFin' AND sueldo >'350000' ORDER BY fecha_ingreso ASC");
$query = mysqli_query($con, $sqlTrabajadores);
//print_r($sqlTrabajadores);
$total   = mysqli_num_rows($query);
echo '<strong>Total: </strong> ('. $total .')';
?>

<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">NOMBRE Y APELLIDO</th>
            <th scope="col">EMAIL</th>
            <th scope="col">TELEFONO</th>
            <th scope="col">SUELDO</th>
            <th scope="col">FECHA DE INGRESO</th>
        </tr>
    </thead>
    <?php
    $i = 1;
    while ($dataRow = mysqli_fetch_array($query)) { ?>
        <tbody>
            <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo $dataRow['nombre'] . ' ' . $dataRow['apellido']; ?></td>
                <td><?php echo $dataRow['email']; ?></td>
                <td><?php echo $dataRow['telefono']; ?></td>
                <td><?php echo '$ ' . $dataRow['sueldo']; ?></td>
                <td><?php echo $dataRow['fecha_ingreso']; ?></td>
            </tr>
        </tbody>
    <?php } ?>
</table>