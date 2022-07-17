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
		header("Location:../index.php");
		exit;
	}
    require("../admin/conex.php");

$divisa=$_POST['divi'];
$operac=$_POST['oper'];
$monto=$_POST['monto'];
$cambio=$_POST['cambio'];
$cliente=$_POST['cliente'];
$total=$_POST['total'];
$caja=$_POST['caja'];
$user=$ver;
$date=date('Y-m-d H:i:s', time()); 
$estado="ACTIVO";

if($divisa == "0"){
	echo "<script type=\"text/javascript\">alert(\"Selecciona una divisa por favor.\");</script>";
	echo "<script type=\"text/javascript\">history.back(-1);</script>";
}else{
	if($operac == "a"){
		echo "<script type=\"text/javascript\">alert(\"Selecciona un tipo de operacion  por favor.\");</script>";
		echo "<script type=\"text/javascript\">history.back(-1);</script>";		
	}else {
		if($operac == "COMPRA"){
			$saldo = $caja + $total;
		}else {
			$saldo = $caja - $total;
		}
		$save="INSERT INTO `compraventa` (`divisa`, `operacion` , `monto`, `tasa`, `cliente`, `total`, `user`, `date`, `saldocaja`, `estado` ) VALUES ('$divisa', '$operac', '$monto', '$cambio', '$cliente', '$total', '$user', '$date', '$saldo', '$estado')";
		$insert=mysqli_query($conn, $save);
		$edith="UPDATE `divisas` SET `saldo`='$saldo' where `divisa`='$divisa'";
		$insertar=mysqli_query($conn, $edith);
		echo "<script type=\"text/javascript\">alert(\"Los datos se han guardado correctamente.\");</script>";
		include('compraVenta.php');		
	}
}


mysqli_close($conn);
?>
<?php 
ob_end_flush(); 
?>