<?php 
ob_start(); 
?>
<?php
session_start();
error_reporting(0);
date_default_timezone_set('America/Santiago');
$ver=$_SESSION['user'];
$s=explode(',',$ver);
	if($s[0]!=""){
	}	else{
		header("Location:index.php");
		exit;
	}
    require("../admin/conex.php");

$id=$_POST['id'];
$cliente=$_POST['cliente'];
$rut=$_POST['dni'];
$pais=$_POST['pais'];
$tel=$_POST['tel'];
$email=$_POST['email'];
$repre=$_POST['repre'];

$Modificar="UPDATE `clientes` SET `nombre` = '$cliente', `representante` = '$repre', `doc` = '$rut', `fono` = '$tel', `email` = '$email', `pais` = '$pais' WHERE `id` ='$id'";
	echo "<script type=\"text/javascript\">alert(\"Los datos se han guardado exitosamente!\");</script>";
	$insertar=mysqli_query($conn, $Modificar);
	header("location:../administracion/edith_cliente.php");

mysqli_close($conn);
?>
<?php 
ob_end_flush(); 
?>