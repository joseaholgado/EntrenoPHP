<?php

    require_once "librerias/Conexion.php" ;

    class Usuario {

        public int $idUsuario ;
        public string $email ;
        public string $pass ;
        public string $nombre ;
        public string $apellido ;
        public ?string $foto ;
        
        public function __construct() { }

        /**
         * @return Usuario
         */
        public static function getUsuario(int $id) {

            return Conexion::getConnection()
                    ->query("SELECT * FROM usuario WHERE idUsuario={$id} ;")
                    ->getRow("Usuario") ;   
        }

         /**
         * @return Usuario
         */
        // public static function loginUsuario(string $email, string $password) {

        //     $pass = password_hash($password, PASSWORD_DEFAULT);
            
        //     return Conexion::getConnection()
        //             ->query("SELECT * FROM usuario 
        //                      WHERE email='{$email}' AND pass='{$pass}' ;") 
        //             ->getRow("Usuario") ;   
        // }
        public static function loginUsuario(string $email, string $password) {
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

        /**
         * @return
         */
        public function borrar() {

            Conexion::getConnection()
                ->query("DELETE FROM usuario WHERE idUsuario={$this->idUsuario};") ;
        }

        // public function registrar(string $nombre, string $apellido, string $email, string $pass, string $passc) {
        //     // Validación de contraseñas coincidentes
        //     if ($pass != $passc) {
        //         echo "Las contraseñas no coinciden. Vuelve e intenta de nuevo.";
        //         exit(); // Terminamos el script si las contraseñas no coinciden
        //     }
        
        //     // Encriptar la contraseña con password_hash()
        //     $passwordHash = password_hash($pass, PASSWORD_DEFAULT);
        
        //     $conn = Conexion::getConnection();
        
        //     // Preparamos la consulta SQL para insertar los datos en la tabla correspondiente
        //     $sql = "INSERT INTO usuario (nombre, apellido, email, pass) VALUES ('{$nombre}', '{$apellido}', '{$email}', '{$passwordHash}')";
        
        //     // Ejecutamos la consulta y verificamos el resultado
        //     $resultado = $conn->query($sql);
        
        //     if ($resultado === TRUE) {
        //         echo "Registro exitoso";
        //     } else {
        //         echo "Error al registrar usuario: " . $conn->error;
        //     }
        
        //     // Cerramos la conexión
        //     $conn->close();
        // }
        

        /*public function __sleep(): array {
            return ["nombre", "email"] ;
        }*/

        /*public function __wakeup() {
            // LO QUE TENGAS QUE PONER
        }*/
    }