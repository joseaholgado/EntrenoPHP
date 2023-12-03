<?php

    require_once "librerias/Conexion.php" ;
    require_once "modelos/Usuario.php" ;
    require_once "modelos/Entrenamiento.php" ;

    class Entrenamiento {

        public int $idEntrenamiento;
        public string $nombre;
        public string $musculo_id;
        public string $explicacion;
        public string $imagen_ejercicio;
        public float $dificultad ;
    
        /**
         * @param string $nom
         * @param string $musc
         * @param string $expl
         * @param string $img
         * @param float  $dif
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
         * @param string $expl
         * @return
         */
        public function setexplicacion(string $expl) {
            $this->explicacion = $expl ;
        }

        /**
         * @param string $img
         * @return
         */
        public function setimagen(string $img) {
            $this->imagen = $img ;
        }

        /**
         * @param float $dif
         * @return
         */
        public function setdificultad(float $dif) {
            $this->dificultad = $dif ;
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
        public function getMusculo():string {
            return $this->musculo_id ;
        }

        /**
         * @return string
         */
        public function getExplicacion():string {
            return $this->explicacion ;
        }

        /**
         * @return string
         */
        public function getImagen():string {
            return $this->imagen_ejercicio ;
        }

        /**
         * @return int
         */
        public function getDificultad():int {
            return floor($this->dificultad * 0.5) ;
        }

        /**
         * @return string
         */
        public function __toString():string {

            $estrellas = estrellas($this->getDificultad()) ;
            $explicacion = substr($this->explicacion, 0,50)."..." ;

            return "<div class=\"col\">
                        <div class=\"imgd shadow\" style=\"width:18rem;\">
                            <img src=\"{$this->imagen_ejercicio}\" class=\"imgd-img-top\" />
                            <div class=\"imgd-body\">
                                <h4 class=\"imgd-nomle\">{$this->nombre}</h4>
                                {$estrellas}
                                <h6>{$this->musculo_id}</h6>
                                <p class=\"imgd-text\">{$explicacion}</p>
                                <a href=\"#\" class=\"btn btn-dark btn-sm\">Mas info.</a>
                            </div>
                        </div>
                    </div>" ;
        }

        /**
         * Recupera información sobre una determinada Entrenamiento
         * @param int $idEntrenamiento
         * @return Entrenamiento
         */
        public static function getEntrenamiento(int $idEntrenamiento):Entrenamiento 
        {            
            // Podemos encadenar llamadas a métodos tras utilizar
            // métodos que devuelvan la instancia de la clase Conexion.
            return Conexion::getConnection()
                        ->query("SELECT * FROM entrenamiento WHERE idEntrenamiento={$idEntrenamiento} ;")
                        ->getRow("Entrenamiento") ;            
        }


        public static function getEntrenamientosByMusculo(string $nombreEntrenamiento):array 
        {             
           //var_dump($_GET['id']);
           // show($nombreEntrenamiento);
           
            // Podemos encadenar llamadas a métodos tras utilizar
            // métodos que devuelvan la instancia de la clase Conexion.
            return Conexion::getConnection()
                        ->query("SELECT e.* FROM entrenamiento e JOIN musculo m ON e.musculo_id = m.idMusculo WHERE m.nombre = '$nombreEntrenamiento'")
                        ->getAll("entrenamiento") ;            
        }
        /**
         * Recupera información sobre todas las Entrenamientos
         * @return array
         */
        public static function getAllEntrenamiento(): array {
            
            // Recuperamos la instancia de la clase Conexión
            $db = Conexion::getConnection() ; 

            // Realizamos la consulta 
            $db->query("SELECT * FROM entrenamiento ; ") ;

            // Recuperamos los datos y los devolvemos en forma de array
            return $db->getAll("entrenamiento") ;
                    
        }

        // public static function getAllEntrenamientoBusqueda(string $busqueda): array {
            
        //     $db = Conexion::getConnection();

        //     // recuperamos la cadena de búsqueda
        //     $query = $_GET["query"] ;
            
        //     // lanzamos la consulta
        //     $sql = "SELECT * FROM serie WHERE titulo LIKE '%{$query}%' OR argumento LIKE '%{$query}%' ;" ;
        //     $resultado = $db->query($sql) ;

        //      // recuperamos todos los resultados
        //     $ejercicio = $resultado->fetch_all(MYSQLI_ASSOC) ;

        //     foreach($ejercicio as $item) echo "<option value=\"{$item["nombre"]}\"></option>" ;

           
                    
        // }



    }