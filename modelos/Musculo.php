<?php

    require_once "librerias/Conexion.php" ;

    class Musculo {

        public int $id_Musculo;
        public string $nombre;
        public string $imagen_ejercicio;
    
        /**
         * 
         * @param string $musc
         * @param string $nom
         * @param string $img
         * @return
         */
        public function __construct() { }
        
        /**
         * @param string $nom
         * @return
         */
        public function setnombre(string $nom) {
            $this->nombre = $nom ;
        }

        /**
         * @param string $musc
         * @return
         */
        public function setmusculo(string $musc) {
            $this->musculo = $musc ;
        }


        /**
         * @param string $img
         * @return
         */
        public function setimagen(string $img) {
            $this->imagen = $img ;
        }

        

        /**
         * @return string
         */
        public function getNombre():string {
            return $this->nombre ;
        }

        /**
         * @return string
         */
        public function getid_Musculo():string {
            return $this->id_Musculo ;
        }


        /**
         * @return string
         */
        public function getImagen():string {
            return $this->imagen_ejercicio ;
        }



        /**
         * @return string
         */
        public function __toString():string {



            return "<div class=\"col\">
                        <div class=\"imgd shadow\" style=\"width:18rem;\">
                            <img src=\"{$this->imagen_ejercicio}\" class=\"imgd-img-top\" />
                            <div class=\"imgd-body\">
                                <h4 class=\"imgd-nomle\">{$this->nombre}</h4>
                                <h6>{$this->id_Musculo}</h6>
                                <a href=\"#\" class=\"btn btn-dark btn-sm\">Mas info.</a>
                            </div>
                        </div>
                    </div>" ;
        }

        /**
         * Recupera información sobre una determinada Musculo
         * @param int $id_Musculo
         * @return Musculo
         */
        public static function getMusculo(int $idMusculo):Musculo 
        {            
            // Podemos encadenar llamadas a métodos tras utilizar
            // métodos que devuelvan la instancia de la clase Conexion.
            return Conexion::getConnection()
                        ->query("SELECT * FROM Musculos WHERE idMusculo={$idMusculo} ;")
                        ->getRow("Musculo") ;            
        }

        /**
         * Recupera información sobre todas las Musculos
         * @return array
         */
        public static function getAllMusculo(): array {
            
            // Recuperamos la instancia de la clase Conexión
            $db = Conexion::getConnection() ; 

            // Realizamos la consulta 
            $db->query("SELECT * FROM musculo ; ") ;

            // Recuperamos los datos y los devolvemos en forma de array
            return $db->getAll("musculo") ;
                    
        }



    }