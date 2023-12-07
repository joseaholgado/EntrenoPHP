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
         // Acceso al administrador  
         if (isset($_POST["administrador"])) {
            if ($_POST["administrador"] === 'true'){
                // Solicitamos al MODELO que comprueba si existe algún
            // usuario coincidente en el email y la contraseña que
            // se nos proporciona a través del formulario.
            $usuario = Administrador::loginAdministrador($_POST["email"], $_POST["pass"]);

            if (is_null($usuario)):

                // Usuario no encontrado en la base de datos, se establece un mensaje de error
           $mensajeError = "El usuario o la contraseña<br> proporcionados son incorrectos.";
   
           // Se renderiza la vista de login con el mensaje de error
           $this->render("usuario/login.php.twig", ["mensajeError" => $mensajeError]);
               exit();
               // TODO                
           endif;



            }
        }else{
            // Solicitamos al MODELO que comprueba si existe algún
            // usuario coincidente en el email y la contraseña que
            // se nos proporciona a través del formulario.
            $usuario = Usuario::loginUsuario($_POST["email"], $_POST["pass"]);

            if (is_null($usuario)):

                // Usuario no encontrado en la base de datos, se establece un mensaje de error
           $mensajeError = "El usuario o la contraseña<br> proporcionados son incorrectos.";
   
           // Se renderiza la vista de login con el mensaje de error
           $this->render("usuario/login.php.twig", ["mensajeError" => $mensajeError]);
               exit();
               // TODO                
           endif;

            
        }
        

        // El usuario existe, por lo tanto lo redirigimos a la página
        // principal de la aplicación.
        $_SESSION['usuario'] = $usuario ;
        $_SESSION["inicio"] = time();

        

        //
        // Llamar a listado() en MusculoController y pasar los datos a la vista
        $musculoController = new MusculoController();
        $todosMusculos = $musculoController->listado();
        // $this->render("usuario/main.php.twig", ["musculos" => $todosMusculos,]);

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
        
        header("location: index") ;
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
                    $mensajeError= "Las contraseñas no coinciden. Vuelve e intentarlo de nuevo.";
                    $this->render("usuario/registro.php.twig", ["mensajeError" => $mensajeError]);
                    exit(); // Terminamos el script si las contraseñas no coinciden
                }
                if ($nombre === '' || $apellido === '' || $email === '' || $pass === '' || $passc === '') {
                    $mensajeError= "No puede haber campos vacios";
                    $this->render("usuario/registro.php.twig", ["mensajeError" => $mensajeError]);
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
                

                // Acceso al administrador  
                if (isset($_POST["administrador"])) {
                    if ($_POST["administrador"] === 'true'){
                    $admin = new Administrador();
                    $registroExitoso = $admin->registrarAdministrador($nombre, $apellido, $email, $contrasena_encriptada, );
                    }
                    
                // Acceso al usuario
                }else{
                    
                    $usuario = new Usuario();
                $registroExitoso = $usuario->registrarUsuario($nombre, $apellido, $email, $contrasena_encriptada, );
                }
                
                if ($registroExitoso) {
                    $mensaje= "Te has registrado con éxito";
                    // Redireccionar o mostrar mensaje de éxito
                    $this->render("usuario/login.php.twig", ["mensaje" => $mensaje]);
                } else {
                    // Mostrar mensaje de error
                    $mensajeError= "Error al registrar al usuario";              
                    $this->render("usuario/registro.php.twig", ["mensajeError" => $mensajeError]);
                }
            
        }
        
    }
    public function modificarUsuario(){
      
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
                $mensajeError= "Las contraseñas no coinciden. Vuelve e intenta de nuevo.";
                $this->render("usuario/modificarUsuario.php.twig", ["mensajeError" => $mensajeError]);
                exit(); // Terminamos el script si las contraseñas no coinciden
            }

            //Verificar si los campos no estan vacios
            if ($nombre === '' || $apellido === '' || $email === '' || $pass === '' || $passc === '') {
                $mensajeError= "No puede haber campos vacios";
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
            // Crear instancia de Usuario y llamar al método de registro
            $usuario = new Usuario();
            
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
               
                // Procesar la imagen aquí
                $archivo_nombre = $_FILES['foto']['name'];
                $archivo_temp = $_FILES['foto']['tmp_name'];
                $archivo_error = $_FILES['foto']['error'];
                $directorio_destino = './img/'; // Directorio donde se guardarán las imágenes
                $ruta_destino = $directorio_destino . $archivo_nombre;// Mover el archivo al directorio de destino
                $ruta_para_db = './img/' . $archivo_nombre; // Ruta relativa al directorio 
                
                // Mueve el archivo al directorio de destino
                move_uploaded_file($archivo_temp, $ruta_destino);

                $registroExitoso = $usuario->actualizarUsuarioConImagen($nombre, $apellido, $email, $contrasena_encriptada, $idUsuario, $ruta_para_db);
            
            }else{
                $registroExitoso = $usuario->actualizarUsuario($nombre, $apellido, $email, $contrasena_encriptada, $idUsuario);
            }

            //Actualizamos el _SESSION
            $usuario = Usuario::loginUsuario($_POST["email"], $_POST["pass"]);
            $_SESSION['usuario'] = $usuario ;


            if ($registroExitoso) {
                $mensaje= "Registro exitoso";
                  // Cargamos la vista de registro y le pasamos el mensaje
                  $this->render("usuario/modificarUsuario.php.twig", ["mensaje" => $mensaje]);
                // Redireccionar o mostrar mensaje de éxito
            } else {
                $mensajeError= "Error al registrar usuario";
                $this->render("usuario/modificarUsuario.php.twig", ["mensajeError" => $mensajeError]);
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