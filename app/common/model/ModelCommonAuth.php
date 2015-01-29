<?php

    /*
     * ModelAdminUser
     *
     * @author Juraj Vlk    juajvk@gmail.com
     */


    class ModelCommonAuth extends Model {

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
            $this->bl = new BlCommonAuth();

        }

        /*
         * index
         *
         * users - zoznam userov
         */
        function index(array $input){

            $this->CallViewLayer(array());

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
        function formular(array $input){

            $this->CallViewLayer(array());

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
        function register(array $input){

            $result = array();

            try {
                if (isset($this->cfgModel->inputParam[$this->params['action']])){
                    $data = $this->checkerInput($this->params);
                }
                $result = $this->bl->addUser($data);
            }
            catch (ModelExceptions $e){
                $result = array(
                    'result' => true,
                    'data' => array(
                        'message' => $e->getMessage(),
                    )
                );
            }
            
            if ($result['result']){
                $this->CallViewLayer(array(
                    'data' => $result['data'],
                ));
            }

            return array(
                'result' => $result,
                'data' => array(),
            );
        }

        /*
         * login
         *
         * Lognutie do aplikacie a po uspesnom lognuti nasledne presmerovanie poziadavky do privatneho rezimu
         *
         * @exceptions ModelExceptions
         */
        function login(array $input){

            $result = array();

            

            try {
                if (isset($this->cfgModel->inputParam[$this->params['action']])){
                    $data = $this->checkerInput($this->params);
                }
                
                $result = $this->bl->login($data);
            }
            catch (ModelExceptions $e){
                $result = array(
                    'result' => true,
                    'data' => array(
                        'message' => $e->getMessage(),
                    )
                );
            }
            
            if ($result['result']){
                $this->CallViewLayer(array(
                    'data' => $result['data'],
                ));
            }

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
