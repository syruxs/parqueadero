<?php 
ob_start(); 
?>
<?php
require("../admin/conex.php");
session_start();

$id=$_POST['id'];

$delete_dates="DELETE FROM `ingreso` WHERE `ingreso`.`id` = $id"; 
$Delete=mysqli_query($conn, $delete_dates); 
echo "<script type=\"text/javascript\">alert(\"El Expediente N°".$id." ha sido eliminado correctamente.\");</script>";

?>
<?php 
ob_end_flush(); 
?>