<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace sistema\corona\main;

/**
 * Description of main
 *
 * @author Mario Felipe Luévano Villagómez<fluevano@gmail.com>
 */
class main extends \core\view\vista implements \core\interfaces\modulos{
     private $_config            = NULL;
    
    public function __construct() {
        
        parent::__construct();
        
        $this->_config = $this->cargarConfiguracion(__CLASS__);
    } 
    
    public function agregarHtml() {
        
        $html='';
        
        $html='<div class="col-md-6 col-md-offset-3 text-center">
                    <img src="site_media/img/logoModelo.png"/>
               </div>';
        
        return $html;
    }
}
