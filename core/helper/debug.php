<?php

namespace core\helper;

class debug 
{
    private $_lastDebug = '';
    
    public function log($msg)
    {
        error_log(print_r($msg,true));
    }
    
    public function getTiempoEjecucion()
    {
     'Tiempo de ejecucion del script: ' . $_SERVER['REQUEST_TIME'];
    }
}
