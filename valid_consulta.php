<?php
error_reporting(0);
require("admin/conex.php");
    
$cliente=$_POST['user'];
$buscarCliente="SELECT * FROM `clientes` WHERE doc='$cliente'";
$resultado=mysqli_query($conn,$buscarCliente);
while($userCliente=mysqli_fetch_array($resultado)){
	$ClienteVenta=$userCliente['nombre'];
}
$filas=mysqli_num_rows($resultado);

if($filas){
	$buscarVenta="SELECT * FROM `ventas` WHERE cliente='$ClienteVenta'";
		$encontrado=mysqli_query($conn, $buscarVenta);
			while($enVent=mysqli_fetch_array($encontrado)){
				$VentaEncontada=$enVent['cliente'];

			}
	session_start();
	$_SESSION['cliente']=$VentaEncontada;
	header("location:ver_consulta.php");
}else{
	include("consulta.php");
	echo "<h1 class='bad' style='color: #fff;''><img src='img/safety.png' width='20'> ¡ERROR EN LA AUTENTIFICACION!</h1>";
    echo "<script type=\"text/javascript\">alert(\"Existe un error en la autentificacion\");</script>";
    session_unset();
}

mysqli_free_result($resultado);
mysqli_close($conn);
?>