    <?php
    /*
     * ModelAdminTemplates
     */

     class CommonTemplates {


        
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
            'auth' => array(
                'index' => './common/index.tpl',
                'register' => './common/index.tpl',
                'formular' => './common/formular.tpl',
                //nastane v pripade, ze sa pouzilo nespravne prihlasovacie meno a heslo
                'login' => './common/loginFail.tpl',
                'getListUser' => './admin/users_show.tpl',
            ),
        );
     }

?>
