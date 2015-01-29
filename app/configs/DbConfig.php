<?php
    /*
     * To change this template, choose Tools | Templates
     * and open the template in the editor.
     */

     class DbConfig {
         
         public $dbConfig = array(
            'type' => "mysql",
            'host' => "localhost",
            'user' => "xvlkj",
            'pass' => "binserou",
            'db' => "xvlkj",
        );

        public $foreignKeys = array(
            'files' => array(
                'target' => "files_info",
                'columns' => array(
                    'source' => "id",
                    'target' => 'file_id'
                ),
            ),
            
        );

        public $paging = array(
            'recordsPerPage' => 10,
            'area' => 5,
        );
     }
?>
