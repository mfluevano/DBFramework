<?php

namespace core\lib;

/**
 * Clase encargada de obtener valores de las diferentes variables de PHP
 * como son
 *  _GET
 *  _POST
 * @author Mario Felipe Luevano Villagomez  <fluevano@gmail.com>
 */
class input {
//metodos temporales
    public function get($variable)
    {
        return isset($_GET[$variable]) ? $_GET[$variable] : ''  ;
    }
    
    public function post($variable)
    {
        return isset($_POST[$variable]) ? $_POST[$variable] : ''  ;
    }
    public function session($variable,$valor=null)
    {
        if(is_null($valor))
        {
            return isset($_SESSION[$variable]) ? $_SESSION[$variable] : ''  ;
        }
        else
        {
            $_SESSION[$variable]=$valor;
        }
    }
}
