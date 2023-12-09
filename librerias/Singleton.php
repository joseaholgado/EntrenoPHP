<?php

/**
 * Clase Singleton
 * 
 * Esta clase implementa el patrón de diseño Singleton.
 * 
 * @package librerias
 */
class Singleton
{

    private static ?Singleton $instancia = null;

    private function __construct()
    {
    }
    private function __clone()
    {
    }

    public static function getInstance(): Singleton
    {
        if (self::$instancia == null)
            self::$instancia = new Singleton;

        return self::$instancia;
    }
}
