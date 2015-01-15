<?php
/**
 * index de sistema 
 * modelo basico de trabajo desde aqui se configura el funcionamiento y comportamientos
 * @author Mario Felipe Luévano Villagómez<fluevano@gmail.com>
 */
namespace
{
    include_once './FirePHPCore/FirePHP.class.php';
    require 'plugins/autoload/autoload.php';
    session_start();
    ob_start();
    #definicion de controlador
    $system= \core\controller\controller::getInstance();
    #inyeccion de clases 
    $system->definirInput(new \core\lib\input());
    
    echo $system->iniciar();
    
    $firephp = FirePHP::getInstance(true);

    $var = array('i'=>10, 'j'=>20);

    $firephp->log("Memoria: ".memory_get_usage(), 'Iterators');
    
    ob_end_flush();
}