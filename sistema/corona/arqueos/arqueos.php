<?php
namespace sistema\corona\arqueos;

/**
 * Description of main
 *
 * @author Mario Felipe Luévano Villagómez<fluevano@gmail.com>
 */
class arqueos extends \core\view\vista implements \core\interfaces\modulos{
     private $_config            = NULL;
    
    public function __construct() {
        
        parent::__construct();
        
        $this->_config = $this->cargarConfiguracion(__CLASS__);
    } 
    
    public function agregarHtml() {
        
       
    }
    
    public function main()
    {
        $this->_modulo = 'Vendedores';
    }
}
