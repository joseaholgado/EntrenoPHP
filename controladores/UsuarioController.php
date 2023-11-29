<?php

require_once "Controller.php";
require_once "modelos/Usuario.php";
require_once "librerias/libreria.php";
require_once "MusculoController.php";
require_once "extensiones/TwigSessionExtension.php";
class UsuarioController extends Controller
{

    /**
     * Muestra el formulario de login
     * @return
     */
    public function showLogin()
    {

        // Generamos el token para protección CSRF
        $token = md5(uniqid(mt_rand()));

        // Guardamos el token en la sesión
        $_SESSION["_csrf"] = $token;

        // Cargamos la vista de login y le pasamos el token
        $this->render("usuario/login.php.twig", ["token" => $token]);
    }

    /** 
     * Logueamos al usuario si existe en la base de datos
     * @return
     */
    public function login()
    {

        //  comprobar el token
        //  if ($_POST["_csrf"] != $_SESSION["_csrf"])
        //      redireccion("http://localhost/proyectoPHP");

        //
        if ((empty($_POST["email"])) || (empty($_POST["pass"]))):
            // Hacemos una redirección al formulario de login indicando
            // que hay un error.

            // TODO

        endif;

        // Solicitamos al MODELO que comprueba si existe algún
        // usuario coincidente en el email y la contraseña que
        // se nos proporciona a través del formulario.
        $usuario = Usuario::loginUsuario($_POST["email"], $_POST["pass"]);
     

        if (is_null($usuario)):

            // Iniciar la sesión y almacenar datos del usuario en la sesión


            // Hacemos una redirección al formulario de login indicando
            // que hay un error.
            $this->render("usuario/login.php.twig");
            exit();
            // TODO                
        endif;

        

      

        // El usuario existe, por lo tanto lo redirigimos a la página
        // principal de la aplicación.
        $_SESSION['usuario'] = $usuario ;
        $_SESSION["inicio"] = time();

        //
        // Llamar a listado() en MusculoController y pasar los datos a la vista
        $musculoController = new MusculoController();
        $todosMusculos = $musculoController->listado();
        $this->render("usuario/main.php.twig", ["musculos" => $todosMusculos,]);

        // Comprobar si han pasado 30 segundos desde que se inició la sesión
        $this->sesionExpirada();
    }
    public function sesionExpirada()
    {
        $inactivo = 15; // Tiempo de inactividad en segundos

        // Iniciar la sesión si no está iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Comprobar si han pasado 30 segundos desde que se inició la sesión
        if (isset($_SESSION['inicio']) && (time() - $_SESSION['inicio'] > $inactivo)) {
            // La sesión ha expirado, cerrar la sesión
            session_unset();
            session_destroy();

            // Redirigir al formulario de login
            header("usuario/login.php.twig");
            exit();
        }

        // Actualizar la marca de tiempo de inicio de la sesión
        $_SESSION['inicio'] = time();
    }
    public function cerrarSesion()
    {
        session_unset();
        session_destroy();
        header("location: http://localhost/proyectoPHP") ;
    }


    /**
     */
    public function eliminar()
    {
      


        $id = $_POST["idUsuario"];
        $usuario = Usuario::getUsuario($id);
        $usuario->borrar();    // TELL DON'T ASK

        $this->cerrarSesion() ;
    }


    public function showregistro()
    {

        // Generamos el token para protección CSRF
        $token = md5(uniqid(mt_rand()));

        // Guardamos el token en la sesión
        $_SESSION["_csrf"] = $token;

        // Cargamos la vista de registro y le pasamos el token
        $this->render("usuario/registro.php.twig", ["token" => $token]);
        //rederizar hace que me muestre la pagina html al cliente
    }

    public function registro()
    { 
       
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Validación de datos
            // ... (validar campos, contraseñas, etc.)
            
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $email = $_POST['email'];
            $pass = $_POST['pass'];
            $passc = $_POST['passc'];

            // Validar contraseñas coincidentes, longitud, etc.
            // Validación de contraseñas coincidentes
            if ($pass != $passc) {
                echo "Las contraseñas no coinciden. Vuelve e intenta de nuevo.";
                exit(); // Terminamos el script si las contraseñas no coinciden
            }
            // Verificar si la contraseña es demasiado larga
            $max_longitud = 30; // Establecer la longitud máxima deseada
            if (strlen($pass) > $max_longitud) {

                $pass = substr($pass, 0, $max_longitud); // Truncar la contraseña si es demasiado larga
            }

            // Encriptar la contraseña antes de almacenarla en la base de datos
            $contrasena_encriptada = password_hash($pass, PASSWORD_DEFAULT);
            // Crear instancia de Usuario y llamar al método de registro
            $usuario = new Usuario();
            $registroExitoso = $usuario->registrarUsuario($nombre, $apellido, $email, $contrasena_encriptada, );

            if ($registroExitoso) {
                echo "Registro exitoso";
                // Redireccionar o mostrar mensaje de éxito
            } else {
                echo "Error al registrar usuario";
                // Mostrar mensaje de error
            }
        }
    }
    public function modificarUsuario(){
        $idUsuario = $_POST["idUsuario"];
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Validación de datos
            // ... (validar campos, contraseñas, etc.)
            var_dump($_POST) ;
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $email = $_POST['email'];
            $pass = $_POST['pass'];
            $passc = $_POST['passc'];

            // Validar contraseñas coincidentes, longitud, etc.
            // Validación de contraseñas coincidentes
            if ($pass != $passc) {
                echo "Las contraseñas no coinciden. Vuelve e intenta de nuevo.";
                exit(); // Terminamos el script si las contraseñas no coinciden
            }
            // Verificar si la contraseña es demasiado larga
            $max_longitud = 30; // Establecer la longitud máxima deseada
            if (strlen($pass) > $max_longitud) {

                $pass = substr($pass, 0, $max_longitud); // Truncar la contraseña si es demasiado larga
            }

            // Encriptar la contraseña antes de almacenarla en la base de datos
            $contrasena_encriptada = password_hash($pass, PASSWORD_DEFAULT);
            // Crear instancia de Usuario y llamar al método de registro
            $usuario = new Usuario();
            $registroExitoso = $usuario->actualizarUsuario($nombre, $apellido, $email, $contrasena_encriptada, $idUsuario);

            if ($registroExitoso) {
                echo "Registro exitoso";
                // Redireccionar o mostrar mensaje de éxito
            } else {
                echo "Error al registrar usuario";
                // Mostrar mensaje de error
            }
        }
    }
    public function showModificarUsuario()
    {

        // Generamos el token para protección CSRF
        $token = md5(uniqid(mt_rand()));

        // Guardamos el token en la sesión
        $_SESSION["_csrf"] = $token;

        // Cargamos la vista de registro y le pasamos el token
        $this->render("usuario/modificarUsuario.php.twig", ["token" => $token]);
        //rederizar hace que me muestre la pagina html al cliente
    }


}