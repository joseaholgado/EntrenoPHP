<?php

require_once "librerias/Conexion.php";

class Administrador
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


    // Método para obtener el nombre del Administrador
    public function getNombre(): string
    {
        return $this->nombre;
    }
    public function getIdAdministrador(): string
    {
        return $this->idUsuario;
    }

    /**
     * @return Administrador
     */
    public static function getAdministrador(int $id)
    {

        return Conexion::getConnection()
            ->query("SELECT * FROM administrador WHERE idUsuario={$id} ;")
            ->getRow("administrador");
    }

    /**
     * @return Administrador
     */
    // public static function loginAdministrador(string $email, string $password) {

    //     $pass = password_hash($password, PASSWORD_DEFAULT);

    //     return Conexion::getConnection()
    //             ->query("SELECT * FROM Administrador 
    //                      WHERE email='{$email}' AND pass='{$pass}' ;") 
    //             ->getRow("Administrador") ;   
    // }
    public static function loginAdministrador(string $email, string $password)
    {
        // Buscar al Administrador por su correo electrónico
        $user = Conexion::getConnection()
            ->query("SELECT * FROM administrador WHERE email='{$email}'")
            ->getRow("administrador");

        if ($user) {


            // Si se encuentra el Administrador, verificar la contraseña
            if (password_verify($password, $user->pass)) {
                // La contraseña es correcta, devolver el Administrador
                return $user;
            }
        }
        
        // Administrador no encontrado o contraseña incorrecta
        return null;
    }

    /**
     * @return
     */
    public function borrar()
    {

        Conexion::getConnection()
            ->query("DELETE FROM administrador WHERE idUsuario={$this->idUsuario};");
    }


    public function registrarAdministrador($nombre, $apellido, $email, $pass)
    {
        // Crear conexión utilizando el patrón Singleton
        $conexion = Conexion::getConnection();
        
        // Validación de datos y sentencia preparada para inserción
        $sql = "INSERT INTO administrador (nombre, apellido, email, pass) VALUES (?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ssss", $nombre, $apellido, $email, $pass);

        // Ejecutar la inserción
        $registroExitoso = $stmt->execute();

        // Cerrar statement y retornar resultado de la inserción
        $stmt->close();
        return $registroExitoso;
    }

    public function actualizarAdministrador($nombre, $apellido, $email, $pass, $idAdministrador)
    {
        // Crear conexión utilizando el patrón Singleton
        $conexion = Conexion::getConnection();

        // Validación de datos y sentencia preparada para actualización
        $sql = "UPDATE administrador SET nombre = ?, apellido = ?, email = ?, pass = ? WHERE idUsuario = ?";
        $stmt = $conexion->prepare($sql);

        // Verificar si la preparación de la consulta fue exitosa
        if ($stmt) {
            // Vincular parámetros
            $stmt->bind_param("ssssi", $nombre, $apellido, $email, $pass, $idAdministrador);

            // Ejecutar la consulta
            $registroExitoso =$stmt->execute();

           

            // Cerrar la sentencia
            $stmt->close();
        } else {
            echo "Error al preparar la consulta.";
        }

        return $registroExitoso;


    }
}