<?php
// Verificamos si se han enviado los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Comprobamos que se hayan recibido todos los campos del formulario
    if (isset($_GET['nombre']) && isset($_GET['apellido']) && isset($_GET['email']) && isset($_GET['pass']) && isset($_GET['passc'])) {

        // Recibimos los datos del formulario
        $nombre = $_GET['nombre'];
        $apellido = $_GET['apellido'];
        $email = $_GET['email'];
        $pass = $_GET['pass'];
        $passc = $_GET['passc'];

        // Validación de contraseñas coincidentes
        if ($pass != $passc) {
            echo "Las contraseñas no coinciden. Vuelve e intenta de nuevo.";
            exit(); // Terminamos el script si las contraseñas no coinciden
        }

        // Realiza la conexión a tu base de datos
        $servername = "dbEntrenamiento";
        $username = "root";
        $password = "";
        $dbname = "entrenamientos";

        // Crear conexión
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Verificamos la conexión
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Verificar si la contraseña es demasiado larga
        $max_longitud = 30; // Establecer la longitud máxima deseada
        if (strlen($pass) > $max_longitud) {
            $pass = substr($pass, 0, $max_longitud); // Truncar la contraseña si es demasiado larga
        }

        // Encriptar la contraseña antes de almacenarla en la base de datos
        $contrasena_encriptada = password_hash($pass, PASSWORD_DEFAULT);

        // Preparamos la consulta SQL para insertar los datos en la tabla correspondiente
        $sql = "INSERT INTO usuario (nombre, apellido, email, pass) VALUES ('$nombre', '$apellido', '$email', '$contrasena_encriptada')";

        // Ejecutamos la consulta
        if ($conn->query($sql) === TRUE) {
            echo "Registro exitoso";
        } else {
            echo "Error al registrar usuario: " . $conn->error;
        }

        // Cerramos la conexión
        $conn->close();
    } else {
        echo "Todos los campos del formulario son obligatorios.";
    }
}
?>