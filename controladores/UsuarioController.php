<?php

require_once "Controller.php";
require_once "modelos/Usuario.php";
require_once "modelos/Administrador.php";
require_once "librerias/libreria.php";
require_once "MusculoController.php";
require_once "extensiones/TwigSessionExtension.php";
class UsuarioController extends Controller
{

    /**
     * Muestra el formulario de login
     * @return
     */
    public function showLogin($mensajeError = null)
    {
        // index.php o la página a la que se redirige
        if (isset($_GET['sesion_expirada']) && $_GET['sesion_expirada'] === 'true') {
            // Muestra un mensaje de sesión expirada
            $mensajeError = "Tu sesión ha expirado.<br> Por favor, vuelve a iniciar sesión";
        } elseif (isset($_GET['usuario_eliminado']) && $_GET['usuario_eliminado'] === 'true') {
            // Muestra un mensaje de cuenta eliminada
            $mensajeError = "Tu cuenta ha sido eliminado.<br>Esperamos que vuelvas pronto";
        } elseif (isset($_GET['sesion_cerrada']) && $_GET['sesion_cerrada'] === 'true') {
            // Muestra un mensaje de sesio cerrada
            $mensajeError = "Tu sesión ha sido cerrada.<br>Esperamos que vuelvas pronto";
        }



        // Generamos un token CSRF seguro
        $token = bin2hex(random_bytes(32)); // Genera un token de 64 caracteres hexadecimales

        // Guardamos el token en la variable global sesión
        $_SESSION["_csrf"] = $token;
        show($_SESSION["_csrf"]);

        // Cargamos la vista de login y le pasamos el token
        $this->render("usuario/login.php.twig", ["token" => $token, "mensajeError" => $mensajeError]);
    }

    /**
     * Muestra el formulario de login con mensaje de registrado
     * @return
     */
    public function showLoginMensajeBueno($mensaje = null)
    {

        // Generamos un token CSRF seguro
        $token = bin2hex(random_bytes(32)); // Genera un token de 64 caracteres hexadecimales

        // Guardamos el token en la variable global sesión
        $_SESSION["_csrf"] = $token;
        // Cargamos la vista de login y le pasamos el token
        $this->render("usuario/login.php.twig", ["token" => $token, "mensaje" => $mensaje]);
    }

    /** 
     * Loguea al usuario si existe en la base de datos
     * @return void
     */
    public function login()
    {

        // Verificar el token CSRF
        if (!isset($_POST["_csrf"]) || !hash_equals($_POST["_csrf"], $_SESSION["_csrf"])) {
            // El token no es válido, mostrar un mensaje de error

            $mensajeError = "El token no es válido.";
            $this->showLogin($mensajeError);
            return; // Finalizar la ejecución para evitar continuar
        }

        // Comprobar si el email y la contraseña están vacíos
        if (empty($_POST["email"]) || empty($_POST["pass"])) {

            // Mostrar un mensaje de error indicando campos vacíos
            $mensajeError = "El email o la contraseña están vacíos.";
            $this->showLogin($mensajeError);
            return;
        }

        // Seleccionar el tipo de usuario según la bandera 'administrador'  o 'usuario'
        //Ademas, guardamos variable para saber que es admin
        if (isset($_POST["administrador"]) && $_POST["administrador"] === 'true') {
            $usuario = Administrador::loginAdministrador($_POST["email"], $_POST["pass"]);
            if ($usuario) {
                $_SESSION["admin"] = true;
                // Resto de tu lógica
            }
        } else {
            $usuario = Usuario::loginUsuario($_POST["email"], $_POST["pass"]);
        }


        // Si el usuario no se encontró en la base de datos, mostrar un mensaje de error
        if ($usuario === null) {
            $mensajeError = "El usuario o la contraseña son incorrectos.";
            $this->showLogin($mensajeError);
            return;
        }

        // El usuario existe, almacenar en sesión y redirigir
        $_SESSION['usuario'] = $usuario;
        $_SESSION["inicio"] = time();

        // Llamar a listado() en MusculoController y pasar los datos a la vista
        $musculoController = new MusculoController();
        $musculoController->listado();

        //$this->render("usuario/main.php.twig", ["musculos" => $todosMusculos]);

        // // Comprobar si han pasado 30 segundos desde que se inició la sesión
        //$this->sesionExpirada();
    }
    /** 
     * Cierra la sesión del usuario cuando el tiempo has transcurrido sino 
     * se hatrancurrido se reinicia el contador
     * @return void
     */
    public function sesionExpirada()
    {
        $inactivo = 60; // Tiempo de inactividad en segundos



        // Comprobar si han pasado 60 segundos desde que se inició la sesión
        if (isset($_SESSION['inicio']) && (time() - $_SESSION['inicio'] > $inactivo)) {
            // La sesión ha expirado, cerrar la sesión
            session_unset();
            session_destroy();
            header("Location: index?sesion_expirada=true");
            exit();
        }

        // Actualizar la marca de tiempo de inicio de la sesión
        $_SESSION['inicio'] = time();
    }

    /** 
     * Cierra la sesión del usuario
     * @return void
     */
    public function cerrarSesion()
    {

        session_unset();
        session_destroy();

        header("location: index?sesion_cerrada=true");
    }


    /**Eleminar el usuario de la base de datos
     */
    public function eliminar()
    {

        if (isset($_SESSION["admin"]) && ($_SESSION["admin"] === true)) {

            $id = $_POST["idUsuario"];

            $usuario = Administrador::getAdministrador($id);


        } else {
            $id = $_POST["idUsuario"];

            $usuario = Usuario::getUsuario($id);

        }
        $usuario->borrar();    // TELL DON'T ASK
        session_unset();
        session_destroy();

        header("Location: index?usuario_eliminado=true");
        exit();
    }

    /** 
     * Muestra el formulario de registro
     * @return void
     */
    public function showregistro($mensajeError = null)
    {

        // Generamos un token CSRF seguro
        $token = bin2hex(random_bytes(32)); // Genera un token de 64 caracteres hexadecimales

        // Guardamos el token en la variable global sesión
        $_SESSION["_csrf"] = $token;

        // Cargamos la vista de registro y le pasamos el token
        $this->render("usuario/registro.php.twig", ["token" => $token, "mensajeError" => $mensajeError]);
        //rederizar hace que me muestre la pagina html al cliente
    }

    /** 
     * Registra al usuario en la base de datos
     * @return void
     */
    public function registro()
    {
        // Verificar el token CSRF para ataque de fuerza bruta de bots
        if (!isset($_POST["_csrf"]) || !hash_equals($_POST["_csrf"], $_SESSION["_csrf"])) {
            // El token no es válido, mostrar un mensaje de error
            show($_SESSION["_csrf"]);
            $mensajeError = "El token no es válido.";
            $this->showregistro($mensajeError);
            return; // Finalizar la ejecución para evitar continuar
        }
        // Validación de datos
        // ... (validar campos, contraseñas, etc.)
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $email = $_POST['email'];
            $pass = $_POST['pass'];
            $passc = $_POST['passc'];

            // Validar contraseñas coincidentes, longitud, etc.
            // Validación de contraseñas coincidentes
            if ($pass != $passc) {
                $mensajeError = "Las contraseñas no coinciden. Vuelve e intentarlo de nuevo.";
                $this->showregistro($mensajeError);
                return; // Finalizar la ejecución para evitar continuar

            }
            if ($nombre === '' || $apellido === '' || $email === '' || $pass === '' || $passc === '') {
                $mensajeError = "No puede haber campos vacios";
                $this->showregistro($mensajeError);
                return; // Finalizar la ejecución para evitar continuar
            }

            // Verificar si la contraseña es demasiado larga
            $max_longitud = 30; // Establecer la longitud máxima deseada
            if (strlen($pass) > $max_longitud) {

                $pass = substr($pass, 0, $max_longitud); // Truncar la contraseña si es demasiado larga
            }

            // Encriptar la contraseña antes de almacenarla en la base de datos
            $contrasena_encriptada = password_hash($pass, PASSWORD_DEFAULT);


            // Crear instancia de Usuario y llamar al método de registro
            // Acceso al administrador  
            if (isset($_POST["administrador"])) {
                if ($_POST["administrador"] === 'true') {
                    $admin = new Administrador();
                    $registroExitoso = $admin->registrarAdministrador($nombre, $apellido, $email, $contrasena_encriptada, );
                }

                // Acceso al usuario
            } else {

                $usuario = new Usuario();
                $registroExitoso = $usuario->registrarUsuario($nombre, $apellido, $email, $contrasena_encriptada, );
            }

            if ($registroExitoso) {
                $mensaje = "Te has registrado con éxito";
                // Redireccionar o mostrar mensaje de éxito
                $this->showLoginMensajeBueno($mensaje);
            } else {
                // Mostrar mensaje de error
                $mensajeError = "Ya existe un usuario con ese email";
                $this->showregistro($mensajeError);
            }

        }

    }

    /** 
     * Muestra el formulario de modificación
     * @return void
     */
    public function showModificarUsuario()
    {
        $this->sesionExpirada();

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Verificar el token CSRF cuando se accede a la página de modificación
            $token = isset($_GET['token']) ? $_POST['token'] : '';

            if (!isset($_SESSION["_csrf"]) || !hash_equals($_SESSION["_csrf"], $token)) {
                // El token no es válido, manejar el error apropiadamente
                // Por ejemplo, mostrar un mensaje de error o redireccionar a otra página
                $mensajeError = "Error: Token CSRF no válido";
                $this->showLogin($mensajeError);
            }
        }
        // Generamos el token para protección CSRF
        $token = md5(uniqid(mt_rand()));

        // Guardamos el token en la sesión
        $_SESSION["_csrf"] = $token;

        // Cargamos la vista de registro y le pasamos el token
        $this->render("usuario/modificarUsuario.php.twig", ["token" => $token]);
        //rederizar hace que me muestre la pagina html al cliente
    }

    /** 
     * Muestra el formulario de modificación
     * @return void
     */
    public function modificarUsuario()
    {


        $idUsuario = $_POST["idUsuario"];
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
                $mensajeError = "Las contraseñas no coinciden. Vuelve e intenta de nuevo.";
                $this->render("usuario/modificarUsuario.php.twig", ["mensajeError" => $mensajeError]);
                exit(); // Terminamos el script si las contraseñas no coinciden
            }

            //Verificar si los campos no estan vacios
            if ($nombre === '' || $apellido === '' || $email === '' || $pass === '' || $passc === '') {
                $mensajeError = "No puede haber campos vacios";
                $this->render("usuario/modificarUsuario.php.twig", ["mensajeError" => $mensajeError]);
                exit(); // Terminamos el script si las contraseñas no coinciden
            }
            // Verificar si la contraseña es demasiado larga
            $max_longitud = 30; // Establecer la longitud máxima deseada
            if (strlen($pass) > $max_longitud) {

                $pass = substr($pass, 0, $max_longitud); // Truncar la contraseña si es demasiado larga
            }

            // Encriptar la contraseña antes de almacenarla en la base de datos
            $contrasena_encriptada = password_hash($pass, PASSWORD_DEFAULT);
            // Crear instancia de Usuario o Administrador y llamar al método de registro
            if (isset($_SESSION["admin"]) && ($_SESSION["admin"] === true)) {
                $usuario = new Administrador();
            } else {
                $usuario = new Usuario();
            }
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {

                // Procesar la imagen aquí
                $archivo_nombre = $_FILES['foto']['name'];
                $archivo_temp = $_FILES['foto']['tmp_name'];
                $archivo_error = $_FILES['foto']['error'];
                $directorio_destino = './img/'; // Directorio donde se guardarán las imágenes
                $ruta_destino = $directorio_destino . $archivo_nombre; // Mover el archivo al directorio de destino
                $ruta_para_db = './img/' . $archivo_nombre; // Ruta relativa al directorio 

                // Mueve el archivo al directorio de destino
                move_uploaded_file($archivo_temp, $ruta_destino);

                if (isset($_SESSION["admin"]) && ($_SESSION["admin"] === true)) {
                    $registroExitoso = $usuario->actualizarAdministradorConImagen($nombre, $apellido, $email, $contrasena_encriptada, $idUsuario, $ruta_para_db);

                } else {
                    $registroExitoso = $usuario->actualizarUsuarioConImagen($nombre, $apellido, $email, $contrasena_encriptada, $idUsuario, $ruta_para_db);
                }

            } else {

                if (isset($_SESSION["admin"]) && ($_SESSION["admin"] === true)) {
                    $registroExitoso = $usuario->actualizarAdministrador($nombre, $apellido, $email, $contrasena_encriptada, $idUsuario);

                } else {
                    $registroExitoso = $usuario->actualizarUsuario($nombre, $apellido, $email, $contrasena_encriptada, $idUsuario);
                }

                //Actualizamos el _SESSION
                if (isset($_SESSION["admin"]) && ($_SESSION["admin"] === true)) {

                    $usuario = Administrador::loginAdministrador($_POST["email"], $_POST["pass"]);

                } else {
                    $usuario = Usuario::loginUsuario($_POST["email"], $_POST["pass"]);
                }

                $_SESSION['usuario'] = $usuario;


                if ($registroExitoso) {
                    $mensaje = "Registro exitoso";
                    // Cargamos la vista de registro y le pasamos el mensaje
                    $this->render("usuario/modificarUsuario.php.twig", ["mensaje" => $mensaje]);
                    // Redireccionar o mostrar mensaje de éxito
                } else {
                    $mensajeError = "Error al registrar usuario";
                    $this->render("usuario/modificarUsuario.php.twig", ["mensajeError" => $mensajeError]);
                    // Mostrar mensaje de error
                }
            }
        }

    }
}