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
    require("admin/conex.php");

    $Sql_user=mysqli_query($conn,"SELECT * FROM  `login` where user='$ver'");
    while($rst_Sql_name=mysqli_fetch_array($Sql_user)){
            $usuario=$rst_Sql_name['user'];
            $nombre=$rst_Sql_name['name'];
			$perfil=$rst_Sql_name['perfil'];
		}
?>
<!doctype html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Daniel Ugalde Ugalde">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css">
        <link href="css/divisas.css" rel="stylesheet">
        <link href="css/bootstrap.min.css" rel="stylesheet">
    	<title>::: Divisas :::</title>
		<script src="js/jquery-3.6.0.js"></script>
		<script>
			$(document).ready(function() {
				$('li').click(function () {
					var url = $(this).attr('rel');
					$('#iframe').attr('src', url);
					$('#iframe').reload();
				});
			});	
		</script>
    </head>
<body>
<header>
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <div class="container-fluid">
      <a href="admin/logout.php" title="Cerrar Sesion"><img src="../img/close_session.png" width="20"></a><a class="navbar-brand" href="#"><?php echo " &nbsp;".$nombre.""?></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav me-auto mb-2 mb-md-0">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="home.php">HOME</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="estadistica.php">INFORMES</a>
          </li>
		<?php
		if($perfil == "ADMINISTRADOR"){
			echo '
			<li class="nav-item">
            	<a class="nav-link" aria-current="page" href="statistics.php">ESTADISTICA</a>
          	</li>
			<li class="nav-item">
				<a class="nav-link" aria-current="page" href="admin.php">ADMINISTRACIÓN</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" aria-current="page" href="divisas.php">DIVISAS</a>
			</li>
			';
		}
		?>
        </ul>
      </div>
    </div>
  </nav>
</header>
<section>
<div id="container">
	<ul>
		<li rel="divisas/compraVenta.php"><a href="#"><div id="botton">COMPRA / VENTA</div></a></li>
		<li rel="divisas/createDivisa.php"><a href="#"><div id="botton">MOVIMIENTOS</div></a></li>
	<a href="#"><div id="botton">INVENTARIO</div></a>
		<li rel="divisas/tasaCambio.php"><a href="#"><div id="botton">TASA DE CAMBIO</div></a></li>
	<a href="#"><div id="botton">INGRESO / EGRESO</div></a>
		<li rel="divisas/createDivisa.php"><a href="#"><div id="botton">CREAR DIVISA</div></a></li>
	<a href="#"><div id="botton">INVENTARIO X CAJERO</div></a>
	<a href="#"><div id="botton">HISTORIAL MOVIMIENTO</div></a>
	</ul>
</div>
<div id="seach">
	<iframe id="iframe"
    	width="100%"
   		height="550px"
		frameborder="0"
    	src="">
	</iframe>
</div>
</section>
<!--Permite que se desplegue el Menu-->
<script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php 

ob_end_flush(); 

?>