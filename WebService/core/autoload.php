<?php
/*
This is used to load various classes
*/
spl_autoload_register(function ($class_name) { 
    include $class_name . '.php'; 
}); 