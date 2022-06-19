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
<title>Abono</title>
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
       				$('#contenedor').show('slow'); 
		});
		</script>
		<style>
			body {
				background-color: rgba(255, 255, 255, 0.850);
				padding: 20px;
			}
			#titulo{
				width: 100%;
				border-bottom: 1px solid rgb(60, 57, 57);
			}			
			#contenedor{
				position: absolute;
				padding: 0px;
				margin: 0px;
				width: 90%;
				height: 100vh;
				display: none;
				top: 0px;
			}
		</style>
</head>

<body>
	<div id="contenedor">
		<?php
			$id_venta=$_GET['var'];
			$b_cli=mysqli_query($conn, "SELECT * FROM `ventas` WHERE id='$id_venta'");
			while($result=mysqli_fetch_array($b_cli)){
				$date=date("d-m-Y H:i:s", strtotime($result['date']));
				$cliente=$result['cliente'];
				$ch=$result['chofer'];
				$ob=$result['observaciones'];
				$ser=$result['servicio'];
				$des=$result['descripcion'];
				$val=$result['valor'];
				$cant=$result['cantidad'];
				$pago=$result['pago'];
				$money=$result['moneda'];
				$total=$result['total'];
				$abono=$result['abono'];
				$saldo=$result['saldo'];
			}
		?>
		<h3 class="animate__animated animate__backInLeft" id="titulo">Ingresar Abono</h3>
		<br>
		<table width="100%" border="1" cellpadding="4" cellspacing="4" class="animate__animated animate__backInLeft">
			<tr>
				<td><label>Fecha : &nbsp;<?php echo $date; ?> de Expediente N° <?php echo $id_venta;?></label></td>
			</tr>
			<tr>
				<td>
					<label>Cliente : <?php echo $cliente;?></label>
				</td>
				<td>
					<label>RUT o DNI : <?php echo ?></label>
				</td>
			</tr>
		</table>
	</div>
</body>
</html>
<?php 
ob_end_flush(); 
?>
