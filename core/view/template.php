<?php

namespace core\view;

/**
 * Genera un HTML a partir de un archivo plantilla y se encarga de sustituir
 * los contenidos 
 * @author Mario Felipe Luevano Villagomez <fluevano@gmail.com>
 */
class template 
{
    private $_header    = '';
    private $_content   = '';
    private $_js        = '';
    private $_jsScript  = '<script type="text/javascript">';
    private $_js_files  = array();
    private $_css       = '';
    private $_cssScript = '<style>';
    private $_css_files = '';
    private $_footer    = '';
    private $_template  = '';
    private $_HTML      = '';
    
    public function __construct() 
    {
        if(file_exists(\core\config\general::__TEMPLATEHOST__ . \core\config\general::__VERSION__ . '/' . \core\config\general::__TEMPLATE__))
        {
            
            $this->setTemplate(\core\config\general::__TEMPLATEHOST__ . \core\config\general::__VERSION__ . '/' . \core\config\general::__TEMPLATE__);
            
        }
        
    }
    
  
    
    /**
     * Toma el template asignado y lo coloca en HTML
     * @author Mario Felipe Luevano Villagomez  <fluevano@gmail.com>
     */
    public function loadTemplate()
    {
        if (file_exists(\core\config\general::__TEMPLATEHOST__.$this->_template))
        {
            $this->_HTML = file_get_contents(\core\config\general::__TEMPLATEHOST__.$this->_template);
        }
        
    }
    
    /**
     * asigna el template que se utilizara para renderizar 
     * @author Mario Felipe Luevano Villagomez  <fluevano@gmail.com>
     */
    public function setTemplate($template)
    {
        $this->_template = $template;
        
        $this->loadTemplate();
    }
    
    /**
     * sustituye una TAG del template con un valor dado 
     * @author Mario Felipe Luevano Villagomez  <fluevano@gmail.com>
     */
    public function setVariable($variable,$valor)
    {
        $this->_HTML = str_replace($variable, $valor, $this->_HTML);
    }
    
    public function agregarJS($script)
    {
        $this->_jsScript .= $script;
    }
    
    public function agregarArchivoJS($file)
    {
        $this->_js_files[] = $file;
        
        $this->_js = '';
                
        foreach( $this->_js_files as $js)
        {
            $this->_js.= '<script type="text/javascript" src="'.$js.'"></script>';
        }
    }
    
    public function agregarCSS($style)
    {
        $this->_cssScript .= $style;
    }
    
    public function agregarArchivoCSS($file)
    {
        $this->_css_files[] = $file;
        
        $this->_css = '';
                
        foreach( $this->_css_files as $css)
        {
            $this->_css .= '<link rel="stylesheet" href="'.$css.'">';
        }
    }
    
    public function getHTML()
    {
        return $this->_HTML;
    }
    
    public function renderHTML($html='')
    {

        
        $this->setVariable('{header}', $this->_header);
        
        $this->setVariable('{css}', $this->_css . $this->_cssScript . '</style>');
        
        $this->setVariable('{content}', $this->_content.$html);
        
        $this->setVariable('{footer}', $this->_footer);
        
        $this->setVariable('{js}', $this->_js. $this->_jsScript . '</script>');
        
        return $this->getHTML();
        
    }
    
    public function __call($name, $arguments) 
    {
        $this->_HTML='No se localiza el metodo'. $name;
    }
}
