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
		header("Location:../index.php");
		exit;
	}
    require("../admin/conex.php");
    error_reporting(0);
	$Mes=$_GET['mes'];
	$year=$_GET['ano'];

		if($Mes == "01"){
			$month="ENERO";
		}if($Mes == "02"){
			$month="FEBRERO";
		}if($Mes == "03"){
			$month="MARZO";
		}if($Mes == "04"){
			$month="ABRIL";
		}if($Mes == "05"){
			$month="MAYO";
		}if($Mes == "06"){
			$month="JUNIO";
		}if($Mes == "07"){
			$month="JULIO";
		}if($Mes == "08"){
			$month="AGOSTO";
		}if($Mes == "09"){
			$month="SEPTIEMBRE";
		}if($Mes == "10"){
			$month="OCTUBRE";
		}if($Mes == "11"){
			$month="NOVIEMBRE";
		}if($Mes == "12"){
			$month="DICIEMBRE";
		}
$apiUrl = 'https://mindicador.cl/api';
//Es necesario tener habilitada la directiva allow_url_fopen para usar file_get_contents
if ( ini_get('allow_url_fopen') ) {
    $json = file_get_contents($apiUrl);
} else {
    //De otra forma utilizamos cURL
    $curl = curl_init($apiUrl);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $json = curl_exec($curl);
    curl_close($curl);
}
 
$dailyIndicators = json_decode($json);
//echo 'El valor actual de la UF es $' . $dailyIndicators->uf->valor;
//echo 'El valor actual del Dólar observado es $' . $dailyIndicators->dolar->valor;
//echo 'El valor actual del Dólar acuerdo es $' . $dailyIndicators->dolar_intercambio->valor;
//echo 'El valor actual del Euro es $' . $dailyIndicators->euro->valor;
//echo 'El valor actual del IPC es ' . $dailyIndicators->ipc->valor;
//echo 'El valor actual de la UTM es $' . $dailyIndicators->utm->valor;
//echo 'El valor actual del IVP es $' . $dailyIndicators->ivp->valor;
//echo 'El valor actual del Imacec es ' . $dailyIndicators->imacec->valor;
$dolar=$dailyIndicators->dolar->valor;
?>
<!doctype html>
<html>
<head>
		<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Daniel Ugalde Ugalde">
		<link href="../css/bootstrap.min.css" rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/chart.js@latest/dist/Chart.min.js"></script>
<title>Reporte</title>
</head>

<body>
	<h1>Cierre de Mes de <?php echo $month." ".$ano;?></h1>
	<hr>
	<?php
	$date1 = date("$year-$Mes-01 00:00:00", strtotime());
    $date2 = date("$year-$Mes-31 23:59:59", strtotime());
	
	$SQL = mysqli_query($conn, "SELECT SUM(cancelado) as cancelado FROM `ingreso` WHERE estado='INACTIVO' and fecha_salida BETWEEN '$date1' AND '$date2'");	
		
	while($ROW = mysqli_fetch_array($SQL)){
		$To = $ROW['cancelado'];
		$V_cancelado = number_format($To,0,',','.');
	}
	
	$NSQL = mysqli_query($conn, "SELECT SUM(total) as total FROM `ventas` WHERE date BETWEEN '$date1' AND '$date2' and servicio='VENTA NEUMATICOS' and pago='CONTADO'");
	
	while($SqlR = mysqli_fetch_array($NSQL)){
		$Total = $SqlR['total'];
		$vdolar= $Total * $dolar;
		$VTotal = number_format($vdolar,0,',','.');
		$Total = number_format($Total,0,',','.');
	}
	
	$Nsqli = mysqli_query($conn, "SELECT SUM(total) as total FROM `ventas` WHERE date BETWEEN '$date1' AND '$date2' and servicio='VENTA NEUMATICOS' and pago='CREDITO'");
	
	while($SqlRs = mysqli_fetch_array($Nsqli)){
		$total = $SqlRs['total'];
		$VDolar = $total * $dolar;
		$vTotal = number_format($VDolar,0,',','.');
		$total = number_format($total,0,',','.');
	}
	
	$ventas = mysqli_query($conn, "SELECT SUM(total) as total FROM `ventas` WHERE date BETWEEN '$date1' AND '$date2' and servicio!='VENTA NEUMATICOS' and pago='CREDITO'");
	
	while($Rventas = mysqli_fetch_array($ventas)){
		$tol =  $Rventas['total'];
		$vVentas = number_format($tol,0,',','.');
	}
	
	$TotalGeneral = $To + $vdolar + $VDolar + $tol;
	$TotalGeneral = number_format($TotalGeneral,0,',','.');
	
	//Salidas
	$SqlGas = mysqli_query($conn, "SELECT SUM(total) as total FROM `cueta` WHERE fecha BETWEEN '$date1' AND '$date2'");
	while($RstGas = mysqli_fetch_array($SqlGas)){
		$Gastos = $RstGas['total'];
		$Gastos = number_format($Gastos,0,',','.');
	}
	?>	
	<label>Ventas por concepto de Parqueadero : <?php echo '$ '.$V_cancelado.'';?></label>
	<hr>
	<label>Valor de dolar de referencia: USD <?php echo $dolar; ?></label><br>
	<label>Ventas por concepto de Neumaticos : <?php echo '$ '.$VTotal.' -> USD '.$Total.'';?> Contado.</label><br>
	<label>Ventas por concepto de Neumaticos : <?php echo '$ '.$vTotal.' -> USD '.$total.'';?> Credito</label>
	<hr>
	<label>Ventas por otro conceptos : <?php echo '$ '.$vVentas.'';?></label>
	<hr>
	<label>Total de Ventas : <?php echo '$ '.$TotalGeneral.'';?></label><br>
	<label>Total de Gastos : <?php echo '$ '.$Gastos.'';?></label>
	<hr>
	<canvas id="grafica"></canvas>
	<script type="text/javascript">
		// Obtener una referencia al elemento canvas del DOM
		const $grafica = document.querySelector("#grafica");
		// Las etiquetas son las porciones de la gráfica
		const etiquetas = ["PARQUEADERO", "NEUMATICOS CREDITO", "NEUMATICOS CONTADO", "OTROS SERVICIOS"]
		// Podemos tener varios conjuntos de datos. Comencemos con uno
		const datosIngresos = {

		data: [<?php echo $To;?>, <?php echo $VDolar;?>, <?php echo $vdolar;?>, <?php echo $tol;?>], // La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas
		// Ahora debería haber tantos background colors como datos, es decir, para este ejemplo, 4
		backgroundColor: [
			'rgba(163,221,203,0.8)',
			'rgba(232,233,161,0.8)',
			'rgba(230,181,102,0.8)',
			'rgba(229,112,126,0.8)',
			//'rgba(200,190,200,0.8)',
		],// Color de fondo
		borderColor: [
			'rgba(163,221,203,1)',
			'rgba(232,233,161,1)',
			'rgba(230,181,102,1)',
			'rgba(229,112,126,1)',
			//'rgba(200,190,200,1)',
		],// Color del borde
		borderWidth: 1,// Ancho del borde
	};
	new Chart($grafica, {
		type: 'pie',// Tipo de gráfica. Puede ser dougnhut o pie
		data: {
			labels: etiquetas,
			datasets: [
				datosIngresos,
				// Aquí más datos...
			]
		},
	});
	</script>
</body>
</html>
<?php
$html=ob_get_clean();
require_once'../dompdf/autoload.inc.php';
use Dompdf\Dompdf;
$dompdf = new Dompdf();
$options = $dompdf->getOptions();
$options->set(array('isRemoteEnabled' => true));
$dompdf->setOptions($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('letter');
$dompdf->render();
$dompdf->stream("cierreMes.pdf", array("Attachment"=> false));
?>