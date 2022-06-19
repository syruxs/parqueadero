<?php 
ob_start(); 
?>
<?php
require("../admin/conex.php");
session_start();
error_reporting(0);
date_default_timezone_set('America/Santiago');

$cliente=$_POST['cliente'];
$rut=$_POST['dni'];
$pais=$_POST['pais'];
$tel=$_POST['tel'];
$email=$_POST['email'];
$repre=$_POST['repre'];

include("edith_cliente.php");
 
if(isset($_POST['mdf'])){
	echo "<script type=\"text/javascript\">alert(\"modificar\");</script>";
}if(isset($_POST['delete'])){
	echo "<script type=\"text/javascript\">alert(\"eliminar\");</script>";
}

/*$registrar ="INSERT INTO `clientes` (`nombre`, `representante`, `doc`, `fono`, `email`, `pais`) VALUES ('$cliente', '$repre', '$rut', '$tel', '$email', '$pais')";

$insert=mysqli_query($conn, $registrar);
echo "<script type=\"text/javascript\">alert(\"El cliente ".$cliente." se ha creado exitosamente!\");</script>";
*/
mysqli_free_result($result);
mysqli_close($conn);
?>
<?php 
ob_end_flush(); 
?>