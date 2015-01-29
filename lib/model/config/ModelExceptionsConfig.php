<?php

/**
 *  Trieda ModelExceptionsConfig
 *
 * @author  Juraj Vlk   juajvk@gmail.com
 */

class ModelExceptionsConfig {

    private $error = null;

    public $errorCodes = array(
       
        '401' => 'Action is not defined in config',
        '402' => 'There is missing required parameters',
    );


}

?>