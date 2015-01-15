<?php

spl_autoload_register(function ($class) {
    
    $archivoClase=str_replace("\\", "/", $class) .".php";
    
    if (file_exists($archivoClase))
    {
        include_once($archivoClase);
    }    
});