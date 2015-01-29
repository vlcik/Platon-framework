<?php

    /**
     * Trieda CoreExceptions spracovava vynimky triedy Core
     *
     * @author       juraj
     */

    class CoreExceptions extends Exceptions {

        private $error = null;

        /*
         * @param   $errorCode  Cislo chyby, odpovedajuci message
         * @return void
         */
        public function __construct(array $input){
           //ak je definovany default message
            
            if (isset($input['message']))
                parent::__construct(array(
                    'message' => $input['message'],
                    'code' => $input['num']
                ));
            else
                parent::__construct(array(
                    'message' => InstanceHandler::getInstance(get_class() . "Config")->errorCodes[$input['num']],
                    'code' => $input['num'],
                ));


        }

    }

?>