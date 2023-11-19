<?php

    require_once "Controller.php" ;
    require_once "modelos/Usuario.php" ;
    require_once "librerias/libreria.php" ;

    class UsuarioController extends Controller {

        /**
         * Muestra el formulario de login
         * @return
         */
        public function showLogin() {

            // Generamos el token para protección CSRF
            $token = md5(uniqid(mt_rand())) ;         
            
            // Guardamos el token en la sesión
            $_SESSION["_csrf"] = $token ;
            
            // Cargamos la vista de login y le pasamos el token
            $this->render("usuario/login.php.twig", ["token" => $token]) ;
        }

        /** 
         * Logueamos al usuario si existe en la base de datos
         * @return
         */
        public function login() {

            //  comprobar el token
            if ($_POST["_csrf"] != $_SESSION["_csrf"]) redireccion("http://localhost/series") ;

            //
            if ((empty($_POST["email"])) || (empty($_POST["pass"]))):
                // Hacemos una redirección al formulario de login indicando
                // que hay un error.

                // TODO

            endif ;
            
            // Solicitamos al MODELO que comprueba si existe algún
            // usuario coincidente en el email y la contraseña que
            // se nos proporciona a través del formulario.
            $usuario = Usuario::loginUsuario($_POST["email"], $_POST["pass"]) ;

            if (is_null($usuario)):
                 // Hacemos una redirección al formulario de login indicando
                // que hay un error.

                // TODO                
            endif ;

            // El usuario existe, por lo tanto lo redirigimos a la página
            // principal de la aplicación.
            $_SESSION["usuario"] = serialize($usuario) ;
            $_SESSION["inicio"]  = time() ;

            //
            redireccion("main") ;

        }

        /**
         */
        public function eliminar() {

            $id = $_GET["id"] ;            
            $usuario = Usuario::getUsuario($id) ;
            echo "BORRADO!!!!" ;
            $usuario->borrar() ;    // TELL DON'T ASK
        }

    }