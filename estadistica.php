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
        <link href="css/estilohome.css" rel="stylesheet">
        <link href="css/bootstrap.min.css" rel="stylesheet">
    <title>::: Informes :::</title>
	<script type="text/javascript" src="js/validar_fechas.js"></script>
	<script type="text/javascript" src="js/alert.js"></script>
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
			';
		}
		?>
        </ul>
      </div>
    </div>
  </nav>
</header>
    <div class="contenedor-informes">
    <h1 class="animate__animated animate__backInLeft" id="titulo"><img src="../img/icono_estadistica.png" width="50">Informes.</h1>
    <form class="form-inline" id="formulario" method="post" action="estadistica.php" style="width: 100%;">
	<div class="form-group" style="width: 100%;">
    <select class="form-control" name="filter" id="filter">
    <option value="0">--------</option>
    <option value="ACTIVO">ACTIVO</option>
    <option value="INACTIVO">INACTIVO</option>
    </select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <label>Inicio:</label>&nbsp;&nbsp;
    <input type="datetime-local" class="form-control" name="date1" id="date1" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <label>Fin</label>&nbsp;&nbsp;
    <input type="datetime-local" class="form-control" name="date2" id="date2" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="submit" value="BUSCAR" class="buscar_button">
    </div>
    </form> 
    <br>
    <div class="table-responsive">
            <table class="table table-striped table-hover" style="background-color: white; color: rgb(110, 108, 108);">
                <tr>
                    <th>N°</th>
                    <th>Tracto</th>
                    <th>Semi</th>
					<th>Tipo</th>
					<th>Carga</th>
                    <th>Chofer</th>
                    <th>Tel&eacute;fono</th>
                    <th>Observaciones</th>
                    <th>Entrada</th>
                    <th>User Entrada</th>
                    <th>Salida</th>
                    <th>User Salida</th>
                    <th>$ Sistema</th>
                    <th>$ Real</th>
                </tr>
                <?php
                error_reporting(0);
				$filter=$_POST['filter'];
                echo "Registros : ".$filter." ";
               	$date1 = date("Y-m-d H:i:s", strtotime($_POST['date1']));
               	$date2 = date("Y-m-d H:i:s", strtotime($_POST['date2']));

				if($filter=="ACTIVO"){
			        $DATE_X="fecha_ingreso";

                    $sql = mysqli_query($conn, "SELECT * FROM `ingreso` where estado='$filter' and $DATE_X BETWEEN '$date1' AND '$date2' ORDER BY id ASC");
				}else{
					$filter=="INACTIVO";
				    $DATE_X="fecha_salida";

                    $sql = mysqli_query($conn, "SELECT * FROM `ingreso` where estado='$filter' and $DATE_X BETWEEN '$date1' AND '$date2' ORDER BY id ASC");
					$Sql = mysqli_query($conn, "SELECT SUM(pago) as pago FROM `ingreso` WHERE estado='INACTIVO' and fecha_salida BETWEEN '$date1' AND '$date2' ORDER BY id ASC ");	
					$SQL = mysqli_query($conn, "SELECT SUM(cancelado) as cancelado FROM `ingreso` WHERE estado='INACTIVO' and fecha_salida BETWEEN '$date1' AND '$date2' ORDER BY id ASC ");					
				}

                if(mysqli_num_rows($sql) == 0){

                    echo '<tr><td colspan="11">No hay datos. Por favor seleccione una opción</td></tr>';

                }else{

				
                    $no = 1;

                    while($row = mysqli_fetch_assoc($sql)){
						while($Row = mysqli_fetch_array($Sql)){
							$Total = $Row['pago'];
							$V_sistem =number_format($Total,0,',','.');
						}
						while($ROW = mysqli_fetch_array($SQL)){
							$To = $ROW['cancelado'];
							$V_cancelado =number_format($To,0,',','.');
						}

						$total = $Total - $To;
						$diferencia=number_format($total,0,',','.');
                     echo '

                    <tr>

                        <td>'.$no.'</td>
                        <td>'.$row['tracto'].'</td>
                        <td>'.$row['semi'].'</td>
						<td>'.$row['tipo'].'</td>
						<td>'.$row['carga'].'</td>
                        <td style="text-transform:capitalize;">'.$row['nombre'].'</td>
                        <td>'.$row['telefono'].'</td>
                        <td>'.$row['observaciones'].'</td>
                        <td>'.date("d/m/Y H:i:s", strtotime($row['fecha_ingreso'])).'</td>
                        <td>'.$row['usuario_ingreso'].'</td>
                        <td>'.$row['fecha_salida'].'</td>
                        <td>'.$row['usuario_salida'].'</td>
                        <td>$ '.number_format($row['pago'], 0, ',', '.').'</td>
                        <td>$ '.number_format($row['cancelado'], 0, ',', '.').'</td>
                    </tr>

                    ';$no++;

                   

                 }

                }
			?>

            </table>

            <?php echo " ".mysqli_num_rows($sql)." Registros encontrados, con un valor recaudado de $ ".$V_cancelado." Valor por sistema $ ".$V_sistem." Diferencia $ ".$diferencia."."?>&nbsp;&nbsp;<a href="printer.php?date1=<?php echo $date1;?>&date2=<?php echo $date2;?>&filter=<?php echo $filter;?>" target="_blank"><input type="button" value="Reporte" class="buscar_button"></a>
		 </div>
		
	</div>

<!--Permite que se desplegue el Menu-->

<script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php 

ob_end_flush(); 

?>