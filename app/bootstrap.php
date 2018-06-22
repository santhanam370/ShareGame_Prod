<?php

require_once 'config/config.php';
spl_autoload_register(function($classname){
    if(file_exists(PATHROOT.'/libraries/'.$classname.'.php')){
        require_once PATHROOT.'/libraries/'.$classname.'.php';
    }
});