<?php
error_reporting(1);
$user=$_POST['user'];
$pass=sha1($_POST['pass']);
date_default_timezone_set('America/Santiago');
$date=date('Y-m-d H:i:s', time()); 

require("admin/conex.php");

$consulta="SELECT * FROM `login` where user='$user' and pass='$pass'";
$result=mysqli_query($conn,$consulta);
while($Id_user=mysqli_fetch_array($result)){
$ID=$Id_user['id'];
}
$filas=mysqli_num_rows($result);


if($filas){
    $iniciar = "UPDATE `login` SET `date` = '$date' WHERE `login`.`id` = $ID";
    $insert=mysqli_query($conn, $iniciar);

    session_start();
    $_SESSION['user']=$user;
    header("location:home.php");

}else{
    ?>
    <?php
    include("index.php");
    ?>
   
    <h1 class="bad" style="color: #fff;"><img src="img/safety.png" width="20"> ¡ERROR EN LA AUTENTIFICACION!</h1>
    <?php
    echo "<script type=\"text/javascript\">alert(\"Existe un error en la autentificacion\");</script>";
    session_unset();
}
mysqli_free_result($result);
mysqli_close($conn);
?>