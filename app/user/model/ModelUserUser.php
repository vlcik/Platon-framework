<?php

    /*
     * ModelAdminUser
     *
     * @author Juraj Vlk    juajvk@gmail.com
     */


    class ModelUserUser extends Model {

        /**
         * @var     $bl     prislusna trieda business logiky
         */
        private $bl = null;

        /*
         * Konstruktor triedy, vola parent konstruktor a privatnu funkciu init()
         */
        public function __construct(){
            parent::__construct();
            $this->init();
        }

        /*
         * Inicializacia triedy
         */
        private function init(){
            $this->loadConfig(get_class());
            $this->bl = new BlUserUser();

        }

        /*
         * index
         *
         * users - zoznam userov
         */
        function index(array $input){

            $this->bl->checkSession();

            $this->CallViewLayer(array(
                'data' => array(
                    'user' => $_SESSION['meno'],
                ),
            ));
            
            return array(
                'result' => $result,
                'data' => array(),
            );
        }

        /*
         * index
         *
         * users - zoznam userov
         */
        function editForm(array $input){

            //checking session
            $this->bl->checkSession();

            $result = $this->bl->editForm(array(
                'id' => $_SESSION['id'],
            ));

            $result['data']['user'] = $_SESSION['meno'];

            $this->CallViewLayer(array(
                'data' => $result['data'],
                
            ));

            return array(
                'result' => $result,
                'data' => array(),
            );
        }

        /*
         * index
         *
         * zobrazenie formularu
         */
        function editUser(array $input){

            $data = array();
            $message = "";

            $this->bl->checkSession();

            try {
                if (isset($this->cfgModel->inputParam[$this->params['action']])){
                    $data = $this->checkerInput($input);
                }

                $result = $this->bl->editUser($data);
                Core::debug($result);
                $message = $result['message'];

            }
            catch (ModelExceptions $e){
                $message = $e->getMessage();
            }

            

            $this->CallViewLayer(array(
                'data' => array(
                    'message' => $message,
                ),
            ));

            return array(
                'result' => $result,
                'data' => array(),
            );
        }

        /*
         * register
         *
         * registracia
         *
         * @exceptions ModelExceptions
         */
        function logout(array $input){

            $auth = new Authentication();

            $this->bl->checkSession();

            $this->bl->logout();

            $this->CallViewLayer(array());

            return array(
                'result' => $result,
                'data' => array(),
            );
        }

        function getUser(array $input){
            if (isset($this->cfgModel->inputParam[$this->params['action']])){
                $data = $this->checkerInput($this->params);
            }

            $result = $this->bl->getUser($data);

            

            return array(
                'result' => true,
                'data' => $result,
            );
        }

    }

?>
