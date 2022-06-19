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
<title>Eliminar Expediente</title>
		<script src="../js/jquery-3.6.0.js"></script>
		<script>
		$(document).ready(function () {
			$(this).val(jQuery.trim($(this).val()));
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
	
	<table width="100%" border="0" cellpadding="2" cellspacing="2">
		<tr>
			<td>
				<h1 class="animate__animated animate__backInLeft" id="titulo">Eliminar Expediente</h1>
			</td>
		</tr>
		<tr>
			<td>
				<form action="delete.php" method="post" name="buscar">
				<label>Ingresar Patente: </label>
				<input type="text" title="Ingresar Patente" placeholder="PATENTE" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" required name="patente">
				<input type="submit" value="BUSCAR">
				</form>
			</td>
		</tr>
	</table>
	<?php
		$recibir=$_POST['patente'];
		$sql_recibir=mysqli_query($conn, "SELECT * FROM `ingreso` where estado='ACTIVO' and tracto='$recibir'");
		while($rs=mysqli_fetch_array($sql_recibir)){
			
			$Id=$rs['id'];
			$Tracto=$rs['tracto'];
			$Semi=$rs['semi'];
			$Tipo=$rs['tipo'];
			$Carga=$rs['carga'];
			$Name=$rs['nombre'];
			$Tel=$rs['telefono'];
			$Obs=$rs['observaciones'];
			echo '
				<br>
	<form action="delete_file.php" method="post">
	<label>Datos encontrados. Expediente N° '.$Id.'</label><input type="hidden" value="'.$Id.'" name="id">
	<table width="100%" border="0" cellpadding="2" cellspacing="2">
		<tr>
			<td>
				<label>Tracto: </label>
				<input type="text" name="trac" id="trac" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" required value="'.$Tracto.'" class="form-control">
			</td>
			<td>
				<label>Semi: </label>
				<input type="text" name="semi" id="semi" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" required value="'.$Semi.'" class="form-control">
			</td>
			<td>
				<label>Tipo: </label>
				<input type="text" name="tipo" id="tipo" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" required value="'.$Tipo.'" class="form-control">
			</td>
			<td colspan="3">
				<label>Carga: </label>
				<input type="text" name="carga" id="carga" style="text-transform:capitalize;" required value="'.$Carga.'" class="form-control">
			</td>
		</tr>
		<tr>
			<td>
				<label>Nombre del Chofer: </label>
				<input type="text" name="name" id="name" style="text-transform:capitalize;" required value="'.$Name.'" class="form-control">
			</td>
			<td>
				<label>Teléfono: </label>
				<input type="tel" name="tel" id="tel" value="'.$Tel.'" maxlength="11" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" class="form-control">
			</td>
		</tr>
		<tr>
			<td colspan="4">
				<label>Observaciones: </label>
				<input type="text" name="obs" id="obs" value="'.$Obs.'" class="form-control">
			</td>
		</tr>
	</table>
	<br>
	<input type="submit" value="ELIMINAR" title="ELIMINAR EXPEDIENTE">
	</form>
			';
		}
	?>
	
</body>
</html>
<?php 
ob_end_flush(); 
?>