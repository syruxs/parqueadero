<?php 
ob_start(); 
?>
<?php
session_start();
date_default_timezone_set('America/Santiago');
$ver=$_SESSION['user'];
$s=explode(',',$ver);
	if($s[0]!=""){
	}	else{
		header("Location:index.php");
		exit;
	}
    require("../admin/conex.php");

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
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Daniel Ugalde Ugalde">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css">
		<link href="../css/bootstrap.min.css" rel="stylesheet">
<title>Cierre de Mes</title>
		<style>
		body{
			padding: 20px;
			}			
		#titulo{
			width: 100%;
			border-bottom: 1px solid rgb(60, 57, 57);
		}
			select{
				border:1px solid #B0B0B0;
				border-radius: 5px;
				
			}
		</style>		
</head>
<body>
	<h3 class="animate__animated animate__backInLeft" id="titulo">Cierre de Mes</h3>
	<form action="cierreMes.php" method="post">
	<label>Seleccionar Fecha :</label>
	<select name="mes" id="mes">
		<option value="01">ENERO</option>
		<option value="02">FEBRERO</option>
		<option value="03">MARZO</option>
		<option value="04">ABRIL</option>
		<option value="05">MAYO</option>
		<option value="06">JUNIO</option>
		<option value="07">JULIO</option>
		<option value="08">AGOSTO</option>
		<option value="09">SEPTIEMBRE</option>
		<option value="10">OCTUBRE</option>
		<option value="11">NOVIEMBRE</option>
		<option value="12">DICIEMBRE</option>
	</select>
	<select name="year" id="year">
		<?php
		$Year = date("Y");
		echo '
			<option value="'.$Year.'">'.$Year.'</option>
		';
		?>
	</select>
	<input type="submit" value="BUSCAR">
	</form>
	<?php
	$Mes=$_POST['mes'];
	$year=$_POST['year'];

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
	<label><b>Mes de 
		<?php 
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
		echo $month;
		?>
		
		
		</b></label>
	<hr>
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
</body>
</html>
<?php 
ob_end_flush(); 
?>
