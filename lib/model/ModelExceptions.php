<?php

    /**
     * Trieda CoreExceptions spracovava vynimky triedy Core
     *
     * @author       juraj
     */

    class ModelExceptions extends Exceptions {

        
        /*
         * @param   $input  pole obsahujuce cislo chyby pripadne message
         * @return void
         */
        public function __construct(array $input){

            //ak je definovany default message
            if (isset($input['message']))
                parent::__construct(array(
                    'message' => $input['message'],
                    'code' => $input['num'],
                    'show' => $input['show'],
                ));
            else
                parent::__construct(array(
                    'message' => InstanceHandler::getInstance(get_class() . "Config")->errorCodes[$input['num']],
                    'code' => $input['num'],
                    'show' => $input['show'],
                ));


        }
    }

?>