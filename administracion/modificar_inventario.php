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

$id=$_POST['id'];
$stock=$_POST['stock'];
$vc=$_POST['vc'];
$vc=trim(str_replace(array('-','.'), '', $vc));
$vv=$_POST['vv'];
$vv=trim(str_replace(array('-','.'), '', $vv));

$save_date="UPDATE `tire` SET `stock` = '$stock', `valorCompra` = '$vc', `valorVenta` = '$vv' WHERE `tire`.`id` = ".$id."";
echo "<script type=\"text/javascript\">alert(\"Los Datos se han guardado correctamente.\");</script>";
$insert=mysqli_query($conn, $save_date);
echo "<script type=\"text/javascript\">history.back(-1);</script>";

?>
<?php 
ob_end_flush(); 
?>
