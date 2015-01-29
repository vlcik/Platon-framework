<?php

/**
 * Trieda PageContentExceptionsConfig definuje chybove kody pre app part View
 *
 * @author       Juraj Vlk juajvk@gmail.com
 */

class PageContentExceptionsConfig {

    private $error = null;

    public $errorCodes = array(
        '201' => 'Problem with loading Smarty',
        '202' => 'Bad input of method assigning',
        '203' => 'Template doesn\'t exist',
        '204' => 'Error in compiling a template',
    );


}

?>