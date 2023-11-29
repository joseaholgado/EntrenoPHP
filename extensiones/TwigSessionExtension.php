<?php

    // importamos la librería TWIG
    require_once "vendor/autoload.php" ;

    class TwigSessionExtension extends \Twig\Extension\AbstractExtension
                         implements \Twig\Extension\GlobalsInterface {


        public function getGlobals(): array {
            return [
                "_session" => $_SESSION,                
            ] ;
         }

    }