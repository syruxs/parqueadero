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
        <link href="css/style_statistics.css" rel="stylesheet">
		<link href="css/bootstrap.min.css" rel="stylesheet">
	<title>::: Estadisticas :::</title>
		<script src="js/jquery-3.6.0.js"></script> 
		<script src="https://cdn.jsdelivr.net/npm/chart.js@latest/dist/Chart.min.js"></script>
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
            <a class="nav-link" aria-current="page" href="estadistica.php">INFORMES</a>
          </li>
		<?php
		if($perfil == "ADMINISTRADOR"){
			echo '
			<li class="nav-item">
            	<a class="nav-link active" aria-current="page" href="statistics.php">ESTADISTICA</a>
          	</li>
			<li class="nav-item">
				<a class="nav-link" aria-current="page" href="admin.php">ADMINISTRACIÓN</a>
			</li>
			';
		}
		?>
        </ul>
      </div>
    </div>
  </nav>
</header>
<section class="contenedor">
	<div class="in-flex">
		<canvas id="grafica">
			<label>Ocupacion Actual</label>
		<?php 
	                
	
	$date1 = date("Y-m-d H:i:s", strtotime($_POST['date1']));

	$date2 = date("Y-m-d H:i:s", strtotime($_POST['date2']));
	
$sql_enc = mysqli_query($conn, "SELECT tipo FROM `ingreso` where tipo='ENCARPADO' and estado='ACTIVO'");
$sql_sid = mysqli_query($conn, "SELECT tipo FROM `ingreso` where tipo='SIDER' and estado='ACTIVO'");
$sql_cis = mysqli_query($conn, "SELECT tipo FROM `ingreso` where tipo='CISTERNA' and estado='ACTIVO'");
$sql_con = mysqli_query($conn, "SELECT tipo FROM `ingreso` where tipo='CONTENEDOR' and estado='ACTIVO'");
$sql_ref = mysqli_query($conn, "SELECT tipo FROM `ingreso` where tipo='REFRIGERADO' and estado='ACTIVO'");
		
				$encarpado=mysqli_num_rows($sql_enc);
				$sider=mysqli_num_rows($sql_sid);
				$cisterna=mysqli_num_rows($sql_cis);
				$contenedor=mysqli_num_rows($sql_con);
				$regrigerado=mysqli_num_rows($sql_ref);
				$TOTAL=	$encarpado + $sider + $cisterna + $contenedor + $regrigerado;
	
	?>
<script type="text/javascript">
// Obtener una referencia al elemento canvas del DOM
const $grafica = document.querySelector("#grafica");
// Las etiquetas son las porciones de la gráfica
const etiquetas = ["ENCARPADO", "SIDER", "CISTERNA", "CONTENEDOR", "REFRIGERADO"]
// Podemos tener varios conjuntos de datos. Comencemos con uno
const datosIngresos = {

    data: [<?php echo $encarpado; ?>, <?php echo $sider; ?>, <?php echo $cisterna; ?>, <?php echo $contenedor; ?>, <?php echo $regrigerado; ?>], // La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas
    // Ahora debería haber tantos background colors como datos, es decir, para este ejemplo, 4
    backgroundColor: [
        'rgba(163,221,203,0.8)',
        'rgba(232,233,161,0.8)',
        'rgba(230,181,102,0.8)',
        'rgba(229,112,126,0.8)',
		'rgba(200,190,200,0.8)',
    ],// Color de fondo
    borderColor: [
        'rgba(163,221,203,1)',
        'rgba(232,233,161,1)',
        'rgba(230,181,102,1)',
        'rgba(229,112,126,1)',
		'rgba(200,190,200,1)',
    ],// Color del borde
    borderWidth: 1,// Ancho del borde
};
new Chart($grafica, {
    type: 'pie',// Tipo de gráfica. Puede ser dougnhut o pie
    data: {
        labels: etiquetas,
        datasets: [
            datosIngresos,
            // Aquí más datos...
        ]
    },
});
</script>
	</div>
	<div class="in-flex">
		<div>
            <div id="cont_67f2fd20a969af38cc65f49ec7ee571a"><script type="text/javascript" async src="https://www.meteored.cl/wid_loader/67f2fd20a969af38cc65f49ec7ee571a"></script></div>
		</div>
		<div>
<a class="twitter-timeline" href="https://twitter.com/UPFronterizos?ref_src=twsrc%5Etfw">Tweets by UPFronterizos</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>

		</div>
	</div>

</section>	

<!--<script src="js/graficos.js"></script>-->
<!--<script src="js/bootstrap.bundle.min.js"></script>-->
</body>
</html>
<?php 
ob_end_flush(); 
?>