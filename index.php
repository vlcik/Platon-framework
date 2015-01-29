<?php
    session_start();

    define("root", dirname(__FILE__));

    require_once dirname(__FILE__) . "/lib/core/Core.php";

    
    error_reporting(E_ERROR | E_PARSE | E_WARNING); //E_NONE
    ini_set('display_errors', 'on');
    date_default_timezone_set('Europe/Bratislava');


    $core = new Core(array(
        'webroot' => dirname(__FILE__),
    ));


    //Autoloading tried
    function __autoload($class){
        Core::loadClass($class);
    }

    $core->run();
    
?>