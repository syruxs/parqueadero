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

$divisa=$_POST['div'];
$operacion=$_POST['op'];

if($operacion == 'COMPRA'){
	$z=mysqli_query($conn, "SELECT * FROM `divisas` WHERE divisa='$divisa'");
		while($y=mysqli_fetch_array($z)){
			$valor=$y['compra'];
		}
echo "<script type=\"text/javascript\">var tasacambio = document.getElementById('cambio');
tasacambio.value='".$valor."';</script>";
}if($operacion == 'VENTA'){
	$z=mysqli_query($conn, "SELECT * FROM `divisas` WHERE divisa='$divisa'");
		while($y=mysqli_fetch_array($z)){
			$valor=$y['venta'];
		}
echo "<script type=\"text/javascript\">var tasacambio = document.getElementById('cambio');
tasacambio.value='".$valor."';</script>";	
}

?>
<?php 
ob_end_flush(); 
?>