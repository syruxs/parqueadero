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
		<script src="../js/jquery-3.6.0.js"></script>
		<script>
		$(document).ready(function () {
			$(this).val(jQuery.trim($(this).val()));
				$('#abono').focus();
       				$('#contenedor').show('slow');
		    $("#formulario").submit(function () {
				if($("#abono").val().length < 1) {
					alert("Por favor el valor a abonar!");
						$("#abono").focus();
							return false;
				}
    		});
			$("#abono").on({
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
				if($money == "PESO CHILENO"){
					$simbol="$";
				}else{
					$simbol="USD";
				}
				if($saldo =="0"){
					echo "<script type=\"text/javascript\">alert(\"No existen saldos pendientes.\");</script>";
					echo "<script type=\"text/javascript\">window.history.back(-1);<script>";
				}
		?>
		<h3 class="animate__animated animate__backInLeft" id="titulo">Ingresar Abono</h3>
		<br>
		<form action="save_abono.php" method="post" id="formulario" name="formulario">
		<table width="100%" border="0" cellpadding="4" cellspacing="4" class="animate__animated animate__backInLeft">
			<tr>
				<td colspan="3"><label><b>Fecha : &nbsp;<?php echo $date; ?> de Expediente N° <?php echo $id_venta;?></b></label></td>
			</tr>
			<tr>
				<td>
					<label>Cliente : <?php echo $cliente;?></label>
				</td>
				<td>
					<label>Chofer : <?php echo $ch;?></label>
				</td>
				<td>
					<label>Observaciones : <?php echo $ob;?></label>
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<b>Datos del Servicio</b>
				</td>
			</tr>
			<tr>
				<td>
					<label>Servicio : <?php echo $ser; ?></label>
				</td>
				<td>
					<label>Descripción : <?php echo $des;?></label>
				</td>
				<td>
					<label>Tipo de Moneda : <?php echo $money;?></label>
				</td>
			</tr>
			<tr>
				<td>
					<label>Valor Unitario : <?php echo $simbol." ".number_format($val,0,',','.');?></label>
				</td>
				<td>
					<label>Cantidad : <?php echo $cant;?></label>
				</td>
				<td>
					<label>Sub Total : <?php echo $simbol." ".$val*$cant;?></label>
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<b>Condiciones de Pago</b>
				</td>
			</tr>
			<tr>
				<td>
					<label>Tipo de Pago : <?php echo $pago;?></label>
				</td>
				<td>
					<label>Total : <?php echo $simbol." ".number_format($total,0,',','.');?></label>
				</td>
				<td>
					<label>Saldo : <?php echo $simbol." ".number_format($saldo,0,',','.');?></label>
				</td>
			</tr>
			<tr>
				<td>
					<label>Ingresar Abono :</label>
				</td>
				<td>
					<input type="text" name="abono" id="abono" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" class="form-control" autofocus required autocomplete="off">
				</td>
				<td>
					<input type="submit" value="GUARDAR">
				</td>
				<td>
					<input type="hidden" value="<?php echo $id_venta;?>" name="id" id="id">
					<input type="hidden" value="<?php echo $saldo;?>" name="sal" id="sal">
					<input type="hidden" value="<?php echo $total;?>" name="tot" id="tot">
				</td>

			</tr>
		</table>
		</form>
	</div>
</body>
</html>
<?php 
ob_end_flush(); 
?>
