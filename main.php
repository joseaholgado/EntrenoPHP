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

	// $datos = [

	// 	new entrenamiento("Ahsoka", "Disney +", "Ambientada después de la caída del Imperio, la entrenamiento sigue al antiguo caballero Jedi mientras investiga una amenaza que se cierne sobre la galaxia.", "https://www.themoviedb.org/t/p/w600_and_h900_bestv2/zcuJsJEhaORzxaz6aRxm66NWgt7.jpg", 8),
	// 	new entrenamiento("La maldición de Hill House", "Netflix", "Un grupo de hermanos que, cuando eran niños, crecieron en lo que luego se convertiría en la casa embrujada más famosa del país. Ahora adultos, y forzados a volver a estar juntos frente a la tragedia, la familia finalmente debe enfrentarse a los fantasmas de su pasado.", "https://www.themoviedb.org/t/p/w600_and_h900_bestv2/flBIpQHga5217QgLE4BanIAzMix.jpg", 8.1),
	// 	new entrenamiento("Aquí no hay quien viva", "Netflix", "Roberto y Lucía están felices por mudarse al nuevo piso, pero desconocen la comunidad de vecinos que les espera. En la calle Desengaño, convivirán con sus vecinos un tanto peculiares.", "https://www.themoviedb.org/t/p/w600_and_h900_bestv2/yj3sVi1fJFKJPSPPCJC94yvEDQy.jpg", 8.4),
	// 	new entrenamiento("Cómo conocí a vuestra madre", "Amazon", "How I Met Your Mother. Exitosa entrenamiento de la CBS que, en su primera temporada, obtuvo excelentes índices de audiencia además de ganar dos premios Emmy: uno a la dirección artística y otro a la fotografía.", "https://www.themoviedb.org/t/p/w600_and_h900_bestv2/b34jPzmB0wZy7EjUZoleXOl2RRI.jpg", 8.2),
	// 	new entrenamiento("Friends", "HBO", "Las aventuras de seis jóvenes neoyorquinos unidos por una divertida amistad. Entre el amor, el trabajo y la familia, comparten sus alegrías y preocupaciones en el Central Perk, su café favorito.", "https://www.themoviedb.org/t/p/w600_and_h900_bestv2/rkKCSlr8OH5tbKEdgwtzvEiemrl.jpg", 8.4),
	// 	new entrenamiento("Frasier", "HBO", "El doctor Frasier Crane es un estirado psiquiatra que, tras su divorcio, se traslada de Boston a Seattle para llevar un programa-consultorio de radio.", "https://www.themoviedb.org/t/p/w600_and_h900_bestv2/gYAb6GCVEFsU9hzMCG5rxaxoIv3.jpg", 7.7),
	// 	new entrenamiento("Velma", "HBO", "Los orígenes de Velma Dinkley, la inteligente y gran olvidada integrante de Misterios S. A. de Scooby-Doo. Una entrenamiento divertida y original que descubre el complejo y peculiar pasado de una de las detectives más queridas.", "https://www.themoviedb.org/t/p/w300_and_h450_bestv2/zrTKIXx0GrE6yABJL829HBAs1Jy.jpg", 3.5),
	// 	new entrenamiento("Parks and Recreation", "Amazon", "La entrenamiento sigue las andanzas en formato de documental, de Leslie Knope, que trabaja en el departamento de parques y tiempo libre en Pawnee, Indiana.", "https://www.themoviedb.org/t/p/w600_and_h900_bestv2/8KGNPcfhbOj4DjDC9UzszoiMgzS.jpg", 8),				
	// ] ;


	//echo "<pre>".print_r($datos, true)."</pre>" ;
	//die() ;

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>

	<!-- Bootstrap -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />

	<!-- Bootstrap Icons -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
</head>
<body>

	<div class="container">

		<?php require_once "menu.php" ; ?>

		<div class="row row-cols-1 row-cols-md-3 g-4">
		<?php foreach($datos as $entrenamiento): ?>
			<div class="col">
				<div class="card shadow" style="width:18rem;">
					<img src="<?= $entrenamiento->getCartel() ?>" class="card-img-top" />
					<div class="card-body">
						<h4 class="card-title"><?= $entrenamiento->getNombre() ; ?></h4>
						<?php
							$dificultad = floor($entrenamiento->getDificultad()) ;
							echo estrellas($dificultad) ;
							//estrellas(5 - $dificultad, false) ;
						?>
						<h6><?= $entrenamiento->getMusculo() ; ?></h6>
						<p class="card-text"><?= substr($entrenamiento->getExplicacion(),0,50)."..." ?></p>
						<a href="info.php?id=<?= $entrenamiento->getIdentrenamiento() ?>" class="btn btn-dark btn-sm">Mas info.</a>
					</div>
				</div>
			</div>
			
		<?php endforeach ; ?>
		</div>
	</div>

</body>
</html>