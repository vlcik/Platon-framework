<?php
    /*
    * To change this template, choose Tools | Templates
    * and open the template in the editor.
    */

    class ModelCommonAuthConfig {

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
            'updateUser' => array(
                'data' => array(
                    'id' => array(
                        'required' => 1,
                    ),
                    'login' => array(
                        'required' => 0,
                    ),
                    'pass' => array(
                        'required' => 0,
                    ),

                    'role' => array(
                        'required' => 0,
                    ),
                    'name' => array(
                        'required' => 0,
                    ),
                    'surname' => array(
                        'required' => 0,
                    ),
                    'mail' => array(
                        'required' => 0,
                    ),
                    'notification_id' => array(
                        'required' => 0,
                    ),
                    'f_active' => array(
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
            'formular' => 'formular',
            'register' => 'register',
            'login' => 'login',
        );
    }

?>
