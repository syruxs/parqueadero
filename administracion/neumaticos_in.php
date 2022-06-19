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
<title>Ingresar Neumaticos</title>
		<script src="../js/jquery-3.6.0.js"></script>
		<script type="text/javascript">
		document.addEventListener("DOMContentLoaded", function() {
		document.getElementById("form").addEventListener('submit', validarFormulario); 
		document.getElementById("form-moneda").addEventListener('submit', validFormulario); 
		});

			function validarFormulario(evento) {
			  evento.preventDefault();
				indice = document.getElementById("model").selectedIndex;
				if( indice == null || indice == 0 ) {
					alert('Seleccione un modelo de neumatico');
					document.getElementById("model").focus();
					return false;
				}
			  this.submit();
			}
			function validFormulario(e) {
			  e.preventDefault();
				i = document.getElementById("select-moneda").selectedIndex;
				if( i == null || i == 0 ) {
					alert('Seleccione un tipo de moneda');
					document.getElementById("select-moneda").focus();
					return false;
				}
			  this.submit();
			}			
		</script>
		<script>
		$(document).ready(function () {
			$(this).val(jQuery.trim($(this).val()));
			$("#venta").on({
				"focus": function (event) {
					$(event.target).select();
				},
				"keyup": function (event) {
					$(event.target).val(function (index, value ) {
						return value.replace(/\D/g, "")
									.replace(/([0-9])([0-9]{0})$/, '$1')
									.replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ".");
					});
				}
			});
			$("#compra").on({
				"focus": function (event) {
					$(event.target).select();
				},
				"keyup": function (event) {
					$(event.target).val(function (index, value ) {
						return value.replace(/\D/g, "")
									.replace(/([0-9])([0-9]{0})$/, '$1')
									.replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ".");
					});
				}
			});
			$("#moneda").on({
				"focus": function (event) {
					$(event.target).select();
				},
				"keyup": function (event) {
					$(event.target).val(function (index, value ) {
						return value.replace(/\D/g, "")
									.replace(/([0-9])([0-9]{0})$/, '$1')
									.replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ".");
					});
				}
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
		</style>
</head>

<body>
	<h3 class="animate__animated animate__backInLeft" id="titulo">Ingresar Neumaticos</h3>
	<br>
	<form action="save_tire.php" method="post" id="form">
	<table width="50%" border="0" cellpadding="4" cellspacing="4">
		<tr>
			<td>
				<label>Seleccionar Modelo:</label>
			</td>
			<td>
				<select name="model" id="model" class="form-control">
					<option value="0">----------</option>
					<?php
					$seach_tire=mysqli_query($conn, "SELECT DISTINCT modelo FROM `tire`");
					while($result=mysqli_fetch_array($seach_tire)){
						echo '
							<option value="'.$result['modelo'].'">'.$result['modelo'].'</option>
						';
					}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td>
				<label>Marca:</label>
			</td>
			<td>
				<input type="text" placeholder="Ingrese Marca" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" name="marca" id="marca" required class="form-control">
			</td>
		</tr>
		<tr>
			<td>
				<label>Cantidad:</label>
			</td>
			<td>
				<input type="text" placeholder="Ingrese Cantidad" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" name="stock" id="stock" class="form-control" required>
			</td>
		</tr>
		<tr>
			<td>
				<label>Valor Compra:</label>
			</td>
			<td>
				<input type="text" placeholder="$ Compra" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" name="compra" id="compra" class="form-control" required>
			</td>
		</tr>
		<tr>
			<td>
				<label>Varlor Venta:</label>
			</td>
			<td>
				<input type="text" placeholder="$ Venta" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" name="venta" id="venta" class="form-control" required>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="right">
				<input type="submit" value="GUARDAR">
			</td>
		</tr>
	</table>
	</form>
	<br>
	<br>
	<form action="newtire.php" method="post">
		<table width="70%" border="0" cellpadding="4" cellspacing="4">
			<tr>
				<td>
					<label>Ingresar Modelo:</label>
				</td>
				<td>
					<input type="text" class="form-control" name="tireNew" id="tireNew" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" required>
				</td>
				<td>
					<input type="submit" value="GUARDAR" title="GUARDAR MODELO DE NEUMATICO">
				</td>
			</tr>
		</table>
	</form>
	<br>
	<br>
	<form action="save_moneda.php" method="post" id="form-moneda">
	<table width="70%" border="0" cellpadding="4" cellspacing="4">
		<tr>
			<td>
				<label>Valores de los Tipos de Cambio:</label>
			</td>
			<td>
				<select class="form-control" name="select-moneda" id="select-moneda">
					<option value="0">-------------</option>
					<option value="DOLAR">DOLAR</option>
					<option value="PESO ARGENTINO">PESO ARGENTINO</option>
					<option value="REAL">REAL</option>
				</select>
			</td>
			<td>
				<input type="text" placeholder="Tipo de cambio" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" name="moneda" id="moneda" class="form-control" required>
			</td>
			<td>
				<input type="submit" value="GUARDAR">
			</td>
		</tr>
	</table>
	</form>
</body>
</html>
<?php 
ob_end_flush(); 
?>
