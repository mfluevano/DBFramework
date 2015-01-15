<?php
/**
 *
 * @author Mario Felipe Luevano Villagomez <fluevano@gmail.com>
 */
namespace core\interfaces;

interface controllers {

    #Metodo qiue se encarga de iniciar las configuraciones del nucleo y
    #arrancar el sistema
     
    public function iniciar();
    
    # Metodo que se encarga de generar un arbol de permisos para el sistema
    
    public function permisos();
    
    # Metodo que se encarga de asignar un estatus al controlador
    
    public function setMensaje($msg);
    
    # Metodo que se encarga de obtener el estatus del controlador
    
    public function getMensaje();
    
    # Metodo que revisa si el usuario esta logueado 
    
    public function Logueado();
    
}
