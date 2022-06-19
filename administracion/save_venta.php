<?php 
ob_start(); 
?>
<?php
//conextamos a archivo para acceder a la base de datos
require("../admin/conex.php");
//iniciamos sesion
session_start();
//no mostrar errores
error_reporting(0);
//difinimos hora local
date_default_timezone_set('America/Santiago');
//recibinos el nombre del usuario conectado
$ver=$_SESSION['user'];
$s=explode(',',$ver);
	if($s[0]!=""){
	}	else{
		header("Location:index.php");
		exit;
	}
//Definir variables a recibir
$date=$_POST['date'];
$date=date('Y-m-d H:i:s', time());
$cl=$_POST['model'];
$ch=$_POST['chofer'];
$ob=$_POST['obs'];

$ser=$_POST['servicio'];
$des=$_POST['neuma'];
$Ob=$_POST['decrip'];
$vu=$_POST['valorunitario'];
$vu=trim(str_replace(array('-','.'), '', $vu));
$cant=$_POST['stock'];

$pago=$_POST['pago'];	
$money=$_POST['tipo-moneda'];	
$total=$_POST['valorTotal'];
$total=trim(str_replace(array('-','.'), '', $total));
$abono=$_POST['abo'];
$user=$ver;

if($des == "0"){
	$git = $Ob;
}else{
	if($vu == ""){
	$b_tire=mysqli_query($conn, "SELECT * FROM `tire`  WHERE id='$des'");
	while($rst=mysqli_fetch_array($b_tire)){
		$vunit=$rst['valorVenta'];
		$Modelo=$rst['modelo'];
		$Marca=$rst['marca'];
		$stock=$rst['stock'];
		$Stock=$stock - $cant;
		$Nombre=$Modelo." ".$Marca;
		}
	$descontar="UPDATE `tire` SET `stock` = '$Stock'  WHERE `tire`.`id` = ".$des."";
	$ins=mysqli_query($conn, $descontar);
	}else {
		$vunit = $vu;
	}
		$git = $Nombre;
}



if($pago == "CONTADO"){
	$abono = $total;
	$saldo = "0";
}if($pago == "CREDITO"){
	$abono=$_POST['abo'];
	$abono=trim(str_replace(array('-','.'), '', $abono));
	$saldo=$total - $abono;
}
include('vent.php');
$buscarmoneda=mysqli_query($conn, "SELECT * FROM `moneda` WHERE id='$money'");
	while($resultadomonedy=mysqli_fetch_array($buscarmoneda)){
		$TipoMoney=$resultadomonedy['moneda'];
	}

$save="INSERT INTO `ventas` (`date`, `cliente`, `chofer`, `observaciones`, `servicio`, `descripcion`, `valor`, `cantidad`, `pago`, `moneda`, `total`, `abono`, `saldo`, `user`) VALUES ('$date', '$cl', '$ch', '$ob', '$ser', '$git', '$vunit', '$cant', '$pago', '$TipoMoney', '$total', '$abono', '$saldo', '$ver')";
$insertar=mysqli_query($conn, $save);
echo "<script type=\"text/javascript\">alert(\"Los datos se han guardado exitosamente!\");</script>";

mysqli_close($conn);
?>
<?php 
ob_end_flush(); 
?>