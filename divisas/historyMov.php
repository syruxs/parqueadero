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
	<form action="historyMov.php" method="post" name="formingreso" id="formingreso">
	<table width="100%" border="0" cellpadding="6" cellspacing="6">
		<tr>
			<td>
				<label>Tipo de Movimiento</label>
				<select class="form-control" name="select" id="select">
					<option value="0">---------</option>
					<option value="TODOS">TODOS</option>
					<option value="INGRESO">INGRESO</option>
					<option value="EGRESO">EGRESO</option>
				</select>
			</td>	
			<td>
				<label>Fecha Inicio</label>

				<input type="datetime-local" class="form-control" name="date1" id="date1" >
			</td>
			<td>
				<label>Fecha Final</label>

				<input type="datetime-local" class="form-control" name="date2" id="date2" >
			</td>
			<td>
				<label>Usuario</label>
				<select class="form-control" name="user" id="user">
					<option value="0">---------</option>
					<option value="TODOS">TODOS</option>
					<?php
						$UserName=mysqli_query($conn, "SELECT * FROM `login` ORDER BY name ASC");
							while($useRst=mysqli_fetch_array($UserName)){
								echo '
									<option value="'.$useRst['user'].'">'.$useRst['name'].'</option>
								';
							}
					?>
				</select>
			</td>
			<td>
				<label>&nbsp;</label>
				<button class="btn btn-primary" type="submit">BUSCAR</button>
			</td>
		</tr>
	</table>
	</form>
	<hr>
		<div class="table-responsive" style="font-size: 12px;">
			<table class="table table-striped table-hover" width="100%">
				<tr>
					<th>N°</th>
					<th>MOVIMIENTO</th>
					<th>DIVISA</th>
					<th>MONTO</th>
					<th>OBSERVACIONES</th>
					<th>USUARIO</th>
					<th>FECHA</th>
				</tr>
				<?php
				error_reporting(0);
				$Movi=$_POST['select'];
				$date1 = date("Y-m-d H:i:s", strtotime($_POST['date1']));
				$date2 = date("Y-m-d H:i:s", strtotime($_POST['date2']));
				$Name=$_POST['user'];
				
				if($Movi == "TODOS" && $Name == "TODOS"){
					$M=mysqli_query($conn, "SELECT * FROM `movimiento` WHERE date BETWEEN '$date1' AND '$date2'");
				}if($Movi == "INGRESO" && $Name == "TODOS"){
					$M=mysqli_query($conn, "SELECT * FROM `movimiento` WHERE movimiento = '$Movi' AND date BETWEEN '$date1' AND '$date2'");
				}if($Movi == "INGRESO" && $Name != "TODOS"){
					$M=mysqli_query($conn, "SELECT * FROM `movimiento` WHERE movimiento = '$Movi' AND user = '$Name' AND date BETWEEN '$date1' AND '$date2'");
				}if($Movi == "EGRESO" && $Name == "TODOS"){
					$M=mysqli_query($conn, "SELECT * FROM `movimiento` WHERE movimiento = '$Movi' AND date BETWEEN '$date1' AND '$date2'");
				}if($Movi == "INGRESO" && $Name != "TODOS"){
					$M=mysqli_query($conn, "SELECT * FROM `movimiento` WHERE movimiento  = '$Movi' AND user = '$Name' AND date BETWEEN '$date1' AND '$date2'");
				}if($Movi == "TODOS" && $Name != "TODOS"){
					$M=mysqli_query($conn, "SELECT * FROM `movimiento` WHERE user = '$Name' AND date BETWEEN '$date1' AND '$date2'");
				}
				if(mysqli_num_rows($M) == 0){
					echo '<tr><td colspan="7">No hay datos. Por favor seleccione una opción</td></tr>';
				}else {
					while($rstMov = mysqli_fetch_array($M)){
						echo '
							<tr>
								<td>'.$rstMov['id'].'</td>
								<td>'.$rstMov['movimiento'].'</td>
								<td>'.$rstMov['divisa'].'</td>
								<td> $'.number_format($rstMov['monto'], 0, ',', '.').'</td>
								<td>'.$rstMov['observacion'].'</td>
								<td>'.$rstMov['user'].'</td>
								<td>'.date("d/m/Y H:i:s", strtotime($rstMov['date'])).'</td>
							</tr>
						';
					}
				}			
				?>
			</table>
			<hr>
			<?php
			echo "Registros encontrados : ".mysqli_num_rows($M)."";
			?>
		</div>
	<script>
		$(document).ready(function () {
			$("#formingreso").submit(function () {
				if($("#select").val() == '0') {
					alert("Por favor selecione un tipo de movimiento.");
						$("#select").focus();
					return false;
				}
			}
			});
		});
	</script>
</body>
</html>
<?php 
ob_end_flush(); 
?>