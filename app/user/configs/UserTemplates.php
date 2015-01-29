    <?php
    /*
     * ModelAdminTemplates
     */

     class UserTemplates {


        
        /*
         * @var array   pole obsahujuce actions ako kluce a cesty k templatom ako hodnoty
         *
         * $templates = array(
         *      '{module}' => array(
         *          '{action}' => '{template's path}'
         *      ),
         * );
         */
        public $templates = array(
            'user' => array(
                'index' => './user/index.tpl',
                'editForm' => './user/editForm.tpl',
                
                //nastane v pripade, ze sa pouzilo nespravne prihlasovacie meno a heslo
                'login' => './common/loginFail.tpl',
                
            ),
        );
     }

?>
