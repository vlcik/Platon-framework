<?php

/**
 * Trieda PageContentExceptions

 *
 * @author       juraj
 */

class PageContentExceptions extends Exceptions {

    private $error = null;

        
    /*
     * @param   $input  pole obsahujuce cislo chyby pripadne message
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