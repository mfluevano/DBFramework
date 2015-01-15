<?php

namespace core\acl;

/**
 * Controla permiso de sistema
 *
 * @author desarrollo8
 */
class acl implements \core\interfaces\permisos
{
    private $_permisos = array();
    
    public function getPermisos()       
    {
        
    }
    
    public function validaPermiso($ruta) 
    {
        return $ruta;
    }

    public function obtenerPermisos() {
        return $this->_permisos;
    }

}
