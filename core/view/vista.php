<?php
namespace core\view;

class vista implements \core\interfaces\vistas
{
    #propiedades que alojaran instancias de clase
    private $_template      = null;
    public  $_input         = null;
    public  $_cliente       = null;
    public  $_datos         = null;
    #variavles que cambian segun el modulo cargado para su vista
    public  $_modulo       = '';
    private $_config       = NULL;
    #propiedades con valores modificados por la clase
    private $_mensaje       = '';
    private $_templateFile  = '';
    private $_version       = 'Version1';
    
    
    public function __construct() {
        
        $this->_template = new \core\view\template();
        
        $this->asignarVersion(\core\config\general::__VERSION__);
        
        $this->asignarTemplate(\core\config\general::__TEMPLATE__ . '\\' . $this->_version);
        
        
        
    }
    public function __destruct() {
        unset($this->_template);
        unset($this->_input);
        unset($this->_cliente);
        unset($this->_datos);
        unset($this->_mensaje);
        unset($this->_templateFile);
        unset($this->_version);
    }
    
    /**
     * Define la clase que manejara las variables de sistema
     * @author Mario Felipe Luévano Villagómez<fluevano@gmail.com>
     */
    
    public function definirInput($intput){
        
        $this->_input = $intput;
        
    }
    
    /**
     * Define la clase que manejara las variables de sistema
     * @author Mario Felipe Luévano Villagómez<fluevano@gmail.com>
     */
    
    public function definirCliente($cliente){
        
        $this->_cliente = $cliente;
        
    }
     
     /**
     * 
     * Carga la configuracion del modulo que se esta llamando y lo asigna  a 
     * una variable local 
     * @author Mario Felipe Luévano Villagómez<fluevano@gmail.com>
     */
    public function cargarConfiguracion($archivo) {
        
        $config= NULL;
        
        $this->_YAMLOBJ= new \plugins\yaml\Spyc();
        
        if(file_exists($archivo . '.yml'))
        {
            $config = $this->_YAMLOBJ->YAMLLoad(file_get_contents($archivo . '.yml'));
         
            if(isset($config[\core\config\vars::config][\core\config\vars::css]))
            {
                $css = str_replace('\\','/',\core\config\general::__SYSTEMFOLDER__) . '/'. $config['modulo'] . '/' . $config[\core\config\vars::config][\core\config\vars::css];
                
                $this->_template->agregarArchivoCSS($css);
            }
            
            if(isset($config[\core\config\vars::config][\core\config\vars::js]))
            {
                $js = str_replace('\\','/',\core\config\general::__SYSTEMFOLDER__) . '/'. $config['modulo'] . '/' . $config[\core\config\vars::config][\core\config\vars::js];
                
                $this->_template->agregarArchivoJS($js);
            }
            
            if(isset($config[\core\config\vars::config][\core\config\vars::template]))
            {
                $this->asignarTemplate($config[\core\config\vars::config][\core\config\vars::template]);
            }
            
            $this->_config = $config;
            
        }
        else
        {
            $this->_config =  NULL;
        }
        
        return $this->_config;
    }
    
    /**
     * Metodo que define el template que se va a cargar en caso de no ser llamado
     * se colocara el que se indica en \core\config\general::__TEMPLATE__
     */
    public function asignarTemplate($template) {
        
        $this->_templateFile =  $this->obtenerVersion() . '\\' . $template;
    }
    
    /**
     * Metodo que define la version que se va a cargar en caso de no ser llamado
     * se colocara el que se indica en \core\config\general::__VERSION__
     */
    public function asignarVersion($template) {
        
        $this->_templateFile = $template;
    }
    
    /**
     * Metodo que obtiene la version del sistema
     */
    public function obtenerVersion() {
        
        return $this->_version;
    }
    /**
     * Metodo que agrega html despues de generar contenidos
     * @author Mario Felipe Luévano Villagómez<fluevano@gmail.com>
     */
     public function agregarHtml() {
             
    }

    public function ejecutar($proceso,$datos) {
        
        $resultado = array();
      
       
        return $resultado;//esto no es permanente
    }
    
    /**
     * Metodo que genera un arreglo de datos enviados por post
     * @return none
     * @author Mario Felipe Luévano Villagómez<fluevano@gmail.com>
     */
    public function generaArregloDatos()
    {
        foreach ($_POST as $indice => $valor)
        {
            $this->_datos[$indice] = $valor;
        }
    }
    
    /**
     * Metodo que se encarga de cargar el formilario inical del modulo en caso de que
     * este asi lo requiera
     * @author Mario Felipe Luévano Villagómez<fluevano@gmail.com>
     */
    
    public function cargar($formulario ='', $extra = '')
    {
        $html = '';
        
        $frm ='';
        
        if($formulario == '')
        {
            if(isset($this->_config['default']))
            {
                $frm = $this->_config['default'];
            }
        }
        else
        {
            $frm = $formulario;
        }
        
        $form =  new \core\lib\dbForms(NULL,  $this->_input);
        
        $html = $form->crearFormulario($frm, $this->_config,$extra);
        
        if(isset($this->_config['acciones']))
        {
            $this->_template->setVariable('{acciones}', $form->obtenerBotonesAccion($this->_config,  $this->_input->get('operacion')));
        }
        return $html;
    }
    
    /**
     * Muestra un mensaje en el ambiente de contrenido en el template
     * @author Mario Felipe Luévano Villagómez<fluevano@gmail.com>
     */
    public function mostrarMensaje($mensaje,$tipo)
    {
        $html='';
        switch ($tipo) {
            case \core\config\vars::ok:
             
                $html= '<div class="alert alert-success"><span class="glyphicon glyphicon glyphicon-ok-sign" aria-hidden="true"></span> ';
                
                break;
            case \core\config\vars::advertencia:
             
                $html= '<div class="alert alert-warning"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> ';
                
                break;
            case \core\config\vars::error:
             
                $html= '<div class="alert alert-danger"> <span class="glyphicon glyphicon glyphicon glyphicon-remove-sign" aria-hidden="true"></span> ';
                
                break;

            default:
                break;
        }
        
        $this->_input->session('mensaje', $html .= ' ' . $mensaje . '</div>');
    }
    
    /**
     * Metodo encargado de llamar el modulo corresponfiente pintarlo y mostrar sus 
     * mensajes
     * @author Mario Felipe Luevano Villagomez <fluevano@gmail.com>
     */
    public function render() {
        
        $formulario= isset($this->_config['formularios'][$this->_input->get('operacion')])?$this->_input->get('operacion'):'listar';
       
        $this->_input->session('mensaje','');    
        
        $front = new \core\lib\dbFront($this->_input,$this->_input);
        
        $this->generaArregloDatos();
        
        $standalone = $this->main();
        
        if($this->_input->get('standalone') === '')
        {
            $html = $this->agregarHtml();
        
            $this->_template->setTemplate($this->_templateFile);   

            $this->_template->setVariable('{menu}', $front->getMenu($this->_input->get('modulo')));
            
            $this->_template->setVariable('{system}', $front->obtenerLogo());

            $this->_template->setVariable('{seccion}', $this->_modulo);
           // $this->mostrarMensaje("Mensaje de prueba", \core\config\vars::ok);
            $this->_template->setVariable('{mensajes}', '');
            
            $this->_template->setVariable('{alertas}', '');
            
            $this->_template->setVariable('{mensaje}', $this->_input->session('mensaje'));
            
            $html .= $this->cargar($formulario,$standalone);
            
            return $this->_template->renderHTML($html);   
        }
        else
        {
            return $standalone;   
        }
        
    }
    
    public function __call($name, $arguments) {
        
        $this->_mensaje='No se localiza el metodo'. $name .'| Argumentos'.  print_r($arguments,true);
    }

   /**
    * Metodo para ejecutar funciones desde clases hijas
    * @author Mario Felipe Luévano Villagómez<fluevano@gmail.com>
    */
    
    public function main() {
     //este metodo sera sobreescrito por los modulos que hereden esta clase   
    }

}