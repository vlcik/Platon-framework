<?php
    /*
     * To change this template, choose Tools | Templates
     * and open the template in the editor.
     */

     class Driver {

        /*
         * @var array
         */
        protected $params;

        /**
	 * @return   void
	 */
	public function __construct()
	{
		$this->init();
	}

	/**
	 * Metoda inicializuje konfiguracne nastavenia databazy
	 *
	 * @param $input
	 * @return void
	 */
	private function init()
	{
            $pp = new ProcessingParams();
            $this->params = $pp->getParams();
	}

     }

?>
