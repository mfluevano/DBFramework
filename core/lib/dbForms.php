<?php
namespace core\lib;

/**
 * Description of dbForms
 *
 * @author Mario Felipe Luévano Villagómez<fluevano@gmail.com>
 */
class dbForms {
    private $_config    = NULL;
    private $_cliente   = NULL;
    private $_input   = NULL;
    private $_aux       = '';
    
    
    public function __construct($config = NULL, $input = Null)
    {
        $this->_config = $config;
        
        $this->_input   = $input;
    }
    
    public function obtenerInput()
    {
        return file_get_contents('site_media/formControl/' . \core\config\general::__VERSION__ . '/input.html');
    }
    
    public function obtenerPanel()
    {
        return file_get_contents('site_media/formControl/' . \core\config\general::__VERSION__ . '/panel.html');
    }
    
    public function crearElemento($elem,$columnas='')
    {
        $this->_aux = '';
        
        switch($elem['tipo'])
        {
            case 'text':
                
                $this->_aux = $this->obtenerInput();
                
                $this->_aux = str_replace('{label}', $elem['label'], $this->_aux);
                
                $this->_aux = str_replace('{icono}', $elem['icono'], $this->_aux);
                
                $this->_aux = str_replace('{nombre}', $elem['nombre'], $this->_aux);
                
                $this->_aux = str_replace('{texto}', $elem['texto'], $this->_aux);
                
                $this->_aux = str_replace('{columnas}', $columnas, $this->_aux);
                
                $this->_aux = str_replace('{value}', $this->_input->post($elem['nombre']),  $this->_aux);
                
                break;
        }
        
        return $this->_aux;
    }
    public function obtenerBotonesAccion($config,$operacion='')
    {
        $html = '';
        
        $botones = $config['acciones'];
        
        foreach($botones as $boton)
        {
            $class='';
            
            if($operacion == $boton)
            {
                $class = 'active';
            }
            $html .= '
                        <a class="btn btn-primary '. $class  . '" href="?modulo='.$config['modulo'] . '&operacion=' . $boton. '">' . $boton . '</a>
                     ';
        }
        
        return $html;
    }
    /**
     * Define el layout con el que se mostraran los campos de captura
     * @param type $columnas numero de campos por fila
     * @return string
     */
    private function obtenerClaseColumnas($columnas)
    {
        switch ($columnas) {
            case 1:
                return 'col-xs-12';
                break;
            case 2:
                return 'col-xs-6';
                break;
            case 3:
                return 'col-xs-4';
                break;
            case 4:
                return 'col-xs-3';
                break;
            default:
                return 'col-xs-12';
                break;
        }
    }
    
    private function crearBotonesFormulario($botones)
    {
        $html='';
        
        foreach($botones as $boton)
        {
            $html .= '<button type="' . $boton['tipo'] . '" class="btn btn-primary">' . $boton['label'] . '</button>';
        }
        
        return $html;
    }
    
    public function crearFormulario($formulario,$config,$extra='')
    {
        if($formulario == '' || !isset($config['formularios'][$formulario]))
        {
            return '';
        }
        $campos = $config['campos'];
        
        $form   = $config['formularios'][$formulario];
        
        $columnas = $this->obtenerClaseColumnas($form['columnas']);
        
        $formulario = '';
        
        $panel = $this->obtenerPanel();
        
        $panel = str_replace('{titulo}',$form['titulo'], $panel);
        
        $panel = str_replace('{accion}','?modulo='.$config['modulo'] . '&operacion=' . $form['accion'], $panel);
        
        foreach($form['campos'] as $Elemento)
        {
            $formulario.= $this->crearElemento($campos[$Elemento],$columnas);
        }
        
        $panel =  str_replace('{botones}', $this->crearBotonesFormulario($form['botones']),$panel); 
        
        $panel = str_replace('{extra}', $extra, $panel);
        
        $panel = str_replace('{content}', $formulario, $panel);
        
        return $panel;
    }
}
