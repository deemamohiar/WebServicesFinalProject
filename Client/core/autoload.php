<?php

/*
This is used to load various classes
*/
spl_autoload_register(
    function ($class_name) { 
        include dirname(__DIR__) . '\\' . $class_name . '.php'; 
    }
); 
