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

	$s=$_POST['ser'];
	$n=$_POST['subTotal'];	
	$tipo=$_POST['tipo'];


	$re=mysqli_query($conn, "SELECT * FROM `moneda` where id='$s'");

	while ($v=mysqli_fetch_array($re)) {
		$m=$v['valor'];
		
		if($tipo == "VENTA NEUMATICOS"){
			if($s == "4"){
				
				$dolar=mysqli_query($conn, "SELECT * FROM `moneda` where id='1'");
					while($Rd=mysqli_fetch_array($dolar)){
						$Dolar=$Rd['valor'];
					}
				
				$valorFinal=$n * $Dolar; 
			echo '<input type="text" class="form-control" name="valorTotal" id="valorTotal" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" value="'.number_format($valorFinal,0,'','.').'"required>';
			}else {
				
				$valorFinal=$n;
			echo '<input type="text" class="form-control" name="valorTotal" id="valorTotal" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" value="'.number_format($valorFinal,0,'','.').'"required>';			
			}

		}else {
			$valorFinal=$n / $m;
			echo '<input type="text" class="form-control" name="valorTotal" id="valorTotal" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" value="'.number_format($valorFinal,0,'','.').'"required>';			
		}
	}
?>
<?php 
ob_end_flush(); 
?>