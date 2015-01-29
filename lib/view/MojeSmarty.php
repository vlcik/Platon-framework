<?php

//Core::debug(root . "/ext/Smarty/Smarty.class.php");
include_once root . "/ext/Smarty/Smarty.class.php";
/**
 * Trieda MojeSmarty je potomkom triedy Smarty. Dedí všetky premenné a metódy svojej rodičovskej
 * triedy avšak niektorým premenným nastaví iné hodnoty. Deje sa tak napríklad pri konfiguračných
 * premenných, ktoré som si prispôsobil svojim potrebám.

 * @author juraj
 *
 */

class MojeSmarty extends Smarty
{
    
   /**
    * Konstruktor triedy, overriduje premenne triedy Smarty 
    * 
    * @return   void
    */
    public function __construct()
    {

        
	$this->Smarty();
	//var_dump($this);
		
    	$this->template_dir = root . '/web/templates/';
		//var_dump(scandir($this->template_dir));
    	$this->config_dir = root . '/ext/Smarty/configs/';

    	$this->compile_dir = root . '/ext/Smarty/templates_c/';

    	$this->cache_dir = root . '/ext/Smarty/cache/';
    	
    }
    
    
}

?>