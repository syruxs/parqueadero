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
<title>Registro de Ventas</title>
		<script src="../js/jquery-3.6.0.js"></script>
		<script type="text/javascript">
		document.addEventListener("DOMContentLoaded", function() {
		document.getElementById("form").addEventListener('submit', validarFormulario); 
		abo.style.display="none";
		});
			function validarFormulario(evento) {
			  evento.preventDefault();
				indice = document.getElementById("model").selectedIndex;
				ser = document.getElementById("servicio").selectedIndex;
				pag = document.getElementById("pago").selectedIndex;
				money = document.getElementById("tipo-moneda").selectedIndex;
				
				if(document.getElementById("date").value == false){
					alert('Seleccione la fecha');
					document.getElementById("date").focus();
					return false;
				}
				if( indice == null || indice == 0 ) {
					alert('Seleccione un cliente por favor.');
					document.getElementById("model").focus();
					return false;
				}
				if( ser == null || ser == 0 ) {
					alert('Seleccione un servicio a prestar. \nSi la venta corresponde a neumaticos. \nNo olvide seleccionar un modelo de nuematico.');
					document.getElementById("servicio").focus();
					return false;
				}
				if(document.getElementById("valorunitario").value == false){
					alert('Ingrese el valor unitario del servicio o producto.');
					document.getElementById("valorunitario").focus();
					return false;
				}
				if(document.getElementById("stock").value == false){
					alert('Ingrese la cantidad de servicios.');
					document.getElementById("stock").focus();
					return false;
				}
				if( pag == null || pag == 0 ) {
					alert('Seleccione una forma de pago.');
					document.getElementById("pago").focus();
					return false;
				}
				if( money == null || money == 0 ) {
					alert('Seleccione un tipo de cambio.');
					document.getElementById("tipo-moneda").focus();
					return false;
				}
				if(document.getElementById("valorTotal").value == false){
					alert('El valor total no puede esta vacio.');
					document.getElementById("valorTotal").focus();
					return false;
				}
			  this.submit();
			}
		function selectServicio(o){
			const s = document.querySelector(".tipoSelector");
			
			if (o.value=="VENTA NEUMATICOS"){
				neumaticos.style.display="none";
				neumaticos2.style.display="block";
			}else{
				neumaticos2.style.display="none";
				neumaticos.style.display="block";
			}
		}
		function selectPago(n){
			const se = document.querySelector(".tipoSelector");
			
			if (n.value=="CREDITO"){
				abo.style.display="block";
	
			}else{
				abo.style.display="none";
			}
		}
		</script>
		<script>
		$(document).ready(function () {
			
			$(this).val(jQuery.trim($(this).val()));
			$('#abono').hide();
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
			$("#abo").on({
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
	<h3 class="animate__animated animate__backInLeft" id="titulo">Registrar Ventas y Servicios</h3>
	<br>
	<form action="save_venta.php" method="post" name="form" id="form">
	<label id="titulo"><b>Datos Generales</b></label>
	<table width="100%" border="0" cellpadding="4" cellspacing="4">
		<tr>
			<td>
				<label>Fecha:</label>
			</td>
			<td>
				<input type="datetime-local" name="date" id="date" class="form-control">
			</td>
			<td>
				<label>Cliente:</label>
			</td>
			<td>
				<select name="model" id="model" class="form-control">
					<option value="0">----------</option>
					<?php
					$Cliente=mysqli_query($conn, "SELECT * FROM `clientes` ORDER BY nombre ASC");
					while($result_Cliente=mysqli_fetch_array($Cliente)){
						echo '
							<option value="'.$result_Cliente['nombre'].'">'.$result_Cliente['nombre'].'</option>
						';
					}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td>
				<label>Chofer:</label>
			</td>
			<td>
				<input type="text" placeholder="Nombre Chofer" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" name="chofer" id="chofer" class="form-control">
			</td>
			<td>
				<label>Observacion:</label>
			</td>
			<td>
				<input type="text" name="obs" id="obs" class="form-control" autocomplete="off" placeholder="Solo si es necesario.">
			</td>
		</tr>
	</table>
	<label id="titulo"><b>Datos del Servicio</b></label>
	<table width="100%" border="0" cellpadding="4" cellspacing="4">
		<tr>
			<td>
				<label>Servicio:</label>
			</td>
			<td>
				<select class="form-control" name="servicio" id="servicio" onclick="selectServicio(this)">
					<option value="0">----------------</option>
					<option value="COBRO DE VALORES">COBRO DE VALORES</option>
					<option value="ESTADIA PARQUEADERO">ESTADIA PARQUEADERO</option>
					<option value="GOMERIA">GOMERIA</option>
					<option value="PRESTAMO DE DINERO">PRESTAMO DE DINERO</option>
					<option value="VENTA NEUMATICOS">VENTA NEUMATICOS</option>
					<option value="OTROS">OTROS</option>
				</select>
			</td>
			
			<td>
				<label>Descripcion:</label>
			</td>
			<td>
				<div id="neumaticos" style="display: none;">
				<input type="text" placeholder="Descripcion" name="decrip" id="decrip" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
				</div>
				<div id="neumaticos2">
				<select class="form-control" name="neuma" id="neuma">
					<option value="0">------------</option>
					<?php
						$sN=mysqli_query($conn, "SELECT * FROM `tire` ORDER BY modelo ASC");
						while($rN=mysqli_fetch_array($sN)){
							echo '
								<option value="'.$rN['id'].'">'.$rN['modelo'].' '.$rN['marca'].'</option>
							';
						}
					?>
				</select>
				</div>
			</td>
		</tr>
		<tr>
			<td>
				<label>Valor Unitario:</label>
			</td>
			<td>
				<div id="precio">
				
				</div>
				<div id="precio-valor">
				<input type="text" placeholder="Valor Unitario" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" name="valorunitario" id="valorunitario" class="form-control" autocomplete="off">
				</div>
			</td>
			<td>
				<label>Cantidad:</label>
			</td>
			<td>
				<input type="text" placeholder="Ingrese Cantidad" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" name="stock" id="stock" class="form-control" autocomplete="off">
			</td>
		</tr>
		<tr>
			<td>
			<label>Sub Total $</label>
			</td>
			<td>
			<input type="text" class="form-control" name="subTotal" id="subTotal" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">
			</td>
			<td colspan="2"></td>
		</tr>
		</table>
		<br>
		<label id="titulo">Condicione de Pago:</label>
		<table width="100%" border="0" cellpadding="4" cellspacing="4">
			<tr>
				<td>
					<label>Tipo de Pago</label>
				</td>
				<td>
					<select class="form-control" name="pago" id="pago" onclick="selectPago(this)">
						<option value="0">----------</option>
						<option value="CONTADO">CONTADO</option>
						<option value="CREDITO">CREDITO</option>
					</select>
				</td>
				<td>
					<label>Tipo de Moneda</label>
				</td>
				<td>
				<select name="tipo-moneda" id="tipo-moneda" class="form-control">
					<option value="0">---------------</option>
					<?php
						$sql_buscar_moneda=mysqli_query($conn , "SELECT * FROM `moneda` ORDER BY moneda ASC");
						while($r=mysqli_fetch_array($sql_buscar_moneda)){
							echo '
								<option value="'.$r['id'].'">'.$r['moneda'].'</option>
							';
						}
					?>
				</select>					
				</td>
				<td>
					<label>Total</label>
				</td>
				<td>
					<div id="togeneral"></div>
				</td>
			</tr>
			<tr>
				<td>
					<label>Abono:</label>
				</td>
				<td>
					<input type="text" name="abo" id="abo" class="form-control" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">
				</td>
				<td colspan="4"></td>
			</tr>
			<tr>
				<td>
					<input type="submit" value="GUARDAR" title="GUARDAR REGISTRO">
				</td>
			</tr>
		</table>
	</form>

<script type="text/javascript">
	$(document).ready(function(){
		$('#neuma').val(0);
			recargarLista();

		$('#neuma').change(function(){
			recargarLista();
			$('#precio-valor').hide();
		});
		$('#tipo-moneda').change(function(){
			tipoCambio();
		});
		$('#stock').change(function(){
			valor = $('#valorunitario').val();
			cantidad = $('#stock').val();
			total = valor * cantidad;
			$('#subTotal').val(total);
		});
	})
</script>
<script type="text/javascript">
	function recargarLista(){
		$.ajax({
		  type: "POST",
		  url: "datos.php",
		  data: "service=" + $('#neuma').val(),
		  success: function(r){
				$('#precio').html(r);
			}
		});
	}
	function tipoCambio(){
		$.ajax({
		  type: "POST",
		  url: "date.php",
		  data: {ser: $('#tipo-moneda').val(), subTotal: $('#subTotal').val(), tipo: $('#servicio').val()},
		  success: function(r){
				$('#togeneral').html(r);
			}
		});
	}
</script>
</body>
</html>
<?php 
ob_end_flush(); 
?>
