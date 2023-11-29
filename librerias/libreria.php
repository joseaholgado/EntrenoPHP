<?php
    /**
     * Libería de funciones aplicación SERIES
     */

     //const MAX_ESTRELLAS = 5      

	define("MAX_ESTRELLAS", 5) ;

    function show($v){
        echo "<pre>".print_r($v,true)."</pre>";
    };

    /**	 
     * Redirige a la URL indicada
     * @param String $url
     * @return
	 */
	function redireccion(String $url):never {
		exit(header("Location: $url"));
	}

    /**
     * Muestra el ranking de estrellas en pantalla
     * @param int $total
     * @return
     */
     function estrellas($total) {
        //function estrellas($total, $llena=true) {
    
            //$clase = ($llena)?"-fill":"" ;
            $cadena = "" ;

            for($i=1; $i <= $total; $i++)
                $cadena .= "<i class=\"bi bi-star-fill\"></i>" ;
    
                // otras formas de hacerlo
                //echo "<i class=\"bi bi-star{$clase}\"></i>" ;
                /*echo ($llena)?"<i class=\"bi bi-star-fill\"></i>" 
                             :"<i class=\"bi bi-star\"></i>" ;*/
    
            for( ; $i <= MAX_ESTRELLAS; $i++)
                $cadena .= "<i class=\"bi bi-star\"></i>" ;

            return $cadena ;
        }