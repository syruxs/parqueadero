<?php 
ob_start(); 
?>
<?php
session_start();
date_default_timezone_set('America/Santiago');
$date=date('d-m-Y H:i:s', time()); 
$ver=$_SESSION['user'];
$s=explode(',',$ver);
	if($s[0]!=""){
	}	else{
		header("Location:index.php");
		exit;
	}
    require("admin/conex.php");

    $Sql_user=mysqli_query($conn,"SELECT * FROM  `login` where user='$ver'");
    while($rst_Sql_name=mysqli_fetch_array($Sql_user)){
            $usuario=$rst_Sql_name['user'];
            $nombre=$rst_Sql_name['name'];
			$perfil=$rst_Sql_name['perfil'];
		}
     error_reporting(0);
	$filter=$_GET['filter'];
    $date1 = date("Y-m-d H:i:s", strtotime($_GET['date1']));
    $date2 = date("Y-m-d H:i:s", strtotime($_GET['date2']));
?>
<!doctype html>
<html>
<head>
		<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Daniel Ugalde Ugalde">
<title>Imprimir Reporte <?php echo $date; ?></title>
</head>

<body>
	
	    <div class="table-responsive">
			<h2>Reporte de Vehiculos en Sistema  ---- <?php echo $filter;?></h2>
			<label>Reporte desde : <?php echo date("d-m-Y H:i:s", strtotime($date1));?> hasta: <?php  echo date("d-m-Y H:i:s", strtotime($date2));?></label>
            <table border="1" cellpadding="4" cellspacing="0" width="100%">
                <tr style="background-color:slategrey">
                    <th>N°</th>
                    <th>Tracto</th>
                    <th>Semi</th>
					<th>Tipo</th>
					<th>Carga</th>
                    <th>Observaciones</th>
                    <th>Entrada</th>
                </tr>
                <?php


				if($filter=="ACTIVO"){
			        $DATE_X="fecha_ingreso";

                    $sql = mysqli_query($conn, "SELECT * FROM `ingreso` where estado='$filter' and $DATE_X BETWEEN '$date1' AND '$date2' ORDER BY id ASC");
				}else{
					$filter=="INACTIVO";
				    $DATE_X="fecha_salida";

                    $sql = mysqli_query($conn, "SELECT * FROM `ingreso` where estado='$filter' and $DATE_X BETWEEN '$date1' AND '$date2' ORDER BY id ASC");
					$Sql = mysqli_query($conn, "SELECT SUM(pago) as pago FROM `ingreso` WHERE estado='INACTIVO' and fecha_salida BETWEEN '$date1' AND '$date2' ORDER BY id ASC ");	
					$SQL = mysqli_query($conn, "SELECT SUM(cancelado) as cancelado FROM `ingreso` WHERE estado='INACTIVO' and fecha_salida BETWEEN '$date1' AND '$date2' ORDER BY id ASC ");					
				}

                if(mysqli_num_rows($sql) == 0){

                    echo '<tr><td colspan="11">No hay datos. Por favor seleccione una opción</td></tr>';

                }else{

				
                    $no = 1;

                    while($row = mysqli_fetch_assoc($sql)){
						while($Row = mysqli_fetch_array($Sql)){
							$Total = $Row['pago'];
							$V_sistem =number_format($Total,0,',','.');
						}
						while($ROW = mysqli_fetch_array($SQL)){
							$To = $ROW['cancelado'];
							$V_cancelado =number_format($To,0,',','.');
						}

						$total = $Total - $To;
						$diferencia=number_format($total,0,',','.');
                     echo '

                    <tr>

                        <td>'.$no.'</td>
                        <td>'.$row['tracto'].'</td>
                        <td>'.$row['semi'].'</td>
						<td>'.$row['tipo'].'</td>
						<td>'.$row['carga'].'</td>
                        <td>'.$row['observaciones'].'</td>
                        <td>'.date("d/m/Y H:i:s", strtotime($row['fecha_ingreso'])).'</td>
                    </tr>

                    ';$no++;

                   

                 }

                }
			?>

            </table>
			<label style="font-size: 8;">Generado el: <?php echo $date;?></label>
		 </div>
</body>
</html>
<?php
$html=ob_get_clean();

require_once'dompdf/autoload.inc.php';
use Dompdf\Dompdf;
$dompdf = new Dompdf();

$options = $dompdf->getOptions();
$options->set(array('isRemoteEnabled' => true));
$dompdf->setOptions($options);

$dompdf->loadHtml($html);

$dompdf->setPaper('letter');

$dompdf->render();

$dompdf->stream("reporte.pdf", array("Attachment"=> false));
?>
