<?php 
ob_start(); 
?>
<?php

require("../admin/conex.php");
session_start();
error_reporting(0);
date_default_timezone_set('America/Santiago');
$ver=$_SESSION['user'];
$s=explode(',',$ver);
	if($s[0]!=""){
	}	else{
		header("Location:../index.php");
		exit;
	}
$id_venta=$_POST['id'];
$total=$_POST['tot'];
$abono=$_POST['abono'];
$abono=trim(str_replace(array('-','.'), '', $abono));
$saldo=$_POST['sal'];
$Saldo=$saldo-$abono;
$date=date('Y-m-d H:i:s', time()); 
$user=$ver;

$Sqli="INSERT INTO `abono` (`id_venta`, `total`, `abono`, `saldo`, `date`, `user`) VALUES ('$id_venta', '$total', '$abono', '$Saldo', '$date', '$user')";
$inser=mysqli_query($conn, $Sqli);

$edit_vent="UPDATE `ventas` SET `saldo` = '$Saldo' WHERE `ventas`.`id` = ".$id_venta."";
$insert=mysqli_query($conn, $edit_vent);

echo "<script type=\"text/javascript\">alert(\"Los datos se han guardado exitosamente!\");</script>";
	include('buscar_venta.php');
		mysqli_close($conn);
?>
<?php 
ob_end_flush(); 
?>