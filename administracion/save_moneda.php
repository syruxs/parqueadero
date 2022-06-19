<?php 
ob_start(); 
?>
<?php

require("../admin/conex.php");
session_start();
error_reporting(0);

$money=$_POST['select-moneda'];
$valor=$_POST['moneda'];
$Valor=trim(str_replace(array('-','.'), '', $valor));

include("neumaticos_in.php");

$sql_money="UPDATE `moneda` SET `valor` = '$Valor' WHERE `moneda` = '$money'";
	echo "<script type=\"text/javascript\">alert(\"El tipo de cambio han guardado correctamente.\");</script>";
		$modificar=mysqli_query($conn, $sql_money);


mysqli_free_result($result);
mysqli_close($conn);
?>
<?php 
ob_end_flush(); 
?>