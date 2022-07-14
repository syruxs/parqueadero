<?php 
ob_start(); 
?>
<?php
error_reporting(0);
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
        	$('#name').focus();
		$('input').keyup(function(){
			/* Obtengo el valor contenido dentro del input */
			var value = $(this).val();
			/* Elimino todos los espacios en blanco que tenga la cadena delante y detrás */
			var value_without_space = $.trim(value);
			/* Cambio el valor contenido por el valor sin espacios */
			$(this).val(value_without_space);
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
	<b><label>Tasa de Cambio</label></b>
	<marquee>
	<?php
		$apiUrl = 'https://mindicador.cl/api';
		//Es necesario tener habilitada la directiva allow_url_fopen para usar file_get_contents
		if ( ini_get('allow_url_fopen') ) {
			$json = file_get_contents($apiUrl);
		} else {
			//De otra forma utilizamos cURL
			$curl = curl_init($apiUrl);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			$json = curl_exec($curl);
			curl_close($curl);
		}
 
		$dailyIndicators = json_decode($json);
		echo 'UF es $' . $dailyIndicators->uf->valor.'&nbsp;&nbsp;';
		echo 'Dólar observado $' . $dailyIndicators->dolar->valor.'&nbsp;&nbsp;';
		echo 'Dólar acuerdo $' . $dailyIndicators->dolar_intercambio->valor.'&nbsp;&nbsp;';
		echo 'Euro $' . $dailyIndicators->euro->valor.'&nbsp;&nbsp;';
		//echo 'El valor actual del IPC es ' . $dailyIndicators->ipc->valor;
		echo 'UTM $' . $dailyIndicators->utm->valor.'&nbsp;&nbsp;';
		//echo 'El valor actual del IVP es $' . $dailyIndicators->ivp->valor;
		//echo 'El valor actual del Imacec es ' . $dailyIndicators->imacec->valor;
	?>
	</marquee>
		<div class="table-responsive" style="font-size: 12px;">
			<table class="table table-striped table-hover">
				<tr>
					<th>N°</th>
					<th>DIVISA</th>
					<th>TASA COMPRA</th>
					<th>TASA VENTA</th>
					<th></th>
				</tr>
				<?php
					$div=mysqli_query($conn, "SELECT * FROM `divisas` ORDER BY divisa ASC");
					$n= 1;
						while($rst=mysqli_fetch_array($div)){
							echo '
								<form action="saveTasaCambio.php" method="post">
									<tr>
										<td>'.$n.'<input type="hidden" value="'.$rst['id'].'" name="id"></td>
										<td>'.$rst['divisa'].'</td>
										<td><input type="text" value="'.$rst['compra'].'" name="compra" autocomplete="off" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" required></td>
										<td><input type="text" value="'.$rst['venta'].'" name="venta" autocomplete="off" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" required></td>
										<td><button class="btn btn-primary" type="submit">GUARDAR</button</td>
									</tr>
								</form>
							';$n++;
						}
				?>
			</table>
		</div>
</body>
</html>
<?php 
ob_end_flush(); 
?>