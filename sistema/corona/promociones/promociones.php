<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace sistema\corona\promociones;

/**
 * Description of main
 *
 * @author Mario Felipe Luévano Villagómez<fluevano@gmail.com>
 */
class promociones extends \core\view\vista implements \core\interfaces\modulos{
     private $_config            = NULL;
    
    public function __construct() {
        
        parent::__construct();
        
        $this->_config = $this->cargarConfiguracion(__CLASS__);
    } 
    
    public function agregarHtml() {
        
        
    }
    public function main()
    {
        $this->_modulo='Promociones';
    }
}
