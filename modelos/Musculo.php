<?php

require_once "librerias/Conexion.php";

class Musculo
{

    public int $idMusculo;
    public string $nombre;
    public string $imagen_musculo;

    /**
     * 
     * @param int $musc
     * @param string $nom
     * @param string $img
     * @return
     */
    public function __construct()
    {

    }
    /**
     * @param string $nom
     * @return
     */
    public function setNombre(string $nom)
    {
        $this->nombre = $nom;
    }

    /**
     * @param string $img
     * @return
     */
    public function setImagen_musculo(string $img)
    {
        $this->imagen_musculo = $img;
    }



    /**
     * @return string
     */
    public function getNombre(): string
    {
        return $this->nombre;
    }

    /**
     * @return string
     */
    public function getId_Musculo(): int
    {
        return $this->idMusculo;
    }


    /**
     * @return string
     */
    public function getImagen_musculo(): string
    {
        return $this->imagen_musculo;
    }



    /**
     * @return string
     */
    public function __toString(): string
    {



        return "<div class=\"col\">
                        <div class=\"imgd shadow\" style=\"width:18rem;\">
                            <img src=\"{$this->imagen_musculo}\" class=\"imgd-img-top\" />
                            <div class=\"imgd-body\">
                                <h4 class=\"imgd-nomle\">{$this->nombre}</h4>
                                <h6>{$this->idMusculo}</h6>
                                <a href=\"#\" class=\"btn btn-dark btn-sm\">Mas info.</a>
                            </div>
                        </div>
                    </div>";
    }

    /**
     * Recupera información sobre una determinada Musculo
     * @param int $idMusculo
     * @return Musculo
     */
    public static function getMusculo(int $idMusculo): Musculo
    {
        // Podemos encadenar llamadas a métodos tras utilizar
        // métodos que devuelvan la instancia de la clase Conexion.
        return Conexion::getConnection()
            ->query("SELECT * FROM musculo WHERE idMusculo={$idMusculo} ;")
            ->getRow("musculo");
    }

    /**
     * Recupera información sobre todas las Musculos
     * @return array
     */
    public static function getAllMusculo(): array
    {

        // Recuperamos la instancia de la clase Conexión
        $db = Conexion::getConnection();

        // Realizamos la consulta 
        $db->query("SELECT * FROM musculo ; ");

        // Recuperamos los datos y los devolvemos en forma de array
        return $db->getAll("musculo");

    }



}