<?php 
ob_start(); 
?>
<?php
require("admin/conex.php");
session_start();

$tracto=$_POST['tracto'];
$semi=$_POST['semi'];
$tipo=$_POST['tipo'];
$carga=$_POST['radio_select'];
$name=$_POST['name'];
$fone=$_POST['fone'];
$obs=$_POST['obs'];
date_default_timezone_set('America/Santiago');
$date_in=date('Y-m-d H:i:s', time()); 
$user=$_SESSION['user'];
$estado="ACTIVO";

if($tipo == "SIN SEMI"){
	$carga = " ";
}else{
	$carga=$_POST['radio_select'];
}

$ResultadoMorosidad=mysqli_query($conn, "SELECT * FROM `ingreso` where tracto='$tracto' and estado='INACTIVO' and moroso='SI'");
while($RstMoro=mysqli_fetch_array($ResultadoMorosidad)){
	$Cancelado=number_format($RstMoro['cancelado'],0,',','.');
	$DateEntrada=date("d-m-Y H:i:s", strtotime($RstMoro['fecha_ingreso']));
	$DateSalida=date("d-m-Y H:i:s", strtotime($RstMoro['fecha_salida']));
	
}

if(mysqli_num_rows($ResultadoMorosidad)!=0){
    echo "<script type=\"text/javascript\">alert(\"El semiremolque presenta MOROSIDAD de $ ".$Cancelado." Entre las Fecha ".$DateEntrada." y la Fecha ".$DateSalida." ¡Por favor regularice su Deuda!\");</script>";
	echo "<script type=\"text/javascript\">history.back(-1);</script>";
}else {

	$consulta_semi="SELECT * FROM `ingreso` where semi='$semi' and 	estado='ACTIVO'";
	$result=mysqli_query($conn, $consulta_semi);

	if(mysqli_num_rows($result)!=0){
		echo "<script type=\"text/javascript\">alert(\"Existe un espediente con el mismo Semi-remolque ya ingresado.\");</script>";
		echo "<script type=\"text/javascript\">history.back(-1);</script>";
	}else{
		$consulta_tracto="SELECT * FROM `ingreso` where tracto='$tracto' and estado='ACTIVO'";
		$rst_tracto=mysqli_query($conn, $consulta_tracto);
		if(mysqli_num_rows($rst_tracto)!=0){
			echo "<script type=\"text/javascript\">alert(\"Existe un espediente con el mismo Tracto ya ingresado.\");</script>";
			echo "<script type=\"text/javascript\">history.back(-1);</script>";
		}else{

			$regis_ingreso = "INSERT INTO `ingreso` (`tracto`, `semi`, `tipo`, `carga`, `nombre`, `telefono`, `observaciones`, `fecha_ingreso`, `usuario_ingreso`, `estado`) VALUES ('$tracto', '$semi', '$tipo', '$carga', '$name', '$fone', '$obs', '$date_in', '$user', '$estado')"; 
			echo "<script type=\"text/javascript\">alert(\"Los datos se ha guardado correctamente.\");</script>";
			$insert=mysqli_query($conn, $regis_ingreso);

			if(!$insert){
			   echo mysql_error()."Error !!";
			}else{
				echo "<script type=\"text/javascript\">alert(\"Los Datos se han guardado correctamente.\");</script>";
				include('home.php');
		   }
		}
	}
}
mysqli_free_result($result);
mysqli_close($conn);
?>

<?php 

ob_end_flush(); 

?>

