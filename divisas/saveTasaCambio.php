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

$id=$_POST['id'];
$compra=$_POST['compra'];
$sale=$_POST['venta'];


if($id == ""){
	echo "<script type=\"text/javascript\">alert(\"El campo no puede estar vacio.\");</script>";
	echo "<script type=\"text/javascript\">history.back(-1);</script>";
}else{
		$edith="UPDATE `divisas` SET `compra`='$compra', `venta`='$sale' where `id`='$id'";
		$insert=mysqli_query($conn, $edith);
		echo "<script type=\"text/javascript\">alert(\"Los datos se han guardado correctamente.\");</script>";
		include('tasaCambio.php');
}

mysqli_close($conn);
?>
<?php 
ob_end_flush(); 
?>