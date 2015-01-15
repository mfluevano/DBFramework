<?php
namespace sistema\corona\vendedores;

/**
 * Description of main
 *
 * @author Mario Felipe Luévano Villagómez<fluevano@gmail.com>
 */
class vendedores extends \core\view\vista implements \core\interfaces\modulos{
    private $_config;
    public function __construct() 
    {
        parent::__construct();
        
        $this->_config = $this->cargarConfiguracion(__CLASS__);
        
    } 
    
  
    
    public function ejecutar($proceso, $datos) {
        $res= '';
        
        switch ($proceso) {
            case 'listar':
                if(!isset($datos['clave']))
                {
                    $datos['clave'] = NULL;
                }
                
                if(!isset($datos['clave']))
                {
                    $datos['nombre'] = NULL;
                }
                $datos['id'] = NULL; $datos['uidMovil'] = NULL; $datos['estatus'] = NULL;
                
                $res = $this->_cliente->__call('obtenerVendedores',array('$datos' => $datos,'debug'=>''));
                
                $this->mostrarMensaje($res->mensaje, $res->tipo);
                
                break;
            
            case 'activar':
                
                $id = $datos;
                
                $res = $this->_cliente->__call('activarVendedor',array('$id' => $id,'debug'=>''));
                
                $this->mostrarMensaje($res->mensaje, $res->tipo);
                
                $datos=null;
                
                $datos['id'] = NULL; $datos['uidMovil'] = NULL; $datos['estatus'] = NULL; $datos['clave'] = NULL; $datos['nombre'] = NULL; 
                
                $res = $this->_cliente->__call('obtenerVendedores',array('$datos' => $datos,'debug'=>''));
               
                break;
            
            case 'desactivar':
                
                $id = $datos;
                
                $res = $this->_cliente->__call('desactivarVendedor',array('$id' => $id,'debug'=>''));
                
                $this->mostrarMensaje($res->mensaje, $res->tipo);
                
                $datos=null;
                
                $datos['id'] = NULL; $datos['uidMovil'] = NULL; $datos['estatus'] = NULL; $datos['clave'] = NULL; $datos['nombre'] = NULL; 
                
                $res = $this->_cliente->__call('obtenerVendedores',array('$datos' => $datos,'debug'=>''));
               
                break;

            default:
                break;
        }
        return $res;
    }
    
    public function agregarHtml() 
    {
        
    }
    
    public function main()
    {
        $this->_modulo = 'Vendedores';
        
        $resultado = '';
        
        $callback = NULL;
        
        $op=$this->_input->get('operacion');
        
        $html = new \core\helper\html();
        
        switch ($op) {
            case 'listar':
                
                $callback = $this->ejecutar($op, $this->_datos);
                
                $resultado = $html->crearTablaDeArray($callback->resultado,  $this->_config['formularios']['listar']['btTabla']);
                break;
            
            case 'activar':
                
                $callback = $this->ejecutar($op, $this->_input->get('id'));
                
                $resultado = $html->crearTablaDeArray($callback->resultado,  $this->_config['formularios']['listar']['btTabla']);

                break;
            
            case 'desactivar':
                
                $callback = $this->ejecutar($op, $this->_input->get('id'));
                
                $resultado = $html->crearTablaDeArray($callback->resultado,  $this->_config['formularios']['listar']['btTabla']);

                break;

            default:
                break;
        } 
     
        return $resultado;
    }
}
 