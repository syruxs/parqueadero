<?php
date_default_timezone_set('America/Santiago');
require("../admin/conex.php");
    	error_reporting(0);
		$Cliente=$_GET['cliente'];
		$tPago=$_GET['pago'];
       
        $date1 = date("Y-m-d H:i:s", strtotime($_GET['date1']));
        $date2 = date("Y-m-d H:i:s", strtotime($_GET['date2']));
header("Content-Type: application/xlsm");
header("Content-Disposition: attachment; filename=ventas.xls")
?>
    	<table class="table table-striped table-hover" width="100%" border="1">
        	<tr>
            	<th>N°</th>
				<th>Fecha</th>
                <th>Cliente</th>
                <th>Chofer</th>
				<th>Observaciones</th>
				<th>Servicio</th>
                <th>Descripción</th>
                <th>Valor</th>
                <th>Cantidad</th>
                <th>T. Pago</th>
                <th>T. Moneda</th>
                <th>Total</th>
                <th>Abono</th>
                <th>Saldo</th>
              </tr>
    <?php

	
			if($Cliente == "TODOS" && $tPago == "TODOS"){
				
				$sql = mysqli_query($conn, "SELECT * FROM `ventas` WHERE date BETWEEN '$date1' AND '$date2' ORDER BY id ASC");		
			}
			if($Cliente != "TODOS" && $tPago == "TODOS"){
				$sql = mysqli_query($conn, "SELECT * FROM `ventas` WHERE cliente='$Cliente' AND date BETWEEN '$date1' AND '$date2' ORDER BY id ASC");
			}
			if($Cliente != "TODOS" && $tPago != "TODOS"){
				$sql = mysqli_query($conn, "SELECT * FROM `ventas` WHERE cliente='$Cliente' AND pago='$tPago' AND date BETWEEN '$date1' AND '$date2' ORDER BY id ASC");				
			}
			
			/*si no existen datos*/
			
			if(mysqli_num_rows($sql) == 0){
				echo '<tr><td colspan="14">No hay datos. Por favor seleccione una opción</td></tr>';
			}else {
				
			while($row = mysqli_fetch_array($sql)){

				echo '

						  <tr>
							<td><a href="abono.php?var='.$row['id'].'" id="a" name="a">'.$row['id'].'</a></td>
							<td>'.date("d/m/Y", strtotime($row['date'])).'</td>
							<td style="text-transform:capitalize; width: auto;">'.$row['cliente'].'</td>
							<td style="text-transform:capitalize;">'.$row['chofer'].'</td>
							<td>'.$row['observaciones'].'</td>
							<td>'.$row['servicio'].'</td>
							<td>'.$row['descripcion'].'</td>
							<td align="right">$ '.number_format($row['valor'], 0, ',', '.').'</td>
							<td align="center">'.$row['cantidad'].'</td>
							<td>'.$row['pago'].'</td>
							<td>'.$row['moneda'].'</td>
							<td align="right">$ '.number_format($row['total'], 0, ',', '.').'</td>
							<td align="right">$ '.number_format($row['abono'], 0, ',', '.').'</td>
							<td align="right">$ '.number_format($row['saldo'], 0, ',', '.').'</td>
						</tr>
				';
		}				
			}

	?>
		</table>