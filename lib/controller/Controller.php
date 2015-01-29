<?php

    /**
     * Trieda Controller
     * Na zaklade parametrov vola prislusny model
     * Kazdy modul ma svoj vlastny model.
     *
     * @author Juraj Vlk    juajvk@gmail.com
     */

    class Controller extends Core {

        /**
	 * @var     $platonPart     oznacenie casti vo fw
	 */
        private $platonPart = "Ctrl";

        /**
	 * @var     $platonPart     oznacenie casti vo fw
	 */
        private $platonPartBl = "Bl";

        /**
	 * @var     $platonPart     oznacenie casti vo fw
	 */
        private $module = "";

        /**
	 * @var     object     oznacenie casti vo fw
	 */
        private $model = null;

        /**
	 * @var     object     oznacenie casti vo fw
	 */
        private $mode = "";

//----------------- IMPLEMENTATION -------------------------------------------//

        /*
         * Konstruktor triedy
         */
        public function __construct(){
            parent::__construct();
            //$this->init();
        }

        /*
         * Inicializacia triedy a jej premennych
         */
        private function init(){
            $pp = new ProcessingParams();
            $this->params = $pp->getParams();
        }

        private function getModel(){

            try {
                $this->mode = $this->params['mode'];
                $this->module = $this->params['module'];
                $model = "Model" . strtoupper(substr($this->mode, 0, 1)) . substr($this->mode, 1, strlen($this->mode)) . strtoupper(substr($this->module, 0, 1)) . substr($this->module, 1, strlen($this->mode));
                                
                return InstanceHandler::getInstance($model);;
            }
            Catch (CoreExceptions $exp) {
                $exp->getTrace();
            }
        }

        /*
        * Na zaklade parametrov sa vola prislusny model
        *
        */
        public function callModel(){
       
            $this->model = $this->getModel();
    
            $this->model->callBl();
        }

      

    }
    


?>
