<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

    <!--hojas de etilos-->

    <link href="css/estilos.css" rel="stylesheet">

    <script src="js/jquery-3.6.0.js"></script>

    <script src="js/valid-login.js"></script>

    <title>:: Login ::</title>

    <script type="text/javascript">



    </script>

</head>

<body>

<form action="valid.php" method="post" class="contendor_general">

    <div class="form-user">

		<input type="text" required name="user" id="user" style="text-transform:lowercase;" onkeyup="javascript:this.value=this.value.lowercase();">

		<label class="lbl-user">

			<span class="text-user">Nombre</span>

		</label>

    </div>

    <br>  

    <div class="form-pass">

            <input type="password" require name="pass" id="pass"> 

                <label class="lbl-pass">

                    <span class="text-pass">Contraseña</span>

                </label>

    </div>

    <input type="submit" value="INGRESAR">

    </form>

</body>

</html>