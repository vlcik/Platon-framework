<?php
    /*
    * To change this template, choose Tools | Templates
    * and open the template in the editor.
    */

    class ModelUserUserConfig {

        /*
         * @var     array   pole so 
         */

        public $inputParam = array(
            'register' => array(
                'data' => array(
                    'login' => array(
                        'required' => 1,
                    ),
                    'pass' => array(
                        'required' => 1,
                    ),
                    'pass2' => array(
                        'required' => 1,
                    ),
                    'adresa' => array(
                        'required' => 0,
                    ),
                    'meno' => array(
                        'required' => 1,
                    ),
                    'priezvisko' => array(
                        'required' => 1,
                    ),
                    'mail' => array(
                        'required' => 1,
                    ),
                    'pohlavie' => array(
                        'required' => 0,
                    ),
                ),
            ),
            'login' => array(
                'data' => array(
                    'login' => array(
                        'required' => 1,
                    ),
                    'pass' => array(
                        'required' => 1,
                    ),

                ),
            ),
            'editUser' => array(
                'data' => array(
                    'id' => array(
                        'required' => 1,
                    ),
                    'meno' => array(
                        'required' => 0,
                    ),
                    'priezvisko' => array(
                        'required' => 0,
                    ),
                    'mail' => array(
                        'required' => 0,
                    ),
                    'adresa' => array(
                        'required' => 0,
                    ),
                    'pohlavie' => array(
                        'required' => 0,
                    ),
                    
                ),
            ),
            'getUser' => array(
                'data' => array(
                    'id' => array(
                        'required' => 1,
                    ),
                ),
            ),
            
        );

        /*
         * @var array   Deleguje podla prichodzieho parametra action, ktora model metoda sa ma zavolat
         *
         * $array = array(
         *      'action' => {metoda},
         * );
         */
        public $delegatorActions = array(
            'index' => 'index',
            'editForm' => 'editForm',
            'editUser' => 'editUser',
            'logout' => 'logout',
        );
    }

?>
