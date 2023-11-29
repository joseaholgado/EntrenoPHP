<?php
	
	session_start() ;

	// Si no me he logueado redirijo al índice
	if (empty($_SESSION)) 
		header("Location: index.php") ;

	// comprobamos si la sesión de tiempo ha expirado
	if (time()-$_SESSION["inicio"] >= 300) 
		header("Location: logout.php") ;

	// refresco el momento de acceso a la página	
	$_SESSION["inicio"] = time() ;

	// importamos las librerías
	require_once("librerias/libreria.php") ;

	// importamos las clases
	require_once("modelos/Entrenamiento.php") ;
	require_once("modelos/Usuario.php") ;

	// recuperamos información del usuario
	$usuario = unserialize($_SESSION["usuario"]) ;

	
	$datos = entrenamiento::getAllEntrenamiento() ;
	
	 // Importamos TWIG (motor de plantillas)
	 require_once "vendor/autoload.php" ;

	 // Creamos los filtros que necesitemos
	 $filtro = new Twig\TwigFilter('acortar', function($string) {

		return substr($string,0,50)."..." ;

	 }) ;

	 echo "<h1>HJola mundo!</h1>" ;

	 // Configuramos la librería Twig indicándole la ruta hasta la
	 // carpeta donde tenemos todas las vistas.
	 $loader = new \Twig\Loader\FilesystemLoader("vistas") ;
 
	 // Instanciamos la librería Twig
	 $twig = new \Twig\Environment($loader) ;
	 $twig->addFilter($filtro) ;
 
	 // Renderizamos la plantilla
	 echo $twig->render("main.php.twig", [
 
		 "entrenamiento" => $datos,
 
	 ]);


	 die() ;
