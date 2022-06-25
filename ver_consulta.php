<?php 
ob_start(); 
?>
<?php
session_start();
date_default_timezone_set('America/Santiago');
$ver=$_SESSION['cliente'];
    require("admin/conex.php");
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
    	<table class="table table-striped table-hover" width="100%">
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
                <th>Abono</th>
                <th>Saldo</th>
              </tr>
    <?php
    	error_reporting(0);
		$Cliente=$_POST['filter'];
		$tPago=$_POST['tpago'];

        
        $date1 = date("Y-m-d H:i:s", strtotime($_POST['date1']));
        $date2 = date("Y-m-d H:i:s", strtotime($_POST['date2']));
	
			if($Cliente == "TODOS" || $tPago == "TODOS"){
				
				$sql = mysqli_query($conn, "SELECT * FROM `ventas` where date BETWEEN '$date1' AND '$date2' ORDER BY id ASC");		
			}else{
				$sql = mysqli_query($conn, "SELECT * FROM `ventas` where cliente='$Cliente' and pago='$tPago' and date BETWEEN '$date1' AND '$date2' ORDER BY id ASC");
			}
			
			if(mysqli_num_rows($sql) == 0){
				
				$buscarCliente="SELECT * FROM `clientes` WHERE doc='$ver'";
				$resultado=mysqli_query($conn,$buscarCliente);
				while($userCliente=mysqli_fetch_array($resultado)){
					$ClienteVenta=$userCliente['nombre'];
				}
				
				$Sql=mysqli_query($conn, "SELECT * FROM `ventas` where cliente='$ClienteVenta");
				while($row = mysqli_fetch_array($Sql)){
				echo '

						  <tr>
							<td><a href="abono.php?var='.$row['id'].'" id="a" name="a">'.$row['id'].'</a></td>
							<td>'.date("d/m/Y", strtotime($row['date'])).'</td>
							<td style="text-transform:capitalize; width: auto;">'.$row['cliente'].'</td>
							<td style="text-transform:capitalize;">'.$row['chofer'].'</td>
							<td>'.$row['observaciones'].'</td>
							<td>'.$row['servicio'].'</td>
							<td>'.$row['descripcion'].'</td>
							<td align="right">$ '.number_format($row['valor'], 0, ',', '.').'</td>
							<td align="center">'.$row['cantidad'].'</td>
							<td>'.$row['pago'].'</td>
							<td>'.$row['moneda'].'</td>
							<td align="right">$ '.number_format($row['total'], 0, ',', '.').'</td>
							<td align="right">$ '.number_format($row['abono'], 0, ',', '.').'</td>
							<td align="right">$ '.number_format($row['saldo'], 0, ',', '.').'</td>
						</tr>
				';					
				}
				
			}else {
				
			while($row = mysqli_fetch_array($sql)){

				echo '

						  <tr>
							<td><a href="abono.php?var='.$row['id'].'" id="a" name="a">'.$row['id'].'</a></td>
							<td>'.date("d/m/Y", strtotime($row['date'])).'</td>
							<td style="text-transform:capitalize; width: auto;">'.$row['cliente'].'</td>
							<td style="text-transform:capitalize;">'.$row['chofer'].'</td>
							<td>'.$row['observaciones'].'</td>
							<td>'.$row['servicio'].'</td>
							<td>'.$row['descripcion'].'</td>
							<td align="right">$ '.number_format($row['valor'], 0, ',', '.').'</td>
							<td align="center">'.$row['cantidad'].'</td>
							<td>'.$row['pago'].'</td>
							<td>'.$row['moneda'].'</td>
							<td align="right">$ '.number_format($row['total'], 0, ',', '.').'</td>
							<td align="right">$ '.number_format($row['abono'], 0, ',', '.').'</td>
							<td align="right">$ '.number_format($row['saldo'], 0, ',', '.').'</td>
						</tr>
				';
		}				
			}

	?>
		</table>
	</div>
</body>
</html>
<?php 
ob_end_flush(); 
?>