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

$di=$_POST['di'];

	$z=mysqli_query($conn, "SELECT * FROM `divisas` WHERE divisa='$di'");
		while($y=mysqli_fetch_array($z)){
			$saldo=$y['saldo'];
		echo "<script type=\"text/javascript\">var cajadivi = document.getElementById('caja');
cajadivi.value='".$saldo."';</script>";
		}
?>
<?php 
ob_end_flush(); 
?>