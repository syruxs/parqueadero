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
<title>Ventas</title>
		<script type="text/javascript" src="../js/validar_fechas.js"></script>
		<script src="../js/jquery-3.6.0.js"></script>
		<script>
		$(document).ready(function () {
			$(this).val(jQuery.trim($(this).val()));
		});
		</script>
		<style>
		#titulo{
			width: 100%;
			border-bottom: 1px solid rgb(60, 57, 57);
		}
		</style>
</head>

<body>
	<h3 class="animate__animated animate__backInLeft" id="titulo">Resumen de Ventas por concepto de parqueadero.</h3>
	<form class="form-inline" action="ventas.php" method="post" id="formulario">
		<div class="form-group">
			<label>Seleccionar tipo: &nbsp;&nbsp;</label>
			<select class="form-control" name="filter" id="filter" required>
				<option value="0">----------</option>
				<option value="INACTIVO">INACTIVOS</option>
			</select>
			&nbsp;&nbsp;
			<label>Fecha de Inicio: </label>&nbsp;&nbsp;
			<input type="datetime-local" class="form-control" name="date1" id="date1" >&nbsp;&nbsp;
			<label>Fecha de Termino: </label>&nbsp;&nbsp;
			<input type="datetime-local" class="form-control" name="date2" id="date2" >&nbsp;&nbsp;
			<input type="submit" value="BUSCAR" title="BUSCAR RESULTADOS">
		</div>
	</form>
	<br>
    <?php
    	error_reporting(0);
		$filter=$_POST['filter'];
        
        $date1 = date("Y-m-d H:i:s", strtotime($_POST['date1']));
        $date2 = date("Y-m-d H:i:s", strtotime($_POST['date2']));
	
	if($filter=="ACTIVO"){
		
	}if($filter=="INACTIVO"){
		$DATE_X="fecha_salida";

        $sql = mysqli_query($conn, "SELECT * FROM `ingreso` where estado='$filter' and $DATE_X BETWEEN '$date1' AND '$date2' ORDER BY id ASC");
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
		$date_in=date("d/m/Y H:i:s", strtotime($date1));
		$date_out=date("d/m/Y H:i:s", strtotime($date2));
	?>
	<b><label><?php echo mysqli_num_rows($sql);?> Registros encontrados, entre las fechas desde : <?php echo $date_in; ?> y la fecha hasta : <?php echo $date_out;?></label></b><br>
	<label>Valor Sistema: <?php echo "$ ".$V_sistem."" ?></label><br>
	<b><label>Valor Total: <?php echo "$ ".$V_cancelado.""?></label></b><br>
	<label>Difrencia : <?php echo "$ ".$diferencia.""?></label>
	<?php
	}if($filter=="TODOS"){
		
	}
	?>
</body>
</html>
<?php 
ob_end_flush(); 
?>
