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
		<script src="https://cdn.jsdelivr.net/npm/chart.js@latest/dist/Chart.min.js"></script>
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
	
	//VENTAS DEL PARQUEADDERO
	$SQL = mysqli_query($conn, "SELECT SUM(cancelado) as cancelado FROM `ingreso` WHERE estado='INACTIVO' and fecha_salida BETWEEN '$date1' AND '$date2'");	
		
	while($ROW = mysqli_fetch_array($SQL)){
		$To = $ROW['cancelado'];
		$V_cancelado = number_format($To,0,',','.');
	}
	//VENTA DE NEUMATICOS EN DOLAR AL CONTADO
	$NSQL = mysqli_query($conn, "SELECT SUM(total) as total FROM `ventas` WHERE date BETWEEN '$date1' AND '$date2' and servicio='VENTA NEUMATICOS' and moneda='DOLAR' and pago='CONTADO'");
	
	while($SqlR = mysqli_fetch_array($NSQL)){
		$Total = $SqlR['total'];
		$vdolar= $Total * $dolar;
		$VTotal = number_format($vdolar,0,',','.');
		$TotaL = number_format($Total,0,',','.');
	}
	//VENTA DE NEUMATICOS EN DOLAR A CREDITO
	$Nsqli = mysqli_query($conn, "SELECT SUM(total) as total FROM `ventas` WHERE date BETWEEN '$date1' AND '$date2' and servicio='VENTA NEUMATICOS' and moneda='DOLAR' and pago='CREDITO'");
	
	while($SqlRs = mysqli_fetch_array($Nsqli)){
		$total = $SqlRs['total'];
		$VDolar = $total * $dolar;
		$vTotal = number_format($VDolar,0,',','.');
		$totaL = number_format($total,0,',','.');
	}
	//VENTA DE NEUMATICOS EN PESOS CHILENOS AL CONTADO
	$sql_chileno_contado = mysqli_query($conn, "SELECT SUM(total) as total FROM `ventas` WHERE date BETWEEN '$date1' AND '$date2' and servicio='VENTA NEUMATICOS' and moneda='PESO CHILENO' and pago='CONTADO'");
	
	while($SqlContado = mysqli_fetch_array($sql_chileno_contado)){
		$TotalContado = $SqlContado['total'];
		$vdolarContado= $TotalContado * $dolar;
		$VTotalContado = number_format($vdolarContado,0,',','.');
		$TotaLContado = number_format($TotalContado,0,',','.');
	}	
	$SumaNeumaticoPesosContado=$TotalContado + $vdolar;
	$ContadoDolar=$SumaNeumaticoPesosContado/$dolar;
	$SumaNeumaticoPesosContado = number_format($SumaNeumaticoPesosContado,0,',','.');
	$ContadoDolar = number_format($ContadoDolar,0,',','.');
	//VENTA DE NEUMATICOS EN PESOS CHILENOS AL CREDITO
	$sql_chileno_credito = mysqli_query($conn, "SELECT SUM(total) as total FROM `ventas` WHERE date BETWEEN '$date1' AND '$date2' and servicio='VENTA NEUMATICOS' and moneda='PESO CHILENO' and pago='CREDITO'");
	
	while($SqlCredito = mysqli_fetch_array($sql_chileno_credito)){
		$TotalCredito = $SqlCredito['total'];
		$vdolarCredito= $TotalCredito * $dolar;
		$VTotalCredito = number_format($vdolarCredito,0,',','.');
		$TotaLCredito = number_format($TotalCredito,0,',','.');
	}	
	$SumaNeumaticoPesosCredito=$TotalCredito + $VDolar;
	$CreditoDolar=$SumaNeumaticoPesosCredito/$dolar;
	$SumaNeumaticoPesosCredito = number_format($SumaNeumaticoPesosCredito,0,',','.');
	$CreditoDolar = number_format($CreditoDolar,0,',','.');	
	//VENTA DE OTROS SERVICIOS A CREDITO
	$ventas = mysqli_query($conn, "SELECT SUM(total) as total FROM `ventas` WHERE date BETWEEN '$date1' AND '$date2' and servicio!='VENTA NEUMATICOS' and pago='CREDITO'");
	
	while($Rventas = mysqli_fetch_array($ventas)){
		$tol =  $Rventas['total'];
		$vVentas = number_format($tol,0,',','.');
	}
	//VENTA DE OTRSO SERVICIOS AL CONTADO
	$sale = mysqli_query($conn, "SELECT SUM(total) as total FROM `ventas` WHERE date BETWEEN '$date1' AND '$date2' and servicio!='VENTA NEUMATICOS' and pago='CONTADO'");
	
	while($Rsale = mysqli_fetch_array($sale)){
		$tolSale=  $Rsale['total'];
		$vSale = number_format($tolSale,0,',','.');
	}
	
	$TotalGeneral = $To + $vdolar + $VDolar + $tol;
	$TotalGeneral = number_format($TotalGeneral,0,',','.');
	
	//SALIDAS
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
	<label>Ventas por concepto de Neumaticos : <?php echo '$ '.$SumaNeumaticoPesosContado.' -> USD '.$ContadoDolar.'';?> Contado.</label><br>
	<label>Ventas por concepto de Neumaticos : <?php echo '$ '.$SumaNeumaticoPesosCredito.' -> USD '.$CreditoDolar.'';?> Credito</label>
	<hr>
	<label>Ventas por otros conceptos : <?php echo '$ '.$vVentas.'';?> CREDITO</label><br>
	<label>Ventas por otros conceptos : <?php echo '$ '.$vSale.'';?> CONTADO</label>
	<hr>
	<label>Total de Ventas : <?php echo '$ '.$TotalGeneral.'';?></label><br>
	<label>Total de Gastos : <?php echo '$ '.$Gastos.'';?></label>
	<hr>
	<a href="pdf.php?mes=<?php echo $Mes?>&ano=<?php echo $year?>" target="_blank"><input type="button" value="REPORTE" title="IMPRIMIR PDF CIERRE MES" class=""></a>
	<canvas id="grafica"></canvas>
	<script type="text/javascript">
		// Obtener una referencia al elemento canvas del DOM
		const $grafica = document.querySelector("#grafica");
		// Las etiquetas son las porciones de la gráfica
		const etiquetas = ["PARQUEADERO", "NEUMATICOS CREDITO", "NEUMATICOS CONTADO", "OTROS SERVICIOS CREDITO", "OTROS SERVICIOS CONTADO"]
		// Podemos tener varios conjuntos de datos. Comencemos con uno
		const datosIngresos = {

		data: [<?php echo $To;?>, <?php echo $VDolar;?>, <?php echo $vdolar;?>, <?php echo $tol;?>, <?php echo $tolSale;?>], // La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas
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
ob_end_flush(); 
?>
