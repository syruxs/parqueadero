<?php 
ob_start(); 
?>
<?php

require("admin/conex.php");
session_start();


$id=$_POST['id'];
$obs=$_POST['obser'];
date_default_timezone_set('America/Santiago');
$date_out=date('Y-m-d H:i:s', time()); 
$user=$_SESSION['user'];
$estado="INACTIVO";
$value=$_POST['valor'];
$cancelado=$_POST['cancelado'];

require("admin/conex.php");



$consulta_semi="SELECT * FROM `ingreso` where id='$id'";
$result=mysqli_query($conn, $consulta_semi);


include("home.php");


	if(isset($_POST['save'])) { 
		if(mysqli_num_rows($result)!=0){
			$regis_salida =  "UPDATE `ingreso` SET `observaciones` = '$obs', `fecha_salida` = '$date_out', `usuario_salida` = '$user', `pago` = '$value', `cancelado` = '$cancelado',  `estado` = '$estado' WHERE `ingreso`.`id` = ".$id."";
			echo "<script type=\"text/javascript\">alert(\"El vehiculo ha sido sacado del sistema\");</script>";
			$insert=mysqli_query($conn, $regis_salida);
			echo "<script type=\"text/javascript\">alert(\"El vehiculo ha sido sacado del sistema\");</script>";
			header("location:home.php");

		}else{

			echo '<script type=\"text/javascript\">alert(\"No se ha encontrado el registro N°'.$id.'.\");</script>';
			echo '<script type=\"text/javascript\">history.back(-1);</script>';
		}
	}if(isset($_POST['change'])){
			$modificar = "UPDATE `ingreso` SET `observaciones` = '$obs' WHERE `ingreso`.`id` = ".$id."";
			echo "<script type=\"text/javascript\">alert(\"Los datos se ha guardado correctamente\");</script>";
			$insertar=mysqli_query($conn, $modificar);
			echo "<script type=\"text/javascript\">alert(\"Los datos se ha guardado correctamente\");</script>";
			header("location:home.php");
	}  




mysqli_free_result($result);
mysqli_close($conn);
?>
<?php 
ob_end_flush(); 
?>