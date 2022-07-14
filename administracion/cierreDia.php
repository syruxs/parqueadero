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
<title></title>
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
	<h3 class="animate__animated animate__backInLeft" id="titulo">Cierre de Día</h3>
	<hr>
	<form action="cierreDia.php" method="post">
	<table width="100%" border="0" cellpadding="4" cellspacing="4">
		<tr>
			<td><label>Fecha y Hora de Incio :</label></td>
			<td><input type="datetime-local" class="form-control" name="date1" id="date1" ></td>
			<td><label>Fecha y Hora de Termino :</label></td>
			<td><input type="datetime-local" class="form-control" name="date2" id="date2" ></td>
			<td><button class="btn btn-primary" type="submit">BUSCAR</button></td>
		</tr>
	</table>
	<hr>
		<?php
			$date1 = date("Y-m-d H:i:s", strtotime($_POST['date1']));
        	$date2 = date("Y-m-d H:i:s", strtotime($_POST['date2']));
		
			$sql = mysqli_query($conn, "SELECT * FROM `ingreso` where estado='INACTIVO' and fecha_salida BETWEEN '$date1' AND '$date2' ORDER BY id ASC");
			$Sql = mysqli_query($conn, "SELECT SUM(pago) as pago FROM `ingreso` WHERE estado='INACTIVO' and fecha_salida BETWEEN '$date1' AND '$date2' ORDER BY id ASC ");	
			$SQL = mysqli_query($conn, "SELECT SUM(cancelado) as cancelado FROM `ingreso` WHERE estado='INACTIVO' and fecha_salida BETWEEN '$date1' AND '$date2' ORDER BY id ASC ");
		
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
		$date_in=date("d-m-Y H:i:s", strtotime($date1));
		$date_out=date("d-m-Y H:i:s", strtotime($date2));
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
		//VENTA DE NEUMATICOS EN DOLAR AL CONTADO
		$NSQL = mysqli_query($conn, "SELECT SUM(total) as total FROM `ventas` WHERE date BETWEEN '$date1' AND '$date2' and servicio='VENTA NEUMATICOS' and moneda='DOLAR' and pago='CONTADO'");

		while($SqlR = mysqli_fetch_array($NSQL)){
			$Total = $SqlR['total'];
			$vdolar= $Total * $dolar;
			$VTotal = number_format($vdolar,0,',','.');
			$TotaL = number_format($Total,0,',','.');
		}
		$a=mysqli_num_rows($sql_chileno_contado);
		$b=mysqli_num_rows($NSQL);
		$regis=$a+$b;
		?>
		<label>Rango de Cierre entre la fecha <?php echo $date_in; ?> hasta la fecha : <?php echo $date_out;?></label>
		<table width="80%" border="0" cellpadding="4"  cellspacing="4" class="table table-hover">
			<tr>
				<th width="50%" align="center">
					<label>PARQUEADERO</label>
				</th>
				<th width="50%" align="center">
					<label>NEUMATICOS</label>
				</th>
			</tr>
			<tr>
				<td>
					<label>Registros encontrados : <?php echo mysqli_num_rows($sql);?></label>
				</td>
				<td>
					<label>Registros encontrados : <?php echo $regis;?></label>
				</td>
			</tr>
			<tr>
				<td>
					<label>Venta Sistema: <?php echo "$ ".$V_sistem."" ?></label>
				</td>
				<td>
					<label>Venta Neumaticos : <?php echo '$ '.$SumaNeumaticoPesosContado.'';?> </label>
				</td>
			</tr>
			<tr>
				<td>
					<label>Venta Real: <?php echo "$ ".$V_cancelado.""?></label>
				</td>
				<td>
					<label>Venta Neumaticos : <?php echo 'USD '.$TotaL.'';?>
				</td>
			</tr>
		</table>
		<label>Cierre en $ : <?php 
			$par=trim(str_replace(array('-','.'), '', $V_cancelado));
			$neu=trim(str_replace(array('-','.'), '', $SumaNeumaticoPesosContado));
			$final  = $par + $neu;
			echo $final = number_format($final,0,',','.');
			?></label> | <label>Cierre en USD :
			<?php
			echo $TotaL;
			?>
		</label>
	</form>
</body>
</html>
<?php 
ob_end_flush(); 
?>
