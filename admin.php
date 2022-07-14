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
		<link rel="stylesheet" href="css/style_admin.css">
		<script src="http://code.jquery.com/jquery-latest.js"></script>
		<script src="js/jquery-3.6.0.js"></script> 
		<link rel="stylesheet" href="http://www.falconmasters.com/demos/menu_desplegable_responsive/fonts.css">
 		<title>Administracion</title>
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
	<div class="menu">
		<nav class="nav" role="navigation">
		<ul class="nav__list">
			<li>
			<a href="home.php">HOME</a>
			</li>
			<li>
			<a href="estadistica.php">INFORMES</a>
			</li>
			<li>
			<a href="statistics.php">ESTADISTICA</a>
			</li>
			<li>
				<input id="group-1" type="checkbox" hidden />
				<label for="group-1"><span class="fa fa-angle-right"></span>PARQUEADERO</label>
				<ul class="group-list">
					<li rel="administracion/buscar.php"><a href="#">Buscar Expediente</a></li>
					<li rel="administracion/modificar.php"><a href="#">Modificar Expediente</a></li>
					<li rel="administracion/delete.php"><a href="#">Eliminar Expediente</a></li>
					<li rel="administracion/ventas.php"><a href="#">Ventas y Resumen</a></li>
				</ul>
			</li>
			<li>
				<input id="group-3" type="checkbox" hidden />
				<label for="group-3"><span class="fa fa-angle-right"></span>NEUMATICOS</label>
				<ul class="group-list">
					<li rel="administracion/neumaticos_in.php"><a href="#">Ingresar</a></li>
					<li rel="administracion/neumaticos_edith.php"><a href="#">Modificar</a></li>
					<li rel="administracion/inventario_neumaticos.php"><a href="#">Inventario</a></li>
				</ul>
			</li>
			<li>
				<input id="group-2" type="checkbox" hidden />
				<label for="group-2"><span class="fa fa-angle-right"></span>FINANZAS</label>
				<ul class="group-list">
					<li rel="administracion/doc_in.php"><a href="#">Ingresar Documentos</a></li>
					<li rel=""><a href="#">Modificar Documentos</a></li>
					<li rel="administracion/detalle.php"><a href="#">Resumen de Gastos</a></li>
					<li rel="administracion/cierreMes.php"><a href="#">Cierre de Mes</a></li>
				</ul>
			</li>
			<li>
				<input id="group-5" type="checkbox" hidden />
				<label for="group-5"><span class="fa fa-angle-right"></span>VENTAS</label>
				<ul class="group-list">
					<li rel="administracion/vent.php"><a href="#">Ingresar Venta</a></li>
					<li rel="administracion/buscar_venta.php"><a href="#">Buscar Ventas</a></li>
				</ul>
			</li>			
			<li>
				<input id="group-4" type="checkbox" hidden />
				<label for="group-4"><span class="fa fa-angle-right"></span>CLIENTE</label>
				<ul class="group-list">
					<li rel="administracion/NewCliente.php"><a href="#">Ingresar Cliente</a></li>
					<li rel="administracion/edith_cliente.php"><a href="#">Modificar o Emininar Clientes</a></li>
					<li rel="administracion/list_cliente.php"><a href="#">Listado de Clientes</a></li>
				</ul>
			</li>
			<li>
			<a href="divisas.php">DIVISAS</a>
			</li>
		</ul>
	</nav>
	</div>
	<div class="container">
		<div id="modificar_ex">
			<iframe id="iframe"
      			width="100%"
   				height="640px"
    			src="">
			</iframe>
		</div>
	</div>
</body>
</html>
<?php 
ob_end_flush(); 
?>