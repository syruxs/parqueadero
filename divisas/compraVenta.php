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
		<script type="text/javascript">
		$(document).ready(function(){
				$("#formulario").submit(function () {
				if($("#divi").val() == "0") {
					alert("Por favor seleccione una divisa");
						$("#divi").focus();
					return false;
				}
				if($("#oper").val() == "a") {
					alert("Por favor selecciona una operación");
					$("#oper").focus();
				return false;
				}
				if($("#monto").val().length < 1) {
					alert("Por favor ingrese el monto.");
					$("#monto").focus();
				return false;
				}
				if($("#cambio").val().length < 1) {
					alert("Por favor ingrese el cambio.");
					$("#cambio").focus();
				return false;
				}
				if($("#total").val().length < 1) {
					alert("Por favor ingrese el valor correcto");
					$("#total").focus();
				return false;
				}
			});
		});
		</script>
		<style>
			body{
				padding: 20px;
			}
		</style>
    </head>
<body>
	<label>Nombre del Cajero : <?php echo  $nombre; ?></label>
	<hr>
	<form action="saveCompraVenta.php" method="post" name="formulario" id="formulario">
	<table width="100%" border="0" cellpadding="6" cellspacing="6">
		<tr>
			<td>
				<label>Divisa</label>
			</td>
			<td>
				<select class="form-control" name="divi" id="divi">
					<option value="0">---------</option>
					<?php
						$d=mysqli_query($conn, "SELECT * FROM `divisas` ORDER BY divisa ASC");
							while($r=mysqli_fetch_array($d)){
								echo '
									<option value="'.$r['divisa'].'">'.$r['divisa'].'</option>
								';
							}
					?>
				</select>
			</td>
			<td>
				<label>Tipo de Operación</label>
			</td>
			<td>
				<select class="form-control" name="oper" id="oper">
					<option value="a">--------</option>
					<option value="COMPRA">COMPRA</option>
					<option value="VENTA">VENTA</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>
				<label>Monto</label>
			</td>
			<td>
				<input type="number" class="form-control" name="monto" id="monto" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" required>
			</td>
			<td>
				<label>Tipo de Cambio</label>
			</td>
			<td>
				<input type="number" class="form-control" name="cambio" id="cambio" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"  required>
			</td>
		</tr>
		<tr>
			<td>
				<label>Cliente</label>
			</td>
			<td colspan="3">
				<input type="text" class="form-control" style="text-transform:capitalize;" name="cliente" id="cliente">
			</td>
		</tr>
		<tr>
			<td colspan="4">
				<hr>
			</td>
		</tr>
		<tr>
			<td>
				<label>Total</label>
			</td>
			<td>
				<input type="number" class="form-control" name="total" id="total" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"  required>
			</td>
			<td>Saldo Caja</td>
			<td><input type="text" class="form-control" value="" name="caja" id="caja" readonly></td>
		</tr>
	</table>
	<hr>
	<br>
 	<button class="btn btn-primary" type="submit">GUARDAR</button>
	</form>
	<script type="text/javascript">
	$(document).ready(function(){
		$('#oper').change(function(){
			if($('#divi').val() == "0"){
				alert('Primero seleccione una divisa.');
				$('#divi').focus();
			}else{
			tipoCambio();	
			}
		});
		$('#divi').change(function(){
			divisas();
		});
		$('#monto').change(function(){
			mont = +$('#monto').val();
			can = +$('#cambio').val();
			to = mont * can;
			$('#total').val(to);
			if(+$('#monto').val() > +$('#caja').val()){
				alert('El saldo en caja no es suficiente.');
			}
		});
		$('#cambio').change(function(){
			mont = +$('#monto').val();
			can = +$('#cambio').val();
			to = mont * can;
			$('#total').val(to);
		});
		function divisas(){
			$.ajax({
				type: "POST", 
				url: "divisa.php",
				data: {di: $('#divi').val()},
				success: function(d){
					$('#caja').html(d);
				}
			});
		}
		
		function tipoCambio(){
			$.ajax({
			  type: "POST",
			  url: "dat.php",
			  data: {div: $('#divi').val(), op: $('#oper').val()},
			  success: function(r){
					$('#cambio').html(r);
				}
			});
		}
	});
	</script>
</body>
</html>
<?php 
ob_end_flush(); 
?>