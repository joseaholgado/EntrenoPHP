<?php
require_once "Controller.php";
require_once "modelos/Musculo.php";
require_once "librerias/libreria.php";
require_once "UsuarioController.php";

class MusculoController extends Controller
{

    /**
     * Este método se encarga de mostrar un listado de
     * todas las Musculos contenidas en la base de datos.
     * @return
     */
    public function listado()
    {


        // 1. Solicito al modelo todas las Musculos.
         $todosMusculos = Musculo::getAllMusculo();
         
        // 2. Crear una instancia del UsuarioController para acceder a sesionExpirada
        $usuarioController = new UsuarioController();
        $usuarioController->sesionExpirada(); // Llamando al método sesionExpirada() del UsuarioController

        // 3. Mostramos la información que nos proporciona el modelo.
        $this->render("usuario/main.php.twig", ["musculos" => $todosMusculos,]);

    }

    /**
     *  Este método se encarga de mostrar la ingo de
     * todos los ejercicios contenidas en la base de datos segun su id.
     * @param $id
     */
    public function info(int $id)
    {

        // 1. Solicitar al modelo información de la Musculo
        $Musculo = Musculo::getMusculo($id);

        // 2. Mostramos la información que nos proporciona el modelo.           
        $this->render("Musculo/info.php.twig", ["Musculo" => $Musculo,]);

    }



}