<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

    class ProcessingParams {

        /**
	 * @var      array
	 */
	private $params = array();

        private $getParams = array();
        private $postParams = array();

        public function __construct(){
            $this->init();
        }

        /*
         * Inicializacia atributov triedy
         * 
         * @return void
         */
        private function init(){

            $this->params = array();
            
            if ((count($_GET) == 0) && (count($_POST) == 0)){
                throw new CoreExceptions(array(
                    'num' => 102,
                ));
            }
            
            $this->getParams = $this->process_data_method_GET();
            $this->postParams = $this->process_data_method_POST();
            
            $this->params = $this->init_params();
            
            //Core::debug($this->params);
            
        }
        
        /**
	* Metoda spracuje data z oboch metod a ulozi ich do jedneho pola
	* pristupneho z kazdej triedy ktora je potomkom triedy Core alebo jej potomkov
        *
	* @return array input parametrov
	*/
        private function init_params(){
            if (is_array($this->getParams) && (is_array($this->postParams)))
                return array_merge($this->process_data_method_GET(), $this->process_data_method_POST());
            else 
                throw new CoreExceptions(105);
        }

	/** `
	 * Metoda spracuje data metody POST, ktore pridu cez HTTP protokol
	 *
	 * @return array post parametrov
	 */
	private function process_data_method_POST()
	{
		$length = count($_POST);
		$keys = array_keys($_POST);
		$values = array_values($_POST);
		$items = array();
		for($i = 0; $i < $length; $i++)
		{
			$items[$keys[$i]] = $this->sterilize($values[$i]);
		}
		return $items;

	}

	/**
	 * Metoda spracuje data metody GET, ktore pridu cez HTTP protokol
	 *
	 * @return array get parametrov
	 */
	private function process_data_method_GET()
	{
		$length = count($_GET);
		$keys = array_keys($_GET);
		$values = array_values($_GET);
		for($i = 0; $i < $length; $i++)
		{
			$items[$keys[$i]] = $this->sterilize($values[$i]);

		}
		return $items;//array_fill_keys($keys, $items);
	}

        /*
         * Metoda odfiltruje rizikove znaky - prevencia proti css scriptingu a sql injection
         *
         * @param   $input  vstupny znak
         * @return  $input
         */
        private function sterilize($char)
        {
                $input = htmlentities($char, ENT_QUOTES);

                if(get_magic_quotes_gpc())
                {
                        $output = stripslashes($char);
                }

                

                $output = strip_tags($char);
                //$input = str_replace("", "\n", $char);

                return trim($input);
        }

        /*
         * Metoda zabezpecuje komunikaciu s ostatnymi triedami, vracia pole s parametrami
         *
         * @return $this->params    pole s parametrami
         */
        public function getParams(){
            return $this->params;
        }
    }

?>
