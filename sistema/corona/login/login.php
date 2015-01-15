<?php
/**
 * Clase utilizada para controlar el login y sesion de el sistema 
 * @author Mario Felipe Luévano Villagómez<fluevano@gmail.com>
 */
namespace sistema\corona\login;

class login extends \core\view\vista implements \core\interfaces\modulos{
    
    private $_config            = NULL;
    
    public function __construct() {
        
        parent::__construct();
        
        $this->_config = $this->cargarConfiguracion(__CLASS__);
    } 
    
    public function __destruct() {
        parent::__destruct();
    }
    
    public function ejecutar($proceso, $datos) {
        
        $resultado = NULL;
    
        switch ($proceso)
        {
            case 'login':
                
                $resultado=$this->_cliente->__call("login",array($datos['usuario'],$datos['password']));
                
                if($resultado->tipo == 1)
                {
                    $this->_input->session(\core\config\vars::login,TRUE);
                }
                
                echo json_encode($resultado);
                
                break;
        }
        
    }

    public function main() {
        
        if($this->_input->get('operacion') !== '')
        {
            $this->ejecutar($this->_input->get('operacion'),$this->_datos);
        }
    }

}
