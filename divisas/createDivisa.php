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
			li{
				list-style-type: none;
			}
		</style>
    </head>
<body>
	<label>Nombre del Cajero : <?php echo  $nombre; ?></label>
	<hr>
	<form action="saveDivisas.php" method="post">
		<div class="input-group">
			<label>Nombre de la Divisa a crear : &nbsp;</label>
			<input type="text" title="Ingresar Divisa" placeholder="Nombre divisa" class="form-control" id="name" name="name" autofocus style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" required>&nbsp;
			<button class="btn btn-primary" type="submit">GUARDAR</button>
		</div>
	</form>
		<hr>
		<b><label>DIVISAS YA INGRESADAS</label></b>
		<ul>
			<?php
				$divi=mysqli_query($conn, "SELECT * FROM `divisas` ORDER BY divisa ASC");
				while($result=mysqli_fetch_array($divi)){
					echo '
						<li>'.$result['divisa'].'</li>
					';
				}
			?>
		</ul>
</body>
</html>
<?php 
ob_end_flush(); 
?>