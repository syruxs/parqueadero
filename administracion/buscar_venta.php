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
<title>Buscar Venta</title>
		<script type="text/javascript">
		document.addEventListener("DOMContentLoaded", function() {
  		document.getElementById("formulario").addEventListener('submit', validarFormulario); 
		});

		function validarFormulario(evento) {
		  evento.preventDefault();
			indice = document.getElementById("filter").selectedIndex;
			i = document.getElementById("tpago").selectedIndex;
			
			if( indice == null || indice == 0 ) {
				alert('Seleccione un Cliente');
				document.getElementById("filter").focus();
				return false;
			}
			if( i == null || i == 0 ) {
				alert('Por favor seleccione un tipo de pago');
				document.getElementById("tpago").focus();
				return false;
			}
			if(document.getElementById("date1").value == false){
				alert('Seleccione la fecha de inicio');
				document.getElementById("date1").focus();
				return false;
			}
			if(document.getElementById("date2").value == false){
				alert('Seleccione la fecha de final');
				document.getElementById("date2").focus();
				return false;
			}
			if(document.getElementById("date1").value > document.getElementById("date2").value){
				alert("¡El formato es incorrecto! \n Fecha Incio NO puede ser mayor que Fecha Final");
			 	document.getElementById("date1").focus();
				return false;  
			}
		  this.submit();
		}
		
		</script>
		<script src="../js/jquery-3.6.0.js"></script>
		<script>
		$(document).ready(function () {
			$(this).val(jQuery.trim($(this).val()));
				$('#patente').focus();
			    	$('#a').click(function() {
        				$('#abono').show('slow'); 
        					//$('#bloque_info').hide(); 
    				});
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
			a {
				text-decoration: none;
			}
		</style>
</head>

<body>

	<h3 class="animate__animated animate__backInLeft" id="titulo">Busqueda de Ventas</h3>
	<br>
	<form class="form-inline" action="buscar_venta.php" method="post" id="formulario">
		<table width="100%" border="0" cellpadding="4" cellspacing="4">
			<tr>
				<td align="left">
					<label>Seleccionar Cliente</label>
					<select class="form-control" name="filter" id="filter">
						<option value="0">-------------</option>
						<option value="TODOS">TODOS</option>
						<?php
							$buscar=mysqli_query($conn, "SELECT * FROM `clientes` ORDER BY nombre ASC");
								while($rst=mysqli_fetch_array($buscar)){
								echo '
									<option value="'.$rst['nombre'].'">'.$rst['nombre'].'</option>
								';
								}
						?>
					</select>
				</td>
				<td>
					<label>Tipo de Pago</label>
					<select class="form-control" name="tpago" id="tpago">
						<option value="0">--------</option>
						<option value="TODOS">TODOS</option>
						<option value="CONTADO">CONTADO</option>
						<option value="CREDITO">CREDITO</option>
					</select>
				</td>
				<td>
					<label>Fecha Incio</label>
					<input type="datetime-local" class="form-control" name="date1" id="date1" >
				</td>
				<td>
					<label>Fecha Final</label>
					<input type="datetime-local" class="form-control" name="date2" id="date2" >
				</td>
				<td>
				<input type="submit" value="BUSCAR" title="BUSCAR RESULTADOS">
				</td>
			</tr>
		</table>
	</form>
	<br>
	<div class="table-responsive" style="font-size: 9px;">
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
		echo $Cliente=$_POST['filter'];
		echo $tPago=$_POST['tpago'];

        
        $date1 = date("Y-m-d H:i:s", strtotime($_POST['date1']));
        $date2 = date("Y-m-d H:i:s", strtotime($_POST['date2']));
	
			if($Cliente == "TODOS" && $tPago == "TODOS"){
				
				$sql = mysqli_query($conn, "SELECT * FROM `ventas` WHERE date BETWEEN '$date1' AND '$date2' ORDER BY id ASC");		
			}
			if($Cliente != "TODOS" && $tPago == "TODOS"){
				$sql = mysqli_query($conn, "SELECT * FROM `ventas` WHERE cliente='$Cliente' AND date BETWEEN '$date1' AND '$date2' ORDER BY id ASC");
			}
			if($Cliente != "TODOS" && $tPago != "TODOS"){
				$sql = mysqli_query($conn, "SELECT * FROM `ventas` WHERE cliente='$Cliente' AND pago='$tPago' AND date BETWEEN '$date1' AND '$date2' ORDER BY id ASC");				
			}
			
			/*si no existen datos*/
			
			if(mysqli_num_rows($sql) == 0){
				echo '<tr><td colspan="14">No hay datos. Por favor seleccione una opción</td></tr>';
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
