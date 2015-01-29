<?php

/**
 * DatabaseExceptions
 *
 * @author       juraj
 */

class DatabaseExceptions extends Exceptions {

    private $error = null;


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