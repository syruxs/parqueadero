<?php 
ob_start(); 
?>
<?php
require("../admin/conex.php");
session_start();

$id=$_POST['id'];
$tacto=$_POST['trac'];
$semi=$_POST['semi'];
$tipo=$_POST['tipo'];
$carga=$_POST['carga'];
$name=$_POST['name'];
$fono=$_POST['tel'];
$obs=$_POST['obs'];

$save_dates="UPDATE `ingreso` SET `tracto` = '$tacto', `semi` = '$semi', `tipo` = '$tipo', `carga` = '$carga', `nombre` = '$name', `telefono` = '$fono', `observaciones` = '$obs' WHERE `ingreso`.`id` = ".$id."";
echo "<script type=\"text/javascript\">alert(\"Los Datos se han guardado correctamente.\");</script>";
$insert=mysqli_query($conn, $save_dates);
?>
<?php 
ob_end_flush(); 
?>