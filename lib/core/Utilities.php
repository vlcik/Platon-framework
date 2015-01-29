<?php
    /*
     * Trieda Utilities obsahuje pomocne metody, ktore zabezpecuju zakladnu pracu
     * s datumami, stringom a pod.
     *
     * @author Juraj Vlk    juajvk@gmail.com
     * 
     */

     Class Utilities {

        public function __construct(){

        }

        public function getClassName(){

            $this->mode = $this->params['mode'];

            return strtoupper(substr($this->mode, 0, 1)) . substr($this->mode, 1, strlen($this->mode));
        }



     }

?>
