<?php
//Declarar las variables
$hostname="localhost";
$username="pscl53_pscl53";
$passname=".e8Vd[D?PcSy";
$dbname="pscl53_parking";
//Crear conexion
$conn=mysqli_connect($hostname, $username, $passname, $dbname);
//Chequear conexion
if (!$conn){

    die("La conexion ha fallado: " . mysqli_connect_error());
}
echo "";
?>