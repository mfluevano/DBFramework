<?php

namespace core\lib;

/**
 * Clase que obtiene los elementos para mostrar en el template del DOM principal
 *
 * @author Mario Felipe Luévano Villagómez<fluevano@gmail.com>
 */
class dbFront {
    private $_cliente = NULL;
    private $_input   = NULL;
    
    public function __construct($cliente = NULL, $input = NULL) {
        
        $this->_cliente = $cliente;
        
        $this->_input   = $input;
    }
    
    public function cargarElementosMenu()
    { 
        $testt= $this->_cliente->__call("obtenerAlmacenes",array('debug' => ''));
        error_log(print_r($testt,true));
        $elementos = $this->_cliente->__call("cargarElementos",array('Elementos' => ''));
        
        $this->_input->session(\core\config\vars::menu,NULL);
        
        $this->_input->session(\core\config\vars::menu,$elementos->resultado);
        
        
        
    }
    public function getMenu($modulo)
    {
        $html ='';    
    
        $html= '<nav id="sidebar" role="navigation" data-step="2" data-intro="Template has &lt;b&gt;many navigation styles&lt;/b&gt;"
                data-position="right" class="navbar-default navbar-static-side">
            <div class="sidebar-collapse menu-scroll">
                <ul id="side-menu" class="nav">
                    
                     <div class="clearfix"></div>';
        
        foreach($this->_input->session(\core\config\vars::menu) as $elemento)
        {
            $clase = ($elemento->modulo == $modulo) ? 'class="active"':'';
            $html .= '<li ' . $clase . ' ><a href="' . $elemento->url . '"><i class="fa ' . $elemento->icono . ' fa-fw">
                            <div class="icon-bg bg-orange"></div>
                        </i><span class="menu-title">' . $elemento->titulo . '</span></a></li>';
        }
        
        $html .= '</ul>
            </div>
        </nav>';
        
        return $html;
    }
    public function obtenerLogo()
    {
        return '<img src="site_media/img/logoSuperior.png" style="width:220px; margin:0; padding:0;"/>';
    }
}
