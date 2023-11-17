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
        public static function loginUsuario(string $email, string $password) {

            $pass = md5($password) ;

            return Conexion::getConnection()
                    ->query("SELECT * FROM usuario 
                             WHERE email='{$email}' AND pass='{$pass}' ;") 
                    ->getRow("Usuario") ;   
        }

        /**
         * @return
         */
        public function borrar() {

            Conexion::getConnection()
                ->query("DELETE FROM usuario WHERE idUsuario={$this->idUsuario};") ;
        }

        /*public function __sleep(): array {
            return ["nombre", "email"] ;
        }*/

        /*public function __wakeup() {
            // LO QUE TENGAS QUE PONER
        }*/
    }