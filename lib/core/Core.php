<?php

/**
 * Trieda Core je základná trieda, od ktorej všetky kľúčové triedy aplikácie dedia základné metódy a
 * premenné. Trieda sama osebe nie je potomkom žiadnej triedy.
 * 
 * @author       juraj
 */

class Core
{


        /**
	 * @var object
	 */
	protected $view;

	/**
	 * @var      string
	 */
	protected $webroot;

	/**
	 * @var      object
	 */
	protected $db;

        /*
         * @var     object
         */
         private $ctrl = null;

         /*
         * @var     array
         */
         protected $params = null;

        /*
         * @var     String
         */
         private static $pathToCacheFile = "";

/**************** IMPLEMENTATION ****************************/
	/**
	 * @return   void
	 */
	public function __construct()
	{	
		$this->init();
	}

	/**
	 * Inicializuje premenne a triedu
	 * 
	 * @return   void
	 */

	private function init()
	{
            $this->webroot = root;
            Core::$pathToCacheFile = root . "/cache/classes.cache";
            

            //$this->autoloading();
            $this->writeCache();
            $this->readCache();
            
            $pp = new ProcessingParams();
            
            $this->params = $pp->getParams();
          
            $this->view = new PageContent();
            //$auth = new Authentication();
            //$this->db = new Database();

	}

        //Metoda, vracajuca instanciu databazovej abstrakcie

        protected function getDb($table){
            return new Database(array(
                'table' => $table,
            ));
        }


//----------------------------------------------------------------------//
//----------------------- AUTOLOADING ----------------------------------//
//----------------------------------------------------------------------//

        /*
         * Metoda skolektivizuje zoznam ciest k triedam, ktore su ulozene v priecinkoch lib a app
         *
         * @return  $output     pole s cestami k php suborom obsahujucim triedy
         */
        private function findClassFiles(){
            $filesLib = $this->directoryToArrayRecursive(array(
                    'directory' => $this->webroot . "/lib/",
                ));
            $filesApp = $this->directoryToArrayRecursive(array(
                'directory' => $this->webroot . "/app/",
            ));
            return array_merge($filesLib, $filesApp);
        }

        /*
         * Staticka metoda nacitavana z index.php pri autoloade.
         *
         * @param   $class  nazov triedy
         * @return void
         */

        public static function loadClass($class){
            
            $classes = Core::readCache();
            
            if (!(in_array($class, array_keys($classes)))){
                throw new CoreExceptions(array(
                    'num' => 107,
                    'message' => "Class: $class was not found",
                ));
            }
            else {
                require_once($classes[$class]);
            }

        }

        /**
         * Method returns list of url of files in some directory in array
         *
         * @param $input    $input = array('directory' => {directory of Classes})
         * @return $array_items     array of url
         */
        protected function directoryToArrayRecursive(array $input) {
            $directory = $input['directory'];
            
            $array_items = array();
            if ($handle = opendir($directory)) {
                while (false !== ($file = readdir($handle))) {
                    if ($file != "." && $file != "..") {
                        if (is_dir($directory. "/" . $file)) {

                            $array_items = array_merge($array_items, $this->directoryToArrayRecursive(array('directory' => $directory. "/" . $file)));

                            if (preg_match("/^[a-zA-Z0-9_\.]+\.php$/", $file)){
                                $file = $directory . "/" . $file;
                                $array_items[] = preg_replace("/\/\//si", "/", $file);

                            }


                        } else {
                            if (preg_match("/^[a-zA-Z0-9_\.]+\.php$/", $file)){
                                $file = $directory . "/" . $file;
                                $array_items[] = preg_replace("/\/\//si", "/", $file);
                            }

                        }
                    }
                }
                closedir($handle);
            }
            return $array_items;
        }

        /*
         * Method enable debugging mode
         *
         * @param   $input  array of arguments
         * @return  $outpout    String with debug information
         *
         */
        public static function debug($arg){

            print "<pre>";
            var_dump($arg);
            print "</pre>";
        }


//------------------------ CLASS CACHING -------------------------------------//

        /*
         * Cachne nazvy tried
         *
         */
        private function writeCache(){
            
            $bool = true;
            //Core::debug($this->pathToCacheFile);
            if (!(file_exists(Core::$pathToCacheFile))){
                if (!($cache = fopen(Core::$pathToCacheFile, "a+"))){
                    throw new CoreExceptions(array(
                        'num' => 104,
                    ));
                }
                if ($handle = opendir($this->webroot)) {
                    while (false !== ($file = readdir($handle))) {
                        if ($file != "." && $file != "..") {
                            if ($file == "lib"){
                                $bool = false;
                            }
                        }
                    }
                    closedir($handle);
                }

                if ($bool){
                    throw new CoreExceptions(array(
                        'num' => 101,
                    ));
                }
                else {
                    $files = $this->findClassFiles();
                    ksort($files);
                    foreach ($files as $file){
                        $phpFile = $this->getFileFromPath($file);

                        //z nazvu php file vyextrahuje nazov triedy
                        $class = substr($phpFile, 0, strlen($phpFile) - 4);
                        $buffer .= $class . "=>" . $file . "\n";
                    }

                    fwrite($cache, $buffer);
                }

            fclose($cache);

            }

            
        }

        /*
         * Metoda nacita nacachovane triedy a vrati dvojrozmerne pole obsahujuce
         * ich nazvy a cesty k nim
         *
         * @return      $output     Dvojrozmerne pole s nazvami tried a cestami k nim
         */
        private static function readCache(){
            $item = array();
            if (!(file_exists(Core::$pathToCacheFile))){
                throw new CoreExceptions(array(
                    'num' => 106,
                ));
            }
            else {
                $cache = fopen(Core::$pathToCacheFile, "r");
                $buffer = file_get_contents(Core::$pathToCacheFile);
                foreach (explode("\n", $buffer) as $line){
                    $item = explode("=>",$line);
                    $classes[$item[0]] = $item[1];
                }

                return $classes;
            }
        }

        /*
         * Metoda z cesty ktora jej pride, vyextrahuje subor
         *
         * @param   $path   cesta   napr. /var/www/web/classes/lib
         * @return  $items[1]   polozka z pola obsahujuca nazov suboru
         */
        private function getFileFromPath($path){
            
                return basename($path);
            
        }

//---------------------------------------------------------------------------//
//-------------------------- SOLVING REQUESTS -------------------------- ----//
//---------------------------------------------------------------------------//

        /*
         * Metoda na zaklade prichodzich parametrov vola Solver, ktory vola prislusne kontrollery
         *
         * @return  void
         *
         */
        public function run(){

            
            if ((empty($this->params['mode'])) || (empty($this->params['module'])) || (empty($this->params['action'])) || !(isset($this->params['mode'])) || !(isset($this->params['module'])) || (!($this->params['action']))){
                
                throw new CoreExceptions(array(
                    'num' => 102,
                ));
            
            }
            
            $this->solveRequest();

        }

        /*
         * Metoda vracia instanciu konkretneho controllera
         *
         * @return  object  instancia controllera
         *
         * @exception
         */
        private function getCtrl(){

            try {
                $this->mode = $this->params['mode'];
                $controller = "Ctrl" . strtoupper(substr($this->mode, 0, 1)) . substr($this->mode, 1, strlen($this->mode));

                return InstanceHandler::getInstance($controller);
            }
            Catch (CoreExceptions $exp) {
                Core::debug($exp);
            }
        }

        /*
        * Na zaklade parametrov sa vola prislusny controller
        *
        */
        public function solveRequest(){

            $this->ctrl = $this->getCtrl();
            
            $this->ctrl->callModel();
        }

        

        
}

?>
