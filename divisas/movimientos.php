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
		header("Location:../index.php");
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
    	<title></title>
		<script src="../js/jquery-3.6.0.js"></script>
		<script>
		$(document).ready(function () {
        	$('#oper').focus();
			$('input').keyup(function(){
				/* Obtengo el valor contenido dentro del input */
				var value = $(this).val();
				/* Elimino todos los espacios en blanco que tenga la cadena delante y detrás */
				var value_without_space = $.trim(value);
				/* Cambio el valor contenido por el valor sin espacios */
				$(this).val(value_without_space);
			});
      	});
    	</script>
		<style>
			body{
				padding: 20px;
			}
			li{
				list-style-type: none;
			}
		</style>
    </head>
<body>
	<label>Nombre del Cajero : <?php echo  $nombre; ?></label>
	<hr>
	<form action="movimientos.php" method="post" name="formulario" id="formulario">
	<table border="0" cellpadding="6" cellspacing="6" width="100%">
		<tr>
			<td>
				<label>Operación</label>
				<select class="form-control" name="oper" id="oper">
					<option value="0">-------</option>
					<option value="TODOS">TODOS</option>
					<option value="COMPRA">COMPRA</option>
					<option value="VENTA">VENTA</option>
				</select>
			</td>
			<td>
				<label>Divisa</label>
				<select class="form-control" name="divi" id="divi">
					<option value="0">-------</option>
					<option value="TODOS">TODOS</option>
					<?php
						$d=mysqli_query($conn, "SELECT * FROM `divisas` ORDER BY divisa ASC");
						while($ra=mysqli_fetch_array($d)){
							echo '
								<option value="'.$ra['divisa'].'">'.$ra['divisa'].'</option>
							';
						}					
					?>
				</select>
			</td>
			<td>
				<label>Fecha Inicio</label>
				<input type="datetime-local" class="form-control" name="date1" id="date1" >
			</td>
			<td>
				<label>Fecha Final</label>
				<input type="datetime-local" class="form-control" name="date2" id="date2" >
			</td>
			<td>
				<label>Usuario</label>
				<select class="form-control" name="user" id="user">
					<option value="0">-------</option>
					<option value="TODOS">TODOS</option>
					<?php
						$u=mysqli_query($conn, "SELECT * FROM `login` ORDER BY name ASC");
						while($ru=mysqli_fetch_array($u)){
							echo '
								<option value="'.$ru['user'].'">'.$ru['name'].'</option>
							';
						}
					?>
				</select>
			</td>
			<td>
				<label>&nbsp;</label>
				<button class="btn btn-primary" type="submit">BUSCAR</button>
			</td>
		</tr>
	</table>
	</form>
	<hr>
		<div class="table-responsive" style="font-size: 9px;">
			<table class="table table-striped table-hover" width="100%">
				<tr>
					<th>N°</th>
					<th>FECHA</th>
					<th>OPERACIÓN</th>
					<th>DIVISA</th>
					<th>MONTO</th>
					<th>TASA DE CAMBIO</th>
					<th>TOTAL</th>
					<th>CLIENTE</th>
					<th>USUARIO</th>
					<th>SALDO CAJA</th>
				</tr>
	<?php
		error_reporting(0);
		$operacion=$_POST['oper'];
		$divisa=$_POST['divi'];
        $date1 = date("Y-m-d H:i:s", strtotime($_POST['date1']));
        $date2 = date("Y-m-d H:i:s", strtotime($_POST['date2']));
		$user=$_POST['user'];
		
		if($operacion == "TODOS" && $divisa == "TODOS" && $user == "TODOS"){
			$sqli=mysqli_query($conn, "SELECT * FROM `compraventa` WHERE date BETWEEN '$date1' AND '$date2'");
		}if($operacion != "TODOS" && $divisa == "TODOS" && $user == "TODOS"){
			$sqli=mysqli_query($conn, "SELECT * FROM `compraventa` WHERE operacion = '$operacion' AND date BETWEEN '$date1' AND '$date2'");
		}if($operacion != "TODOS" && $divisa != "TODOS" && $user == "TODOS"){
			$sqli=mysqli_query($conn, "SELECT * FROM `compraventa` WHERE operacion = '$operacion' AND divisa = '$divisa' AND date BETWEEN '$date1' AND '$date2'");			
		}if($operacion != "TODOS" && $divisa != "TODOS" && $user != "TODOS"){
			$sqli=mysqli_query($conn, "SELECT * FROM `compraventa` WHERE operacion = '$operacion' AND divisa = '$divisa' AND user = '$user' AND date BETWEEN '$date1' AND '$date2'");			
		}if($operacion == "TODOS" && $divisa != "TODOS" && $user == "TODOS"){
			$sqli=mysqli_query($conn, "SELECT * FROM `compraventa` WHERE divisa = '$divisa' AND date BETWEEN '$date1' AND '$date2'");			
		}if($operacion == "TODOS" && $divisa == "TODOS" && $user != "TODOS"){
			$sqli=mysqli_query($conn, "SELECT * FROM `compraventa` WHERE user = '$user' AND date BETWEEN '$date1' AND '$date2'");		
		}if($operacion == "TODOS" && $divisa != "TODOS" && $user != "TODOS"){
			$sqli=mysqli_query($conn, "SELECT * FROM `compraventa` WHERE  divisa = '$divisa' AND user = '$user' AND date BETWEEN '$date1' AND '$date2'");				
		}
		if(mysqli_num_rows($sqli) == 0){
			echo '<tr><td colspan="10">No hay datos. Por favor seleccione una opción</td></tr>';
		}else {
			while($row = mysqli_fetch_array($sqli)){
				echo '
					<tr>
						<td>'.$row['id'].'</td>
						<td>'.date("d/m/Y H:i:s", strtotime($row['date'])).'</td>
						<td>'.$row['operacion'].'</td>
						<td>'.$row['divisa'].'</td>
						<td> $'.number_format($row['monto'], 0, ',', '.').'</td>
						<td> $'.number_format($row['tasa'], 0, ',', '.').'</td>
						<td> $'.number_format($row['total'], 0, ',', '.').'</td>
						<td>'.$row['cliente'].'</td>
						<td>'.$row['user'].'</td>
						<td> $'.number_format($row['saldocaja'], 0, ',', '.').'</td>
					</tr>
				';
			}
		}
	?>
			</table>
		</div>
		<label>Registros encontrados : <?php echo mysqli_num_rows($sqli);?></label>
	<script type="text/javascript">
		document.addEventListener("DOMContentLoaded", function() {
  		document.getElementById("formulario").addEventListener('submit', validarFormulario); 
		});

		function validarFormulario(evento) {
		  evento.preventDefault();
			oper = document.getElementById("oper").selectedIndex;
			divi = document.getElementById("divi").selectedIndex;
			user = document.getElementById("user").selectedIndex;
			
			if( oper == null || oper == 0 ) {
				alert('Seleccione un tipo de Operación.');
				document.getElementById("oper").focus();
				return false;
			}
			if( divi == null || divi == 0 ) {
				alert('Seleccione un tipo de Divisa.');
				document.getElementById("divi").focus();
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
			if( user == null || user == 0 ) {
				alert('Seleccione un usuario.');
				document.getElementById("user").focus();
				return false;
			}			
			
		  this.submit();
		}
	</script>
</body>
</html>
<?php 
ob_end_flush(); 
?>