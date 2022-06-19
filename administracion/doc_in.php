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
<title>Ingresar Documentos</title>
		<script src="../js/jquery-3.6.0.js"></script>
		<script src="../js/validar_rut.js"></script>
		<script type="text/javascript">
		document.addEventListener("DOMContentLoaded", function() {
		document.getElementById("document").addEventListener('submit', validarFormulario); 
		
		});

			function validarFormulario(evento) {
			  evento.preventDefault();
				indice = document.getElementById("select").selectedIndex;
				if( indice == null || indice == 0 ) {
					alert('Seleccione una opcion');
					customAlert.alert('Seleccione una opcion. Entre Facura o Boleta' ,'Mensaje!');
					document.getElementById("select").focus();
					return false;
				}
			  this.submit();
			}
		</script>
		<script>
		$(document).ready(function () {
			$(this).val(jQuery.trim($(this).val()));
			$("#total").on({
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
			$("#neto").on({
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
			$("#iva").on({
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
		#titulo{
			width: 100%;
			border-bottom: 1px solid rgb(60, 57, 57);
		}
		</style>
</head>

<body>
	<h3 class="animate__animated animate__backInLeft" id="titulo">Ingresar Documentos</h3>
	<form class="form-inline" action="doc_in.php" method="post" id="document">
		<div class="form-group">
			<label>Seleccionar tipo de Documento: &nbsp;&nbsp;</label>
			<select class="form-control" name="select" id="select" required>
				<option value="0">----------</option>
				<option value="FACTURA">FACTURA</option>
				<option value="BOLETA">BOLETA</option>
				<option value="OTROS">OTROS</option>
			</select>
			&nbsp;&nbsp;
			<input type="submit" value="SELECCIONAR" title="SELECCIONAR UN TIPO DE DOCUMENTO">
		</div>
	</form>
	<br>
	<?php
	 error_reporting(1);
	$encontrar=$_POST['select'];
	
	echo "Tipo de documento a ingresar : ".$encontrar."";
	if($encontrar == "FACTURA") {

	?>
	<form action="save_doc.php" method="post" id="save_fac">
	<br>
	<br><input type="hidden" value="<?php echo $encontrar; ?>" name="doc" id="doc">
	<table width="100%" border="0" cellpadding="2" cellspacing="2">
		<tr>
			<td width="20%">
				<label>Fecha de la <?php echo $encontrar;?> : </label>
			</td>
			<td width="30%">
				<input type="date" name="date" id="date" class="form-control" required>
			</td>
			<td>
				<label>N° de la <?php echo $encontrar;?> : </label>
			</td>
			<td>
				<input type="number" name="folio" id="folio" class="form-control" placeholder="N° documento" required>
			</td>
		</tr>
		<tr>
			<td width="20%">
				<label>Nombre del Proveedor:</label>
			</td>
			<td width="30%">
				<input type="text" placeholder="Proveedor" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" required name="proveedor" id="proveedor" class="form-control">
			</td>
			<td>
				<label>R.U.T. del Proveedor:</label>
			</td>
			<td>
				<input type="text" placeholder="Ingrese sin puntos ni guion" onkeypress="return soloRUT(event);" onblur="formatearRut('rut');" maxlength="14" name="rut" id="rut" class="form-control" required>
			</td>
		</tr>
		<tr>
			<td>
				<label>Direccion:</label>
			</td>
			<td>
				<input type="text" class="form-control" name="direccion" id="direccion" required>
			</td>
			<td>
				<label>Ciudad:</label>
			</td>
			<td>
				<input type="text" class="form-control" name="city" id="city" style="text-transform:capitalize;" required>
			</td>
		</tr>
		<tr>
			<td>
				<label>Seleccione tipo de cuenta:</label>
			</td>
			<td>
				<select class="form-control" id="cuenta" name="cuenta" required>
					<option value="0">-----------------</option>
					<option value="GASTOS DE OFICINA">GASTOS DE OFICINA</option>
					<option value="GASTOS DE ASEO">GASTOS DE ASEO</option>
					<option value="GASTOS COMUNES">GASTOS COMUNES</option>
					<option value="GASTOS FIJOS">GASTOS FIJOS</option>
					<option value="GASTOS OPERATIVOS">GASTOS OPERATIVOS</option>
					<option value="GASTOS RRHH">GASTOS RRHH</option>
				</select>
			</td>
			<td>
				<label>Total del documento:</label>
			</td>
			<td>
				<input type="text" name="total" id="total" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" class="form-control" required> 
			</td>
		</tr>
		<tr>
			<td>
				<label>Valor Neto:</label>
			</td>
			<td>
				<input type="text" class="form-control" name="neto" id="neto" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" required>
			</td>
			<td>
				<label>I.V.A.</label>
			</td>
			<td>
				<input type="text" class="form-control" name="iva" id="iva" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" required>
			</td>
		</tr>
		<tr>
			<td>
				<label>Observaciones:</label>
			</td>
			<td colspan="3">
			<input type="text" name="observa" id="observa" class="form-control">
			</td>
		</tr>
		<tr>
			<td>
			<input type="submit" value="GUARDAR" title="GUARDAR DATOS" name="factura">
			</td>
		</tr>
	</table>
	</form>
	<?php
	}if($encontrar == "BOLETA") {
	?>
	<form action="save_doc.php" method="post" id="save_fac">
	<br>
	<br><input type="hidden" value="<?php echo $encontrar; ?>" name="doc" id="doc">
	<table width="100%" border="0" cellpadding="2" cellspacing="2">
		<tr>
			<td width="20%">
				<label>Fecha de la <?php echo $encontrar;?> : </label>
			</td>
			<td width="30%">
				<input type="date" name="date" id="date" class="form-control" required>
			</td>
			<td>
				<label>N° de la <?php echo $encontrar;?> : </label>
			</td>
			<td>
				<input type="number" name="folio" id="folio" class="form-control" placeholder="N° documento" required>
			</td>
		</tr>
		<tr>
			<td>
				<label>Seleccione tipo de cuenta:</label>
			</td>
			<td>
				<select class="form-control" id="cuenta" name="cuenta" required>
					<option value="0">-----------------</option>
					<option value="GASTOS DE OFICINA">GASTOS DE OFICINA</option>
					<option value="GASTOS DE ASEO">GASTOS DE ASEO</option>
					<option value="GASTOS COMUNES">GASTOS COMUNES</option>
					<option value="GASTOS FIJOS">GASTOS FIJOS</option>
					<option value="GASTOS OPERATIVOS">GASTOS OPERATIVOS</option>
					<option value="GASTOS RRHH">GASTOS RRHH</option>
				</select>
			</td>
			<td>
				<label>Total del documento:</label>
			</td>
			<td>
				<input type="text" name="total" id="total" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" class="form-control" required> 
			</td>
		</tr>
		<tr>
			<td>
				<label>Observaciones:</label>
			</td>
			<td colspan="3">
			<input type="text" name="observa" id="observa" class="form-control">
			</td>
		</tr>
		<tr>
			<td>
			<input type="submit" value="GUARDAR" title="GUARDAR DATOS" name="boleta">
			</td>
		</tr>
	</table>
	</form>
	<?php
	}if($encontrar == "OTROS") {
	?>
	<form action="save_doc.php" method="post" id="save_fac">
	<br>
	<br><input type="hidden" value="<?php echo $encontrar; ?>" name="doc" id="doc">
	<table width="100%" border="0" cellpadding="2" cellspacing="2">
		<tr>
			<td width="20%">
				<label>Fecha de la <?php echo $encontrar;?> : </label>
			</td>
			<td width="30%">
				<input type="date" name="date" id="date" class="form-control" required>
			</td>
			<td>
				<label>N° de la <?php echo $encontrar;?> : </label>
			</td>
			<td>
				<input type="number" name="folio" id="folio" class="form-control" placeholder="N° documento" required>
			</td>
		</tr>
		<tr>
			<td width="20%">
				<label>Nombre del Proveedor:</label>
			</td>
			<td width="30%">
				<input type="text" placeholder="Proveedor" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" required name="proveedor" id="proveedor" class="form-control">
			</td>
			<td>
				<label>R.U.T. del Proveedor:</label>
			</td>
			<td>
				<input type="text" placeholder="Ingrese sin puntos ni guion" onkeypress="return soloRUT(event);" onblur="formatearRut('rut');" maxlength="14" name="rut" id="rut" class="form-control" required>
			</td>
		</tr>
		<tr>
			<td>
				<label>Direccion:</label>
			</td>
			<td>
				<input type="text" class="form-control" name="direccion" id="direccion" required>
			</td>
			<td>
				<label>Ciudad:</label>
			</td>
			<td>
				<input type="text" class="form-control" name="city" id="city" style="text-transform:capitalize;" required>
			</td>
		</tr>
		<tr>
			<td>
				<label>Seleccione tipo de cuenta:</label>
			</td>
			<td>
				<select class="form-control" id="cuenta" name="cuenta" required>
					<option value="0">-----------------</option>
					<option value="GASTOS DE OFICINA">GASTOS DE OFICINA</option>
					<option value="GASTOS DE ASEO">GASTOS DE ASEO</option>
					<option value="GASTOS COMUNES">GASTOS COMUNES</option>
					<option value="GASTOS FIJOS">GASTOS FIJOS</option>
					<option value="GASTOS OPERATIVOS">GASTOS OPERATIVOS</option>
					<option value="GASTOS RRHH">GASTOS RRHH</option>
				</select>
			</td>
			<td>
				<label>Total del documento:</label>
			</td>
			<td>
				<input type="text" name="total" id="total" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" class="form-control" required> 
			</td>
		</tr>
		<tr>
			<td>
				<label>Observaciones:</label>
			</td>
			<td colspan="3">
			<input type="text" name="observa" id="observa" class="form-control">
			</td>
		</tr>
		<tr>
			<td>
			<input type="submit" value="GUARDAR" title="GUARDAR DATOS" name="otros">
			</td>
		</tr>
	</table>
	</form>
	<?php
	}
	?>
</body>
</html>
<?php 
ob_end_flush(); 
?>
