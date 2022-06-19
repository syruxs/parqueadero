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
<title>Ingresar Cliente</title>
		<script src="../js/jquery-3.6.0.js"></script>
		<script type="text/javascript">
		document.addEventListener("DOMContentLoaded", function() {
		document.getElementById("document").addEventListener('submit', validarFormulario);
		document.getElementById("formCliente").addEventListener('submit', validForm);
		});

			function validForm(e){
				e.preventDefault();
				i = document.getElementById("Cliet").selectedIndex;
				if(i == null || i == 0){
				   alert('Seleccionar un Cliente!');
					document.getElementById('Cliet').focus();
					return false;
				   }
				 this.submit();
			}
			
			function validarFormulario(evento) {
			  evento.preventDefault();
				indice = document.getElementById("pais").selectedIndex;
				if( indice == null || indice == 0 ) {
					alert('Seleccione un Pais!');
					document.getElementById("pais").focus();
					return false;
				}
			  this.submit();
			}
		</script>
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
	<h3 class="animate__animated animate__backInLeft" id="titulo">Modificar o Eliminar Cliente</h3>
	<br>
	<br>
	<form method="post" action="edith_cliente.php" name="formCliente" id="formCliente">
		<div class="input-group" style="width:50%;">
		<label>Seleccionar Cliente</label>&nbsp;&nbsp;
		<select class="form-control" name="Cliet" id="Cliet">
			<option value="0">---------</option>
			<?php
				$Cli=mysqli_query($conn, "SELECT * FROM `clientes` ORDER BY nombre ASC");
				while($R_c=mysqli_fetch_array($Cli)){
					echo '
						<option value="'.$R_c['id'].'">'.$R_c['nombre'].'</option>
					';
				}
			?>
		</select>&nbsp;&nbsp;
		<input type="submit" value="BUSCAR" title="BUSCAR CLIENTE">
		</div>
	</form>
	<br>
	<br>
	<?php
		$IdCliente=$_POST['Cliet'];
		$B_cliente=mysqli_query($conn, "SELECT * FROM `clientes` WHERE id='$IdCliente'");
		while($row_cliente=mysqli_fetch_array($B_cliente)){
			echo '
	<form action="delete_edith_cliente.php" method="post" id="document">
		<table width="100%" border="0" cellpadding="4" cellspacing="4">
			<tr>
				<td>
					<label>Nombre del Cliente (Empresa):</label>
				</td>	
				<td>
					<input type="text" class="form-control" name="cliente" id="cliente" placeholder="Empresa" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" autocomplete="off" autofocus required value="'.$row_cliente['nombre'].'">
				</td>
				<td>
					<label>R.U.T o DNI:</label>
				</td>
				<td>
					<input type="text" name="dni" id="dni" class="form-control" placeholder="RUN o DNI de la Empresa" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" autocomplete="off" required value="'.$row_cliente['doc'].'">
				</td>
				<td>
					<label>Pais:</label>
				</td>
				<td>
					<select class="form-control" name="pais" id="pais" required>
						<option value="0">---------------</option>
						<option value="ARGENTINA">ARGENTINA</option>
						<option value="BOLIVIA">BOLIVIA</option>
						<option value="BRASIL">BRASIL</option>
						<option value="CHILE">CHILE</option>
						<option value="PARAGUAY">PARAGUAY</option>
						<option value="PERU">PERU</option>
						<option value="URUGUAY">URUGUAY</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>
					<label>Telefono:</label>
				</td>
				<td>
					<input type="tel" class="form-control" name="tel" id="tel" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" autocomplete="off" required value="'.$row_cliente['fono'].'">
				</td>
				<td>
					<label>Correo:</label>
				</td>
				<td colspan="3">
					
					<input type="text" class="form-control" name="email" id="email" style="text-transform:lowercase;" onkeyup="javascript:this.value=this.value.lowercase();" autocomplete="off" required value="'.$row_cliente['email'].'">
				</td>
			</tr>
			<tr>
				<td>
				<label>Representante:</label><input type="hidden" value="'.$row_cliente['id'].'" name="id" id="id">
				</td>
				<td colspan="5">
					<input type="text" class="form-control" name="repre" id="repre" required value="'.$row_cliente['representante'].'">
				</td>
			</tr>
			<tr>
				<td>
					<input type="submit" value="MODIFICAR" title="MODIFICAR CLIENTE">
				</td>
				<td></td>
				<td></td>
				<td>
				</td>
			</tr>
		</table>
	</form>
		';	
		}
	?>
</body>
</html>
<?php 
ob_end_flush(); 
?>
