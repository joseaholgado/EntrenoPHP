<?php
	session_start() ;	// "Iniciamos la sesión"	
	
	// Si me he logueado redirijo al script series.php
	if (!empty($_SESSION)) header("Location: ") ;
	
	/**	 
	 */
	function redireccion(String $url):never {
		exit(header("Location: $url"));
	}

	//
	if (!empty($_POST)):
		
		

		// buscamos en la base de datos
		$sqli = new mysqli("db", "root", "", "series") ;//contraseña prueba pero no me deja acceder preguntar Antonio

		$email = $sqli->real_escape_string($_POST["email"]) ;
		$pass  = md5($_POST["pass"]) ;

		$sql = "SELECT * FROM usuario WHERE email='$email' AND pass='$pass' ; " ;

		$result = $sqli->query($sql) ;

		if ($result->num_rows!=0):
		//if (($email=="bruce@wayne.com") && ($pass=="iambatman")):
			
			require_once "modelos/Usuario.php" ;
			//$usuario = new Usuario("Bruce", "Wayne", "bruce@wayne.com") ;
			$usuario = $result->fetch_object("Usuario") ;

			$_SESSION["usuario"] = $usuario ;
			$_SESSION["inicio"]  = time() ;

			//
			redireccion("main.php") ;
		else:
			echo "Nombre de usuario o contraseña incorrecto." ;
		endif ;

	endif ;


?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>

    <!-- Boostrap -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link href="./css/estilosLogin.css" rel="stylesheet" type="text/css" />
</head>
<body>

	<div class="container">

		<form action="index.php" method="POST">
            
            <!--Header-->
            <div class="header">
                <h2>///LOGIN</h2>
            </div>
			<!-- Email -->
			<div class="row">
				<div class="col-xs-2">
					<label for="Email">Email: </label>
				</div>

				<div class="col">
					<input class="form-control" value="bruce@wayne.com"
						   id="email" type="email" name="email" />
				</div>
			</div>

			<!-- Contraseña  -->
			<div class="row">
				<div class="col-xs-2">
					<label for="pass">Contraseña: </label>
				</div>

				<div class="col">
					<input class="form-control" value="iambatman"
						   id="pass" type="password" name="pass" />
				</div>
			</div>
		
			<div class="row mt-2">
				<div class="col">
					<button class="btn"><a href="./registro.php">Registrarse</a></button>
                    <button class="btn"><a href="index.php?m=entrenamiento&f=listado">Enviar Datos</a></button>
				</div>
			</div>
			
		</form>
        <div class="img">
			<img src="./img/portada.jpg"></img>
		</div>
	</div>


</body>
</html>