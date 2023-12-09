<?php

require_once "librerias/Conexion.php";

class Usuario
{

    public int $idUsuario;
    public string $email;
    public string $pass;
    public string $nombre;
    public string $apellido;
    public ?string $foto;

    public function __construct()
    {
    }


    // Método para obtener el nombre del usuario
    public function getNombre(): string
    {
        return $this->nombre;
    }
    public function getIdUsuario(): string
    {
        return $this->idUsuario;
    }

    /**Metodo para obtener el usuario por su id
     * 
     * @return Usuario
     */
    public static function getUsuario(int $id)
    {
       
        return Conexion::getConnection()
            ->query("SELECT * FROM usuario WHERE idUsuario={$id} ;")
            ->getRow("Usuario");
    }

    /**Metodo para obtener el usuario por su email
     * @return Usuario
     */
    
    public static function loginUsuario(string $email, string $password)
    {
       
        // Buscar al usuario por su correo electrónico
        $user = Conexion::getConnection()
            ->query("SELECT * FROM usuario WHERE email='{$email}'")
            ->getRow("Usuario");

        if ($user) {


            // Si se encuentra el usuario, verificar la contraseña
            if (password_verify($password, $user->pass)) {
                // La contraseña es correcta, devolver el usuario
                return $user;
            }
        }

        // Usuario no encontrado o contraseña incorrecta
        return null;
    }

    /**Mtodo para borrar al usuario
     * @return
     */
    public function borrar()
    {

        Conexion::getConnection()
            ->query("DELETE FROM usuario WHERE idUsuario={$this->idUsuario};");
    }

    /**Metodo para registrar al usuario
     * @return bool
     */
    public function registrarUsuario($nombre, $apellido, $email, $pass)
    {

        // Crear conexión utilizando el patrón Singleton
        $conexion = Conexion::getConnection();

        // Verificar si ya existe un usuario con el mismo correo electrónico
        $sql_verificacion = "SELECT COUNT(*) as count FROM usuario WHERE email = ?";
        $stmt_verificacion = $conexion->prepare($sql_verificacion);
        $stmt_verificacion->bind_param("s", $email);
        $stmt_verificacion->execute();
        $result = $stmt_verificacion->get_result();
        $row = $result->fetch_assoc();

        if ($row['count'] > 0) {
            // El usuario con este correo electrónico ya existe
            $stmt_verificacion->close();
            return false;
        }

        // Validación de datos y sentencia preparada para inserción
        $sql = "INSERT INTO usuario (nombre, apellido, email, pass) VALUES (?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ssss", $nombre, $apellido, $email, $pass);

        // Ejecutar la inserción
        $registroExitoso = $stmt->execute();

        // Cerrar statement y retornar resultado de la inserción
        $stmt->close();
        return $registroExitoso;
    }

    public function actualizarUsuario($nombre, $apellido, $email, $pass, $idUsuario)
    {
        // Crear conexión utilizando el patrón Singleton
        $conexion = Conexion::getConnection();

        // Validación de datos y sentencia preparada para actualización
        $sql = "UPDATE usuario SET nombre = ?, apellido = ?, email = ?, pass = ? WHERE idUsuario = ?";
        $stmt = $conexion->prepare($sql);

        // Verificar si la preparación de la consulta fue exitosa
        if ($stmt) {
            // Vincular parámetros
            $stmt->bind_param("ssssi", $nombre, $apellido, $email, $pass, $idUsuario);

            // Ejecutar la consulta
            $registroExitoso = $stmt->execute();



            // Cerrar la sentencia
            $stmt->close();
        } else {
            echo "Error al preparar la consulta.";
        }

        return $registroExitoso;


    }
    public function actualizarUsuarioConImagen($nombre, $apellido, $email, $pass, $idUsuario, $foto)
    {
        // Crear conexión utilizando el patrón Singleton
        $conexion = Conexion::getConnection();

        // Validación de datos y sentencia preparada para actualización
        $sql = "UPDATE usuario SET nombre = ?, apellido = ?, email = ?, pass = ?, foto = ? WHERE idUsuario = ?";
        $stmt = $conexion->prepare($sql);

        // Verificar si la preparación de la consulta fue exitosa
        if ($stmt) {
            // Vincular parámetros
            $stmt->bind_param("sssssi", $nombre, $apellido, $email, $pass, $foto, $idUsuario);
            


            // Ejecutar la consulta
            $registroExitoso = $stmt->execute();



            // Cerrar la sentencia
            $stmt->close();
        } else {
            echo "Error al preparar la consulta.";
        }

        return $registroExitoso;
    }
}