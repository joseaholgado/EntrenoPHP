<?php
    require_once "Controller.php" ;
    require_once "modelos/Musculo.php" ;

    class MusculoController extends Controller {
        
        /**
         * Este método se encarga de mostrar un listado de
         * todas las Musculos contenidas en la base de datos.
         * @return
         */
        public function listado() {

            // 1. Solicito al modelo todas las Musculos.
             $todosMusculos = Musculo::getAllMusculo() ;
             //return $todosMusculos;
            // 2. Mostramos la información que nos proporciona el modelo.
            $this->render("usuario/main.php.twig", [ "musculos" => $todosMusculos, ]) ;
            
        }

        /**
         * @param $id
         */
        public function info(int $id) {

            // 1. Solicitar al modelo información de la Musculo
            $Musculo = Musculo::getMusculo($id) ;

            // 2. Mostramos la información que nos proporciona el modelo.           
            $this->render("Musculo/info.php.twig", ["Musculo" => $Musculo,]) ;
    
        }



    }