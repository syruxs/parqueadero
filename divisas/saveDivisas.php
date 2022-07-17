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

$divisa=$_POST['name'];

if($divisa == ""){
	echo "<script type=\"text/javascript\">alert(\"El campo no puede estar vacio.\");</script>";
	echo "<script type=\"text/javascript\">history.back(-1);</script>";
}else{
	$divi="SELECT * FROM `divisas` where divisa='$divisa'";
	$resultado=mysqli_query($conn, $divi);
	if(mysqli_num_rows($resultado)!=0){
		echo "<script type=\"text/javascript\">alert(\"Esta divisa ya se encuenta en el sistema.\");</script>";
		echo "<script type=\"text/javascript\">history.back(-1);</script>";
	}else{
		$save="INSERT INTO `divisas` (`divisa`, `compra` , `venta`, `saldo`) VALUES ('$divisa', '0' , '0', '0')";
		$insert=mysqli_query($conn, $save);
		echo "<script type=\"text/javascript\">alert(\"Los datos se han guardado correctamente.\");</script>";
		include('createDivisa.php');
	}

}


mysqli_close($conn);
?>
<?php 
ob_end_flush(); 
?>