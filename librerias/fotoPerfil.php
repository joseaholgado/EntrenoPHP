<?php
if (isset($_FILES['foto'])) {
    $archivo_nombre = $_FILES['foto']['name'];
    $archivo_temp = $_FILES['foto']['tmp_name'];
    $archivo_error = $_FILES['foto']['error'];

    // Verificar si no hay errores al subir el archivo
    if ($archivo_error === UPLOAD_ERR_OK) {
        $directorio_destino = './img/'; // Directorio donde se guardarán las imágenes

        // Mover el archivo al directorio de destino
        $ruta_destino = $directorio_destino . $archivo_nombre;
        if (move_uploaded_file($archivo_temp, $ruta_destino)) {
            // Conexión a la base de datos
            $conexion = new mysqli("dbEntrenamiento", "root", "", "entrenamientos");

            // Verificar la conexión
            if ($conexion->connect_error) {
                die("Error de conexión: " . $conexion->connect_error);
            }

            // Preparar la consulta para insertar la ruta de la imagen en la base de datos
            $ruta_para_db = 'img/' . $archivo_nombre; // Ruta relativa al directorio
            $query = "UPDATE usuario SET foto = '$ruta_para_db' WHERE idUsuario = 1"; // Cambia 1 por el ID del usuario

            // Ejecutar la consulta
            if ($conexion->query($query) === TRUE) {
                echo "La imagen se ha subido correctamente y la ruta se guardó en la base de datos.";
            } else {
                echo "Error al actualizar la base de datos: " . $conexion->error;
            }

            // Cerrar la conexión
            $conexion->close();
        } else {
            echo "Error al mover el archivo al directorio de destino.";
        }
    } else {
        echo "Error al subir la imagen.";
    }
}
?>
