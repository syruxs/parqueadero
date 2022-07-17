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
        	$('.egreso').hide();
			$('#monto').keyup(function(){
				var value = $(this).val();
				var value_without_space = $.trim(value);
				$(this).val(value_without_space);
			});
			$('#select').on('change',function(){
				var selectValor = $(this).val();
				if (selectValor == 'INGRESO') {
					$('.ingreso').show();
						$('.egreso').hide();
							$('#boton').show();
				}else {
				  $('.egreso').show();
						$('.ingreso').hide();
				}
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
	<form action="savemovimiento.php" method="post" name="formingreso" id="formingreso">
	<table width="50%" border="0" cellpadding="1" cellspacing="1">
		<tr>
			<td>
				<label>Seleccionar tipo de Movimiento:</label>
			</td>
			<td>
				<select class="form-control" name="select" id="select">
					<option value="INGRESO">INGRESO</option>
					<option value="EGRESO">EGRESO</option>
				</select>
			</td>	
		</tr>
	</table>
	<hr>
		<div class="ingreso">
			<h3>Formulario de Ingreso</h3>
		</div>
		<div class="egreso">
			<h3>Formulario de Egreso</h3>
		</div>
			<table width="100%" border="0" cellpadding="4" cellspacing="4">
				<tr>
					<td>
						<label>Seleccionar Divisa:</label>
					</td>
					<td>
						<select class="form-control" name="divisa" id="divisa">
							<option value="0">----------</option>
							<?php
								$di=mysqli_query($conn, "SELECT * FROM `divisas` ORDER BY divisa ASC");
									while($rd=mysqli_fetch_array($di)){
										echo '
											<option value="'.$rd['divisa'].'">'.$rd['divisa'].'</option>
										';
									}
							?>
						</select>
					</td>
					<td>
						<label>Saldo en Caja:</label>
					</td>
					<td>
						<input type="number" class="form-control" name="caja" id="caja" readonly>
					</td>
				</tr>
				<tr>
					<td>
						<label>Monto:</label>
					</td>
					<td>
						<input type="number" class="form-control" name="monto" id="monto" required>
					</td>
					<td colspan="2">
					</td>
				</tr>
				<tr>
					<td>
						<label>Observación</label>
					</td>
					<td colspan="3">
						<input type="text" class="form-control" name="obs" id="obs" required>
					</td>
				</tr>
			</table>
			<hr>
			<button class="btn btn-primary" type="submit" id="boton">GUARDAR</button>
			</form>
	<script>
		$(document).ready(function(){
			$('#divisa').change(function(){
				divisas();
			});
			function divisas(){
				$.ajax({
					type: "POST", 
					url: "divisa.php",
					data: {di: $('#divisa').val()},
					success: function(d){
						$('#caja').html(d);
					}
				});
			}
			$('#monto').change(function(){
				if($('#select').val() == "EGRESO"){
					if(+$('#monto').val() > +$('#caja').val()){
						alert('El saldo en caja no es suficiente.');
						$('#boton').hide();
					}		   
				}
			});
		});
	</script>
	<script type="text/javascript">
		document.addEventListener("DOMContentLoaded", function() {
  		document.getElementById("formingreso").addEventListener('submit', validarFormulario); 
		});

		function validarFormulario(evento) {
		  evento.preventDefault();
			divi = document.getElementById("divisa").selectedIndex;

			if( divi == null || divi == 0 ) {
				alert('Seleccione un tipo de Divisa.');
				document.getElementById("divisa").focus();
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