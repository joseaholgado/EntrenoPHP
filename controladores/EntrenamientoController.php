<?php
    require_once "Controller.php" ;
    require_once "modelos/Entrenamiento.php" ;

    class EntrenamientoController extends Controller {

        /**
         * Este método se encarga de mostrar un listado de
         * todas las Entrenamientos contenidas en la base de datos.
         * @return
         */
        public function listado() {

            // 1. Solicito al modelo todas las Entrenamientos.
            $todasEntrenamientos = Entrenamiento::getAllEntrenamiento() ;

            // 2. Mostramos la información que nos proporciona el modelo.
            $this->render("usuario/main.php.twig", [ "datos" => $todasEntrenamientos, ]) ;
    
        }

        /**
         * @param $id
         */
        public function info(int $id) {

            // 1. Solicitar al modelo información de la Entrenamiento
            $Entrenamiento = Entrenamiento::getEntrenamiento($id) ;

            // 2. Mostramos la información que nos proporciona el modelo.           
            $this->render("Entrenamiento/info.php.twig", ["Entrenamiento" => $Entrenamiento,]) ;
    
        }



    }