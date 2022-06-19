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

	$service=$_POST['service'];

	$result=mysqli_query($conn, "SELECT * FROM `tire` where id='$service'");

	while ($ver=mysqli_fetch_array($result)) {
		
		echo '<input type="text" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" name="valorunitario" id="valorunitario" class="form-control" value="'.$ver['valorVenta'].'">';
		echo "<script type=\"text/javascript\">alert(\"Quedan N°".$ver['stock']." Neumaticos en stock\");</script>";
	}
?>
<?php 
ob_end_flush(); 
?>