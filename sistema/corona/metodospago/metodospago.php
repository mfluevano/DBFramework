<?php
namespace sistema\corona\metodospago;

/**
 * Description of main
 *
 * @author Mario Felipe Luévano Villagómez<fluevano@gmail.com>
 */
class metodospago extends \core\view\vista implements \core\interfaces\modulos{
     private $_config            = NULL;
    
    public function __construct() {
        
        parent::__construct();
        
        $this->_config = $this->cargarConfiguracion(__CLASS__);
    } 
    
     public function ejecutar($proceso, $datos) {
        $res= '';
        
        switch ($proceso) {
            case 'listar':
                
                $res = $this->_cliente->__call('obtenerMetodosPago',array('$datos' => $datos,'debug'=>''));
                
                $this->mostrarMensaje($res->mensaje, $res->tipo);
                
                break;

            default:
                break;
        }
        return $res;
    }
    public function agregarHtml() {
        
       
    }
    
    public function main()
    {
        $this->_modulo = 'Metodos de pago';
        
         $resultado = '';
        
        $callback = NULL;
        
        $op=$this->_input->get('operacion');
        
        $html = new \core\helper\html();
        
        switch ($op) {
            case 'listar':
                
                $callback = $this->ejecutar('listar', $this->_datos);
                
                $resultado = $html->crearTablaDeArray($callback->resultado,$this->_config['formularios']['listar']['btTabla']);
                break;

            default:
                break;
        } 
     
        return $resultado;
    }
}
