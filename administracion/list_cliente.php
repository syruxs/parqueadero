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
<title>Listado de  Cliente</title>
		<script src="../js/jquery-3.6.0.js"></script>

		<script>
		$(document).ready(function () {
			$(this).val(jQuery.trim($(this).val()));
		});
		</script>
		<style>
			body {
				padding: 20px;
			}
		#titulo{
			width: 100%;
			border-bottom: 1px solid rgb(60, 57, 57);
		}
		</style>
</head>

<body>
	<h3 class="animate__animated animate__backInLeft" id="titulo">Listado de Clientes</h3>
	<br>
	<br>
	<div class="table-responsive" style="font-size: 12px;">
		<table class="table table-striped table-hover" style="background-color: white; color: rgb(110, 108, 108);">
			<tr>
				<th>N°</th>
				<th>CLIENTE</th>
				<th>RUN/DNI</th>
				<th>PAIS</th>
				<th>TELEFONO</th>
				<th>CORREO</th>
				<th>REPRESENTANTE</th>
			</tr>
			<?php
				$B_cliente=mysqli_query($conn, "SELECT * FROM `clientes` ORDER BY nombre ASC");
			
				if(mysqli_num_rows($B_cliente) == 0){
					echo '<tr><td colspan="6">No hay datos. Por favor seleccione una opción</td></tr>';
				}else{
					$n=1;
					while($row_cliente=mysqli_fetch_array($B_cliente)){
					
					echo '
						<tr>
							<td>'.$n.'</td>
							<td>'.$row_cliente['nombre'].'</td>
							<td>'.$row_cliente['doc'].'</td>
							<td>'.$row_cliente['pais'].'</td>
							<td>'.$row_cliente['fono'].'</td>
							<td>'.$row_cliente['email'].'</td>
							<td>'.$row_cliente['representante'].'</td>
						</tr>
					';$n++;
					}
				}
			?>
			<tr></tr>
		</tabla>
	</di>
</body>
</html>
<?php 
ob_end_flush(); 
?>
