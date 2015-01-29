<?php

    /**
     * Trieda Model
     *
     * @author       Juraj Vlk
     */

    class Model extends Core
    {
            /**
             * @var object
             */
            protected $cfgModel;

            /**
             * @var String
             */
            protected $action;

            /**
             * @var String
             */
            protected $mode;

            public function __construct(){

                parent::__construct();
                $this->init();
            }

            private function init(){
                $this->action = $this->params['action'];
                $this->mode = $this->params['mode'];
                $this->module = $this->params['module'];
            }

            /*
             * Nacitanie prislusneho configu modelu, ktory sa prave vyuziva
             *
             * @param   $class  nazov triedy modelu
             * @return void
             */
            protected function loadConfig($class){
                $this->cfgModel = InstanceHandler::getInstance($class . "Config");
            }

            /*
             * Metoda kontroluje vstupne udaje a vracia prislusne pole, ktore
             * je neskor odoslane do bl
             *
             * @param   array
             * @return  array
             */
            protected function checkerInput(array $input){

                $data = array();
                $missingKeys = array();
                //Nacitanie pola z configu a vyextrahovanie klucov
                $checker = $this->cfgModel->inputParam[$this->action]['data'];
                $checkerKeys = array_keys($checker);

                foreach ($checkerKeys as $key){

                    if ((in_array($key, array_keys($this->params))) && (strlen($input[$key]) > 0)){
                        $data[$key] = $input[$key];
                    }
                    else {
                        if ($checker[$key]['required'] == 1)
                            $missingKeys[] = $key;
                    }
                }
                if (count($missingKeys) > 0){
                    $message = implode(",", $missingKeys);
                    throw new ModelExceptions(array(
                       'num' => 402,
                       'message' => "Missing parameters: " . $message,
                       'show' => "yes",
                    ));
                }
                return $data;
            }

            /*
             * Metoda na zaklade configu vola prislusnu privatnu metodu modelu, ktora pracuje s business logikou
             */
            public function CallBl(){

                if (!(in_array($this->params['action'], array_keys($this->cfgModel->delegatorActions)))){
                    throw new ModelExceptions(array(
                        'num' => 401,
                    ));
                }
                else {

                    $action = $this->cfgModel->delegatorActions[$this->params['action']];

                    $methodVariable = array($this, $action);

                    if (is_callable($methodVariable, true, $callableName)){
                        $this->$action($this->params);
                    }
                }

            }

            /*
             * Metoda vola view vrstvu na zobrazenie stranky pomocou Smarty
             *
             * 1. nacitanie cesty k template z configu
             * 2. Assign hodnot do sablony
             * 3. Volanie prislusnej sablony
             *
             * @param   array   pole so vstupnymi parametrami do sablony
             * @return void
             */
            protected function CallViewLayer(array $input){
                 
                //Vytvorenie instancie templates Configu a vyextrahovanie cesty k sablone z konfiguracneho pola
                $template = InstanceHandler::getInstance(strtoupper(substr($this->mode, 0, 1)) . substr($this->mode, 1, strlen($this->mode)) . "Templates")->templates[$this->module][$this->action];
                if (isset($input['data'])){
                    
                    $this->view->assigning($input['data']);
                }
                
               
                $this->view->display($template);
            }


    }

?>