<?php 
ob_start(); 
?>
<?php

require("../admin/conex.php");
session_start();
error_reporting(0);

$modelo=$_POST['tireNew'];

include("neumaticos_in.php");

$Newtire=mysqli_query($conn, "INSERT INTO `tire` (`modelo`) VALUES ('$modelo')");
$insert=mysqli_query($conn, $Newtire);
echo "<script type=\"text/javascript\">alert(\"Los Datos se han guardado correctamente.\");</script>";

mysqli_free_result($result);
mysqli_close($conn);
?>
<?php 
ob_end_flush(); 
?>