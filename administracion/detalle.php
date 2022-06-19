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
    $Sql_user=mysqli_query($conn,"SELECT * FROM  `login` where user='$ver'");
    while($rst_Sql_name=mysqli_fetch_array($Sql_user)){
            $usuario=$rst_Sql_name['user'];
            $nombre=$rst_Sql_name['name'];
			$perfil=$rst_Sql_name['perfil'];
		}
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
<title>Ingresar Documentos</title>
		<script type="text/javascript" src="../js/validar_fechas.js"></script>
		<script src="../js/jquery-3.6.0.js"></script>
		<script>
		$(document).ready(function () {
			$(this).val(jQuery.trim($(this).val()));
		});
		</script>
		<style>
		body{
				padding: 20px;
			}			
		#titulo{
			width: 100%;
			border-bottom: 1px solid rgb(60, 57, 57);
		}
		</style>
</head>

<body>
	<h3 class="animate__animated animate__backInLeft" id="titulo">Resumen de Gastos</h3>
	<form class="form-inline" action="detalle.php" method="post" id="formulario">
		<div class="form-group">
			<label>Seleccionar tipo de Documento: &nbsp;&nbsp;</label>
			<select class="form-control" name="filter" id="filter" required>
				<option value="0">----------</option>
				<option value="FACTURA">FACTURA</option>
				<option value="BOLETA">BOLETA</option>
				<option value="OTROS">OTROS</option>
				<option value="TODOS">TODOS</option>
			</select>
			&nbsp;&nbsp;
			<label>Fecha de Inicio: </label>&nbsp;&nbsp;
			<input type="date" name="date1" id="date1" required>&nbsp;&nbsp;
			<label>Fecha de Termino: </label>&nbsp;&nbsp;
			<input type="date" name="date2" id="date2" required>&nbsp;&nbsp;
			<input type="submit" value="BUSCAR" title="BUSCAR EXPEIDNETE">
		</div>
	</form>
	<br>
	<div class="table-responsive" style="font-size: 9px;">
    	<table class="table table-striped table-hover" style="background-color: white; color: rgb(110, 108, 108);">
			<tr>
				<th>DOCUMENTO</th>
				<th>N°</th>
				<th>FECHA</th>
				<th>PROVEEDOR</th>
				<th>RUT</th>
				<th>DIRECCION</th>
				<th>CIUDAD</th>
				<th>CUENTA</th>
				<th>TOTAL</th>
				<th>NETO</th>
				<th>IVA</th>
				<th>OBSERVACIONES</th>
			</tr>
			<?php
			error_reporting(0);
			$encontrar=$_POST['filter'];
			$date1=$_POST['date1'];
			$date2=$_POST['date2'];

			if($encontrar == "FACTURA") {
				$sql = mysqli_query($conn, "SELECT * FROM `cueta` where documento='$encontrar' and fecha BETWEEN '$date1' AND '$date2' ORDER BY id ASC");
				$Sql = mysqli_query($conn, "SELECT SUM(total) as total FROM `cueta` WHERE documento='$encontrar' and fecha BETWEEN '$date1' AND '$date2' ORDER BY id ASC ");
				$SQl = mysqli_query($conn, "SELECT SUM(neto) as neto FROM `cueta` WHERE documento='$encontrar' and fecha BETWEEN '$date1' AND '$date2' ORDER BY id ASC ");
				$SQL = mysqli_query($conn, "SELECT SUM(iva) as iva FROM `cueta` WHERE documento='$encontrar' and fecha BETWEEN '$date1' AND '$date2' ORDER BY id ASC ");
				
				if(mysqli_num_rows($sql) == 0){
					echo '<tr><td colspan="11">No hay datos. Por favor seleccione una opción</td></tr>';
				}else{
					 while($row = mysqli_fetch_assoc($sql)){
						while($Row = mysqli_fetch_array($Sql)){
							$Total = $Row['total'];
							$Total =number_format($Total,0,',','.');
						}
						while($ROw = mysqli_fetch_array($SQl)){
							$Neto = $ROw['neto'];
							$Neto =number_format($Neto,0,',','.');
						}
						while($ROW = mysqli_fetch_array($SQL)){
							$Iva = $ROW['iva'];
							$Iva =number_format($Iva,0,',','.');
						}
						 echo '
						 	<tr>
								<td>'.$row['documento'].'</td>
								<td>'.$row['numero'].'</td>
								<td>'.date("d/m/Y", strtotime($row['fecha'])).'</td>
								<td>'.$row['proveedor'].'</td>
								<td>'.$row['rut'].'</td>
								<td>'.$row['direccion'].'</td>
								<td>'.$row['ciudad'].'</td>
								<td>'.$row['cuenta'].'</td>
								<td align="right">$'.number_format($row['total'],0,',','.').'</td>
								<td align="right">$'.number_format($row['neto'],0,',','.').'</td>
								<td align="right">$'.number_format($row['iva'],0,',','.').'</td>
								<td>'.$row['observaciones'].'</td>
							</tr>
						 ';
					 }
				}
			}if($encontrar == "BOLETA") {
				$sql = mysqli_query($conn, "SELECT * FROM `cueta` where documento='$encontrar' and fecha BETWEEN '$date1' AND '$date2' ORDER BY id ASC");
				$Sql = mysqli_query($conn, "SELECT SUM(total) as total FROM `cueta` WHERE documento='$encontrar' and fecha BETWEEN '$date1' AND '$date2' ORDER BY id ASC ");
				if(mysqli_num_rows($sql) == 0){
					echo '<tr><td colspan="11">No hay datos. Por favor seleccione una opción</td></tr>';
				}else{
					while($row = mysqli_fetch_assoc($sql)){
						while($Row = mysqli_fetch_array($Sql)){
							$Total = $Row['total'];
							$Total =number_format($Total,0,',','.');
						}						
						 echo '
						 	<tr>
								<td>'.$row['documento'].'</td>
								<td>'.$row['numero'].'</td>
								<td>'.date("d/m/Y", strtotime($row['fecha'])).'</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td>'.$row['cuenta'].'</td>
								<td align="right">$'.number_format($row['total'],0,',','.').'</td>
								<td align="right"></td>
								<td align="right"></td>
								<td>'.$row['observaciones'].'</td>
							</tr>
						 ';					
					}
				}
	
			}if($encontrar == "OTROS") {
				$sql = mysqli_query($conn, "SELECT * FROM `cueta` where documento='$encontrar' and fecha BETWEEN '$date1' AND '$date2' ORDER BY id ASC");
				$Sql = mysqli_query($conn, "SELECT SUM(total) as total FROM `cueta` WHERE documento='$encontrar' and fecha BETWEEN '$date1' AND '$date2' ORDER BY id ASC ");
			
				if(mysqli_num_rows($sql) == 0){
					echo '<tr><td colspan="11">No hay datos. Por favor seleccione una opción</td></tr>';
				}else{
					 while($row = mysqli_fetch_assoc($sql)){
						while($Row = mysqli_fetch_array($Sql)){
							$Total = $Row['total'];
							$Total =number_format($Total,0,',','.');
						}
						 echo '
						 	<tr>
								<td>'.$row['documento'].'</td>
								<td>'.$row['numero'].'</td>
								<td>'.date("d/m/Y", strtotime($row['fecha'])).'</td>
								<td>'.$row['proveedor'].'</td>
								<td>'.$row['rut'].'</td>
								<td>'.$row['direccion'].'</td>
								<td>'.$row['ciudad'].'</td>
								<td>'.$row['cuenta'].'</td>
								<td align="right">$'.number_format($row['total'],0,',','.').'</td>
								<td align="right"></td>
								<td align="right"></td>
								<td>'.$row['observaciones'].'</td>
							</tr>
						 ';
					 }
				}
			}if($encontrar == "TODOS") {
				$encontrar ="DOCUMENTOS";
				$sql = mysqli_query($conn, "SELECT * FROM `cueta` where fecha BETWEEN '$date1' AND '$date2' ORDER BY id ASC");
				$Sql = mysqli_query($conn, "SELECT SUM(total) as total FROM `cueta` WHERE fecha BETWEEN '$date1' AND '$date2' ORDER BY id ASC ");
				$SQl = mysqli_query($conn, "SELECT SUM(neto) as neto FROM `cueta` WHERE fecha BETWEEN '$date1' AND '$date2' ORDER BY id ASC ");
				$SQL = mysqli_query($conn, "SELECT SUM(iva) as iva FROM `cueta` WHERE fecha BETWEEN '$date1' AND '$date2' ORDER BY id ASC ");
				
				if(mysqli_num_rows($sql) == 0){
					echo '<tr><td colspan="11">No hay datos. Por favor seleccione una opción</td></tr>';
				}else{
					 while($row = mysqli_fetch_assoc($sql)){
						while($Row = mysqli_fetch_array($Sql)){
							$Total = $Row['total'];
							$Total =number_format($Total,0,',','.');
						}
						while($ROw = mysqli_fetch_array($SQl)){
							$Neto = $ROw['neto'];
							$Neto =number_format($Neto,0,',','.');
						}
						while($ROW = mysqli_fetch_array($SQL)){
							$Iva = $ROW['iva'];
							$Iva =number_format($Iva,0,',','.');
						}
						 echo '
						 	<tr>
								<td>'.$row['documento'].'</td>
								<td>'.$row['numero'].'</td>
								<td>'.date("d/m/Y", strtotime($row['fecha'])).'</td>
								<td>'.$row['proveedor'].'</td>
								<td>'.$row['rut'].'</td>
								<td>'.$row['direccion'].'</td>
								<td>'.$row['ciudad'].'</td>
								<td>'.$row['cuenta'].'</td>
								<td align="right">$'.number_format($row['total'],0,',','.').'</td>
								<td align="right">$'.number_format($row['neto'],0,',','.').'</td>
								<td align="right">$'.number_format($row['iva'],0,',','.').'</td>
								<td>'.$row['observaciones'].'</td>
							</tr>
						 ';
					 }
				}
			}
			?>
		</table>
		<label>Total de <?php echo  $encontrar;?> encontradas <?php echo $resultado=mysqli_num_rows($sql);?></label><br>
		<label>Total Neto $ <?php echo $Neto;?></label><br>
		<label>Total I.V.A. $ <?php echo $Iva;?></label><br>
		<label>Por una valor Total de $ <?php echo $Total;?></label>
	</div>

</body>
</html>
<?php 
ob_end_flush(); 
?>
