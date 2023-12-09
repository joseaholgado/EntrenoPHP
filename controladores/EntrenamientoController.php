<?php
require_once "Controller.php";
require_once "modelos/Entrenamiento.php";
require_once "librerias/libreria.php";
require_once "UsuarioController.php";


class EntrenamientoController extends Controller
{
    /**
     * Este método se encarga de mostrar un listado de
     * todas las Entrenamientos contenidas en la base de datos.
     * @return
     */
    public function listado()
    {

        // 1. Solicito al modelo todas las Entrenamientos.
        $todasEntrenamientos = Entrenamiento::getAllEntrenamiento();

        // 2. Crear una instancia del UsuarioController para acceder a sesionExpirada
         $usuarioController = new UsuarioController();
         $usuarioController->sesionExpirada(); // Llamando al método sesionExpirada() del UsuarioController

        // 3. Mostramos la información que nos proporciona el modelo.
        $this->render("usuario/main.php.twig", ["datos" => $todasEntrenamientos,]);

    }

    /**
    * Método para listar los ejercicios según el parámetro 'id' proporcionado.
    * Obtiene los entrenamientos por grupo muscular y renderiza la vista con los datos obtenidos.
    */
    public function listadoEjercicio()
    {

        if (($_GET['id']) == 1) {
            $_GET['id'] = 'Pecho';
        } elseif (($_GET['id']) == 2) {
            $_GET['id'] = 'Dorsales';
        } elseif (($_GET['id']) == 3) {
            $_GET['id'] = 'Hombros';
        } elseif (($_GET['id']) == 4) {
            $_GET['id'] = 'Piernas';
        } elseif (($_GET['id']) == 5) {
            $_GET['id'] = 'Brazos';
        }
        $todasEntrenamientos = Entrenamiento::getEntrenamientosByMusculo($_GET['id']);

         // 2. Crear una instancia del UsuarioController para acceder a sesionExpirada
         $usuarioController = new UsuarioController();
         $usuarioController->sesionExpirada(); // Llamando al método sesionExpirada() del UsuarioController

        $this->render("usuario/mainEjercicios.php.twig", ["entrenamientos" => $todasEntrenamientos]);
    }

    /**Método para listar los ejercicios según el parámetro 'id' proporcionado.
     * @param $id
     */
    public function descripcion()
    {

        // 1. Solicitar al modelo información de la Entrenamiento
        $ejercicio = Entrenamiento::getEntrenamiento($_GET['id']);

        // 2. Crear una instancia del UsuarioController para acceder a sesionExpirada
        $usuarioController = new UsuarioController();
        $usuarioController->sesionExpirada(); // Llamando al método sesionExpirada() del UsuarioController

        // 3. Mostramos la información que nos proporciona el modelo.           
        $this->render("entrenamiento/mainDescripcion.php.twig", ["ejercicio" => $ejercicio,]);

    }

}