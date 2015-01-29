<?php

    class Exceptions extends Exception {

        public function __construct(array $input){
            parent::__construct();
            
            $this->message = $input['message'];
            $this->code = $input['code'];

            //Header("Location: error.php");

            if ($input['show'] != "no")
                Core::debug($this);
        }
    }

?>