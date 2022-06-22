<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link href="css/consulta.css" rel="stylesheet">
<title>Documento sin título</title>
</head>
<body>
	<form method="post" action="valid_consulta.php" class="contenedor">
    <div class="form-user">
		<input type="text" required name="user" id="user" style="text-transform:lowercase;" onkeyup="javascript:this.value=this.value.lowercase();" title="Ingres su DNI o RUT">
		<label class="lbl-user">
			<span class="text-user">Cliente</span>
		</label>
    </div>
    <br>  
    <input type="submit" value="INGRESAR">
    </form>
</body>
</html>
