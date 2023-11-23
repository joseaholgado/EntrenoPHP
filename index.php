<?php

    session_start() ;

    // Tenemos que indicarle al controlador frontal (index.php)
    // qué queremos hacer (f) y con qué controlador/modelo (m).
    // Indicamos esto a través de la URL.
    // index.php?m=serie&f=main
    //
    // URLS AMIGABLES
    // series --> index
    // series/info.php?id=2   --> series/info/2

    $que   = $_GET["f"]??$_POST["f"]??"showLogin" ;   // Función a realizar con el controlador|modelo
    $quien = $_GET["m"]??$_POST["m"]??"usuario"   ;   // Serie, Usuario, Genero, Pelicula, etc...

    // "Construimos" el nombre del controlador con el que vamos
    // a trabajar.
    $nombreControlador = "{$quien}Controller" ;

    // Ruta hasta el controlador
    $ruta = "controladores/{$nombreControlador}.php" ;

    // Comprobamos si existe el archivo controlador
    if (!file_exists($ruta))  die("** Error de acceso al controlador.") ;

    // Importamos el controlador
    require_once $ruta ;

    // Instanciamos el controlador
    $controlador = new $nombreControlador ;

    // Invocamos la función que se nos indicaba en la URL
    if (method_exists($controlador, $que)) $controlador->$que() ;
    else die("** Error en el controlador.") ;


