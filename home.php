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
   		<title>Parking System</title>
   		<script src="js/jquery-3.6.0.js"></script> 
	    <script src="js/jquery.mask.js"></script>
		<script src="js/valid-in.js"></script>
		<script>
		$(document).ready(function () {
        	$('#fone').mask('+560-00000000');
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
            <a class="nav-link active" aria-current="page" href="home.php">HOME</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="estadistica.php">INFORMES</a>
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
  <div class="left-container">
    <?php 
    $cont=mysqli_query($conn,"SELECT * FROM `ingreso` where estado='ACTIVO'"); 
    $contador=mysqli_num_rows($cont);
    $capacidad = 130;
    $disponibilidad = $capacidad - $contador;
    ?>
	 <br>
    <form action="save_in.php" method="post" class="save-date-in">
      <h3 class="animate__animated animate__backInLeft" id="titulo">Registro de Entrada</h3>
      <label><?php echo "Camiones ingresados actualmente: ".$contador." Disponibilidad ".$disponibilidad." ";  ?></label><br>
      <label>Tracto:&nbsp;</label>
      <input type="text" autofocus class="form-control" id="tracto" name="tracto" title="Ingrese la Patente del Tracto"  style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" required>
      <label>Semi:&nbsp;</label>
      <div class="input-group">
      <input type="text" class="form-control" id="semi" name="semi" title="Ingrese la Patente del Semi-remolque" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" required>
      <select name="tipo" id="tipo" Class="form-control" required>
          <option value="ENCARPADO">ENCARPADO</option>
          <option value="SIDER">SIDER</option>
          <option value="CISTERNA">CISTERNA</option>
          <option value="CONTENEDOR">CONTENEDOR</option>
          <option value="REFRIGERADO">REFRIGERADO</option>
		  <option value="SIN SEMI">SIN SEMI</option>

     </select>
	       </div>
		<input type="radio" id="vacio" value="Vacio" name="radio_select"><label>&nbsp;Vacio</label>
		<input type="radio" id="cargado" value="Cargado" name="radio_select" checked><label>&nbsp;Cargado</label>
      <br>
      <div class="othe">
      <label>Nombre :&nbsp;</label>
      <input type="text" class="form-control" id="name" name="name" placeholder="Ingresar Nombre" title="Ingresar Nombre" style="text-transform:capitalize;" required>
      <label>Telefono:&nbsp;</label>
      <input type="tel" class="form-control" id="fone" name="fone" placeholder="+569-12345678" title="Ingresar un numero telefonico" maxlength="11" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">
      <label>Observaciones:&nbsp;</label>
      <input type="text" class="form-control" id="obs" name="obs">
      </div>
      <input type="submit" value="GUARDAR">
    </form>
	</div>
	

  <div class="right-container">
      <form action="home.php" method="post" class="seach">
		  <h3 class="animate__animated animate__backInLeft" id="titulo">Registro de Salida</h3>
		  <table width="100%" border="0" cellpadding="1">
			<tr>
				<td colspan="2">
				<label>Ingrese la patente del Tracto o Semi para realizar la busqueda.</label>
				</td>  
			</tr>
		  	<tr>
				<td>
				<div class="input-group">
				<input type="text" name="buscar_por" class="form-control" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" required>
				<select name="seach_semi" id="seach_semi" Class="form-control">
				<option value="tracto">TRACTO</option>
				<option value="semi">SEMI</option>
				</select>&nbsp;&nbsp;
				</div>
				</td>
				<td><input type="submit" value="BUSCAR" class="buscar"></td>
			</tr>
		  </table>
       </form>
      <form action="save_out.php" method="post" class="resulta">
		<?php
            error_reporting(0);
		  	$tipo_busqueda=$_POST['buscar_por'];
            $id_semi=$_POST['seach_semi'];
            $result_id_registro=mysqli_query($conn, "SELECT * FROM `ingreso` where $id_semi='$tipo_busqueda' and estado='ACTIVO'");
              while($datos_encotrados=mysqli_fetch_array($result_id_registro)){
				$Id_resultado=$datos_encotrados['id'];
                $Tracto_result=$datos_encotrados['tracto'];
                $Semi_result=$datos_encotrados['semi'];
                $tipo_result=$datos_encotrados['tipo'];
                $name_result=$datos_encotrados['nombre'];
                $Telefono_result=$datos_encotrados['telefono'];
                $Obs_result=$datos_encotrados['observaciones'];
                $originalDate=$datos_encotrados['fecha_ingreso'];
                $newDate = date("d/m/Y", strtotime($originalDate));
                $newTime = date("H:i:s", strtotime($originalDate));
                date_default_timezone_set('America/Santiago');
                $date_actual=date('Y-m-d H:i:s', time()); 
                $fecha1 = new DateTime($originalDate);
                $fecha2 = new DateTime($date_actual);
                $intervalo = $fecha1->diff($fecha2);
				$hasta_hoy=$intervalo->format('%d Dias %H Horas %i Minutos');
                $start = strtotime($originalDate);
                $end = strtotime($date_actual);
                $minutes = ($end - $start) / 60;
				$buscar_valor=mysqli_query($conn, "SELECT * from `valores` order by abs($minutes-`dias`) LIMIT 1");
					while($valor_encontrado=mysqli_fetch_array($buscar_valor)){
						$id_cercano=$valor_encontrado['id'];
						$dia_cercano=$valor_encontrado['dias'];
						$valor_cercano=$valor_encontrado['valor'];
							if($minutes <=$dia_cercano){
								  $Value_ok=$valor_cercano;
							}else{
								 $B_V=mysqli_query($conn, "SELECT * FROM `valores` where id= (SELECT MIN(id) FROM `valores` where id > $id_cercano )");
									while($V_E=mysqli_fetch_array($B_V)){
									  $Value_ok=$V_E['valor'];
									}
							}
					}
                }
		  ?>
		  <input type="hidden" name="id" value="<?php echo "".$Id_resultado."";?>">
          <input type="hidden" name="valor" value="<?php echo "".$Value_ok."";?>">
		  <label>Tracto : &nbsp; <?php echo $Tracto_result; ?></label>&nbsp;&nbsp;&nbsp; 
		  <label>Semi-remolque: &nbsp; <?php echo $Semi_result;?></label><label>&nbsp;&nbsp;&nbsp;<?php echo $tipo_result;?></label><br>
		  <label style="text-transform:capitalize;">Nombre: &nbsp; <?php echo $name_result;?></label> &nbsp;
		  <label>Telefono: &nbsp; <?php echo $Telefono_result;?></label><br>
		  <label>Observaciones: &nbsp; </label>
		  <?php echo '<input type="text" value="'.$Obs_result.'" id="obser" name="obser" class="form-control">';?><br>
		  <label>Fecha Entrada: &nbsp; <?php echo $newDate;?> &nbsp; Hora de Entrada: &nbsp; <?php echo $newTime; ?></label><br>
		 <?php echo $hasta_hoy." Valor actual $".number_format($Value_ok,0,',','.')."";?><br>
		  <!--<div class="input-group">-->

            <label>Monto Cancelado:&nbsp;</label> 

            <?php echo '<input type="text" value="'.$Value_ok.'" id="cancelado" name="cancelado" class="form-control" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" required>';?>
			<hr>
			<label>Moroso: &nbsp;</label>
			  <select name="moroso" id="moroso">
			  		<option value="NO">NO</option>
				  	<option value="SI">SI</option>
			  </select>
            <!--</div>-->
<table width="100%" border="0" cellpadding="3" cellspacing="1">
		<tr>
			<td width="50%" align="center">
			<input type="submit" value="MODIFICAR" id="change" name="change">
			</td>
			<td width="50%" align="center">
			<input type="submit" value="SACAR CAMION" id="save" name="save">
			</td>
		</tr>
            
</table>
	  </form>
  </div>

<!--Permite que se desplegue el Menu-->

<script src="js/bootstrap.bundle.min.js"></script>

</body>

</html>

<?php 

ob_end_flush(); 

?>