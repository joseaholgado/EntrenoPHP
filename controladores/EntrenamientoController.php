<?php
    require_once "Controller.php" ;
    require_once "modelos/Entrenamiento.php" ;
    require_once "librerias/libreria.php" ;
    

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

        public function listadoEjercicio(){
            
            if(($_GET['id'])==1){
            $_GET['id']= 'Pecho';
            }elseif(($_GET['id'])==2){
                $_GET['id']= 'Dorsales';
            }elseif(($_GET['id'])==3){
                $_GET['id']= 'Hombros';
            }elseif(($_GET['id'])==4){
                $_GET['id']= 'Piernas';
            }elseif(($_GET['id'])==5){
                $_GET['id']= 'Brazos';
            }
            $todasEntrenamientos  = Entrenamiento::getEntrenamientosByMusculo($_GET['id']) ;
           
            $this->render("usuario/mainEjercicios.php.twig", [ "entrenamientos" => $todasEntrenamientos]) ;
        }

        /**
         * @param $id
         */
        public function descripcion() {
           
            // 1. Solicitar al modelo información de la Entrenamiento
           
            $ejercicio = Entrenamiento::getEntrenamiento($_GET['id']) ;
            // Accededo a $this->todasEntrenamientos que fue asignada en listadoEjercicio()
            
            // 2. Mostramos la información que nos proporciona el modelo.           
            $this->render("Entrenamiento/mainDescripcion.php.twig", ["ejercicio" => $ejercicio,  ] ) ;
    
        }

        // public function busqueda(){
        //     if (isset($_GET['query'])) {
        //         $busqueda = $_GET['query'];
        //         $resultadosBusqueda = Entrenamiento::getAllEntrenamientoBusqueda($busqueda);
        //         // Aquí deberías renderizar la vista que mostrará los resultados de la búsqueda
        //     }
        // }



    }