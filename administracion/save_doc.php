<?php 
ob_start(); 
?>
<?php

require("../admin/conex.php");
session_start();
error_reporting(0);
date_default_timezone_set('America/Santiago');
$documento=$_POST['doc'];
$date=$_POST['date'];
$numero=$_POST['folio'];
$proveedor=$_POST['proveedor'];
$rut=$_POST['rut'];
$direccion=$_POST['direccion'];
$ciudad=$_POST['city'];
$cuenta=$_POST['cuenta'];
$total=$_POST['total'];
$total=trim(str_replace(array('-','.'), '', $total));
$neto=$_POST['neto'];
$neto=trim(str_replace(array('-','.'), '', $neto));
$iva=$_POST['iva'];
$iva=trim(str_replace(array('-','.'), '', $iva));
$observaciones=$_POST['observa'];


$consulta="SELECT * FROM `cueta` WHERE documento='$documento' AND numero='$numero'";
$result=mysqli_query($conn, $consulta);

include("doc_in.php");

	if(isset($_POST['factura'])) { 
		if(mysqli_num_rows($result)!=0){
			
			echo "<script type=\"text/javascript\">alert(\"La FACTURA N° ".$numero." ya se encuentra registrada.\");</script>";
			
		}else{
				$registrar ="INSERT INTO `cueta` (`documento`, `fecha`, `numero`, `proveedor`, `rut`, `direccion`, `ciudad`, `cuenta`, `total`, `neto`, `iva`, `observaciones`) VALUES ('$documento', '$date', '$numero', '$proveedor', '$rut', '$direccion', '$ciudad', '$cuenta', '$total', '$neto', '$iva', '$observaciones')";
				$insert=mysqli_query($conn, $registrar);
				echo "<script type=\"text/javascript\">alert(\"La FACTURA N° ".$numero." ha sido registrada correctamente\");</script>";
		}
	}if(isset($_POST['boleta'])){
		if(mysqli_num_rows($result)!=0){
			
			echo "<script type=\"text/javascript\">alert(\"La BOLETA N° ".$numero." ya se encuentra registrada.\");</script>";
			
		}else{
				$registrar ="INSERT INTO `cueta` (`documento`, `fecha`, `numero`, `cuenta`, `total`, `observaciones`) VALUES ('$documento', '$date', '$numero', '$cuenta', '$total', '$observaciones')";
				$insert=mysqli_query($conn, $registrar);
				echo "<script type=\"text/javascript\">alert(\"La BOLETA N° ".$numero." ha sido registrada correctamente\");</script>";
			
		}
	}if(isset($_POST['otros'])){
		if(mysqli_num_rows($result)!=0){
			
			echo "<script type=\"text/javascript\">alert(\"El DOCUMENTO N° ".$numero." ya se encuentra registrada.\");</script>";
			
		}else{
				$registrar ="INSERT INTO `cueta` (`documento`, `fecha`, `numero`, `proveedor`, `rut`, `direccion`, `ciudad`, `cuenta`, `total`, `observaciones`) VALUES ('$documento', '$date', '$numero', '$proveedor', '$rut', '$direccion', '$ciudad', '$cuenta', '$total', '$observaciones')";
				$insert=mysqli_query($conn, $registrar);
				echo "<script type=\"text/javascript\">alert(\"El DOCUMENTO N° ".$numero." ha sido registrada correctamente\");</script>";		
		}
	} 

mysqli_free_result($result);
mysqli_close($conn);
?>
<?php 
ob_end_flush(); 
?>