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
<title>Buscar Patente</title>
		<script type="text/javascript">
		document.addEventListener("DOMContentLoaded", function() {
  		document.getElementById("formulario").addEventListener('submit', validarFormulario); 
		});

		function validarFormulario(evento) {
		  evento.preventDefault();
			indice = document.getElementById("filter").selectedIndex;
			if(document.getElementById("filter").value == ""){
				alert('Ingrese una patente valida');
				document.getElementById("filter").focus();
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
	<h3 class="animate__animated animate__backInLeft" id="titulo">Busqueda de Expediente por Patente Tracto.</h3>
	<br>
	<form class="form-inline" action="buscar.php" method="post" id="formulario">
		<div class="form-group">
			<label>Buscar: &nbsp;&nbsp;</label>
			<input type="text" name="filter" id="filter" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" autocomplete="off"required>
			&nbsp;&nbsp;
			<label>Fecha de Inicio: </label>&nbsp;&nbsp;
			<input type="datetime-local" class="form-control" name="date1" id="date1" >&nbsp;&nbsp;
			<label>Fecha de Termino: </label>&nbsp;&nbsp;
			<input type="datetime-local" class="form-control" name="date2" id="date2" >&nbsp;&nbsp;
			<input type="submit" value="BUSCAR" title="BUSCAR RESULTADOS">
		</div>
	</form>
	<br>
	<div class="table-responsive" style="font-size: 10px;">
    	<table class="table table-striped table-hover">
        	<tr>
            	<th>N°</th>
                <th>Tracto</th>
                <th>Semi</th>
				<th>Tipo</th>
				<th>Carga</th>
                <th>Chofer</th>
                <th>Tel&eacute;fono</th>
                <th>Observaciones</th>
                <th>Entrada</th>
                <th>User Entrada</th>
                <th>Salida</th>
                <th>User Salida</th>
                <th>$ Sistema</th>
                <th>$ Real</th>
              </tr>
    <?php
    	error_reporting(0);
		$patente=$_POST['filter'];
        
        $date1 = date("Y-m-d H:i:s", strtotime($_POST['date1']));
        $date2 = date("Y-m-d H:i:s", strtotime($_POST['date2']));
	
        $sql = mysqli_query($conn, "SELECT * FROM `ingreso` where tracto='$patente' and fecha_ingreso BETWEEN '$date1' AND '$date2' ORDER BY id ASC");
	
		$no = 1;
			
		while($row = mysqli_fetch_array($sql)){
		
			echo '

	                  <tr>
                        <td>'.$no.'</td>
                        <td>'.$row['tracto'].'</td>
                        <td>'.$row['semi'].'</td>
						<td>'.$row['tipo'].'</td>
						<td>'.$row['carga'].'</td>
                        <td style="text-transform:capitalize;">'.$row['nombre'].'</td>
                        <td>'.$row['telefono'].'</td>
                        <td>'.$row['observaciones'].'</td>
                        <td>'.date("d/m/Y H:i:s", strtotime($row['fecha_ingreso'])).'</td>
                        <td>'.$row['usuario_ingreso'].'</td>
                        <td>'.$row['fecha_salida'].'</td>
                        <td>'.$row['usuario_salida'].'</td>
                        <td>$ '.number_format($row['pago'], 0, ',', '.').'</td>
                        <td>$ '.number_format($row['cancelado'], 0, ',', '.').'</td>
                    </tr>
	
	
			';$no++;
	}
	?>
		</table>
	</div>
</body>
</html>
<?php 
ob_end_flush(); 
?>
