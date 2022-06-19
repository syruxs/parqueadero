<?php 
ob_start(); 
?>
<?php

require("../admin/conex.php");
session_start();
error_reporting(0);

$modelo=$_POST['model'];
$marca=$_POST['marca'];
$stock=$_POST['stock'];
$vCompra=$_POST['compra'];
$vCompra=trim(str_replace(array('-','.'), '', $vCompra));
$vVenta=$_POST['venta'];
$vVenta=trim(str_replace(array('-','.'), '', $vVenta));

include("neumaticos_in.php");
if(mysqli_num_rows($sql) == 0){}


$B_tire=mysqli_query($conn, "SELECT * FROM `tire` WHERE `modelo`='$modelo' AND `marca`='$marca'");

while($rs=mysqli_fetch_array($B_tire)){
	$Stock=$rs['stock'];
	$STOCK=$Stock+$stock;
}

if(mysqli_num_rows($B_tire) == 0){
	$guardar ="INSERT INTO `tire` (`modelo`, `marca`, `stock`, `valorCompra`, `valorVenta`) VALUES ('$modelo', '$marca', '$stock', '$vCompra', '$vVenta')";
	$insertar=mysqli_query($conn, $guardar);
	echo "<script type=\"text/javascript\">alert(\"Los datos se han guardado correctamente\");</script>";
}else{
	$edith_tire="UPDATE `tire` SET `marca` = '$marca', `stock` = '$STOCK', `valorCompra` = '$vCompra', `valorVenta` = '$vVenta' WHERE `tire`.`modelo` = '$modelo'";
	echo "<script type=\"text/javascript\">alert(\"Los Datos se han guardado correctamente.\");</script>";
	$insert=mysqli_query($conn, $edith_tire);
}

mysqli_free_result($result);
mysqli_close($conn);
?>
<?php 
ob_end_flush(); 
?>