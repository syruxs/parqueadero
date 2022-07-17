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

$movimiento=$_POST['select'];
$divisa=$_POST['divisa'];
$caja=$_POST['caja'];
$monto=$_POST['monto'];
$observacion=$_POST['obs'];
$user=$ver;
$date=date("Y-m-d H:i:s", time());

if($movimiento == "INGRESO"){
	$saldo = $caja + $monto;
}if($movimiento == "EGRESO"){
	$saldo = $caja - $monto;
}

if($divisa == ""){
	echo "<script type=\"text/javascript\">alert(\"El campo no puede estar vacio.\");</script>";
	echo "<script type=\"text/javascript\">history.back(-1);</script>";
}else{
		$save="INSERT INTO `movimiento` (`movimiento`, `divisa`, `caja`, `monto`, `observacion`, `user`, `date` ) VALUES ('$movimiento', '$divisa', '$caja', '$monto', '$observacion', '$user', '$date')";
		$insertar=mysqli_query($conn, $save);
		$edith="UPDATE `divisas` SET `saldo`='$saldo' where `divisa`='$divisa'";
		$insert=mysqli_query($conn, $edith);
		echo "<script type=\"text/javascript\">alert(\"Los datos se han guardado correctamente.\");</script>";
		include('ingresoEgreso.php');
}
mysqli_close($conn);
?>
<?php 
ob_end_flush(); 
?>