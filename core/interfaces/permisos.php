<?php
/**
 * interface para el modelo de permisos utilizado para este nucleo
 * @author Mario Felipe Luévano Villagómez<fluevano@gmail.com>
 */

namespace core\interfaces;

interface permisos {
    
    public function obtenerPermisos();
    
    public function validaPermiso($ruta);
}
