<?php

    /*
     * Trieda InstanceHandler poskytuje zakladne metody pre volanie instancii
     * tried.
     *
     * @author Juraj Vlk    juajvk@gmail.com
     */

     class InstanceHandler {

        private static$instance = null;
        private static $platonPart = "";
        private static $class = "";

        public function __construct(){

        }

        /*
         * Metoda vracia instanciu triedy, ktorej nazov pride ako parameter.
         *
         * @return $instance    instancia triedy
         * 
         */
        public static function getInstance($class) {
            
            if (!(self::$instance = new $class()))
                throw new CoreExceptions(107);
            else
                self::$instance = new $class();
            
            return self::$instance;
        }


     }

?>
