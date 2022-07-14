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
		<style>
			body{
				padding: 20px;
			}
		</style>
    </head>
<body>
	<label>Nombre del Cajero : <?php echo  $nombre; ?></label>
	<hr>
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
									<option value="'.$r['id'].'">'.$r['divisa'].'</option>
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
				<input type="text" class="form-control" name="monto" id="monto" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" maxlength="8" required>
			</td>
			<td>
				<label>Tipo de Cambio</label>
			</td>
			<td>
				<input type="text" class="form-control" name="cambio" id="cambio" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" maxlength="8" required>
			</td>
		</tr>
		<tr>
			<td>
				<label>Cliente</label>
			</td>
			<td colspan="3">
				<input type="text" class="form-control">
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
				<input type="text" class="form-control" name="total" id="total" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" maxlength="12" required>
			</td>
			<td></td>
			<td></td>
		</tr>
	</table>
	<hr>
	<br>
	<button class="btn btn-primary" type="submit">GUARDAR</button>
	<script type="text/javascript">
	$(document).ready(function(){
		$('#oper').change(function(){
			tipoCambio();
		});
		$('#monto').change(function(){
			mont = $('#monto').val();
			can = $('#cambio').val();
			to = mont * can;
			$('#total').val(to);
		});
	});
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
	</script>
</body>
</html>
<?php 
ob_end_flush(); 
?>