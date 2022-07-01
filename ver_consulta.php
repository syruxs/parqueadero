<?php 
ob_start(); 
?>
<?php
session_start();
date_default_timezone_set('America/Santiago');
$ver=$_SESSION['cliente'];
    require("admin/conex.php");

	$buscarCliente=mysqli_query($conn, "SELECT * FROM `clientes` WHERE doc='$ver'");
	while($resultCliente=mysqli_fetch_array($buscarCliente)){
		$Cliente=$resultCliente['nombre'];
	}

?>
<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Daniel Ugalde Ugalde">
	<link href="css/styleConsulta.css" rel="stylesheet">
	<link href="../css/bootstrap.min.css" rel="stylesheet">
<title>Consulta de Cliente</title>
</head>
<body>
	<div class="contend">
	<div class="table-responsive">
    	<table class="table table-striped table-hover" width="100%" style="font-size: 12px;">
        	<tr>
            	<th>N°</th>
				<th>Fecha</th>
                <th>Cliente</th>
                <th>Chofer</th>
				<th>Observaciones</th>
				<th>Servicio</th>
                <th>Descripción</th>
                <th>Valor</th>
                <th>Cantidad</th>
                <th>T. Pago</th>
                <th>T. Moneda</th>
                <th>Total</th>
                <th>Abono Inicial</th>
                <th>Saldo Actual</th>
              </tr>
				<?php
				$encontrarVenta=mysqli_query($conn, "SELECT * FROM `ventas` WHERE cliente='$Cliente' AND pago='CREDITO' AND saldo!='0'");
				while($rstVenta=mysqli_fetch_array($encontrarVenta)){
						$Id=$rstVenta['id'];
						$Service=$rstVenta['servicio'];
						$Detail=$rstVenta['descripcion'];
						$Abono=$rstVenta['abono'];
						$Total=$rstVenta['total'];
						$Saldo=$Total-$Abono;
						$Saldo=number_format($Saldo, 0, ',', '.');
					echo '
						  <tr>
							<td><a href="abono.php?var='.$rstVenta['id'].'" id="a" name="a">'.$rstVenta['id'].'</a></td>
							<td>'.date("d/m/Y", strtotime($rstVenta['date'])).'</td>
							<td style="text-transform:capitalize; width: auto;">'.$rstVenta['cliente'].'</td>
							<td style="text-transform:capitalize;">'.$rstVenta['chofer'].'</td>
							<td>'.$rstVenta['observaciones'].'</td>
							<td>'.$rstVenta['servicio'].'</td>
							<td>'.$rstVenta['descripcion'].'</td>
							<td align="right">$ '.number_format($rstVenta['valor'], 0, ',', '.').'</td>
							<td align="center">'.$rstVenta['cantidad'].'</td>
							<td>'.$rstVenta['pago'].'</td>
							<td>'.$rstVenta['moneda'].'</td>
							<td align="right">$ '.number_format($rstVenta['total'], 0, ',', '.').'</td>
							<td align="right">$ '.number_format($rstVenta['abono'], 0, ',', '.').'</td>
							<td align="right">$ '.number_format($rstVenta['saldo'], 0, ',', '.').'</td>
						</tr>					
					';
				}
				?>
		</table>
		<label><b>Saldo de la Venta inicial : <?php echo $Saldo;?></b></label>
		<hr/>
		<label><b>Abonos Posteriores</b></label>
		<table class="table table-striped table-hover" width="100%" style="font-size: 15px;">
			<tr>
				<th>Servicio</th>
				<th>Detalle</th>
				<th>Abono</th>
				<th>Saldo</th>
				<th>Fecha Abono</th>
				<th>usuario</th>
			</tr>
			<?php
				$buscarAbono=mysqli_query($conn, "SELECT * FROM `abono` WHERE id_venta='$Id'");
					while($rstAbono=mysqli_fetch_array($buscarAbono)){
						echo '
							<tr>
								<td>'.$Service.'</td>
								<td>'.$Detail.'</td>
								<td>'.number_format($rstAbono['abono'], 0, ',', '.').'</td>
								<td>'.number_format($rstAbono['saldo'], 0, ',', '.').'</td>
								<td>'.date("d-m-Y H:i:s", strtotime($rstAbono['date'])).'</td>
								<td>'.$rstAbono['user'].'</td>
							</tr>	
						';
					}
			?>
		</table>
	</div>
</body>
</html>
<?php 
ob_end_flush(); 
?>