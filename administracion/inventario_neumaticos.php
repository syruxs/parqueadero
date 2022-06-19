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
<title>Inventario Neumaticos</title>
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
	<h3 class="animate__animated animate__backInLeft" id="titulo">Inventario Neumaticos</h3>
	<br>
		<div class="table-responsive" style="font-size: 12px;">
    		<table class="table table-striped table-hover" style="background-color: white; color: rgb(110, 108, 108);">
				<tr>
					<th>N°</th>
					<th>MODELO</th>
					<th>MARCA</th>
					<th>STOCK</th>
					<th>VALOR COMPRA</th>
					<th>VALOR VENTA</th>
				</tr>
				<?php
				error_reporting(0);
				$s_tire=mysqli_query($conn, "SELECT * FROM `tire`");
					$n=1;
					while($r=mysqli_fetch_array($s_tire)){
						echo '
							<tr>
								<td>'.$n.'</td>
								<td>'.$r['modelo'].'</td>
								<td>'.$r['marca'].'</td>
								<td>'.$r['stock'].'</td>
								<td>'.number_format($r['valorCompra'],0,',','.').'</td>
								<td>'.number_format($r['valorVenta'],0,',','.').'</td>
							</tr>
						';$n++;
					}
				?>
				
			</table>
		</div>
</body>
</html>
<?php 
ob_end_flush(); 
?>
