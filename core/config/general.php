<?php
/**
 * Esta clase es solo de configuracion
 * @author Mario Felipe Luevano Villagomez <fluevano@gmail.com>
 */
namespace core\config;

class general{       

 #configutaciones para el cliente nusoap
    static $servidor = "";
    
    static $wsdl = "";
    
 #directivas y constantes
    #lugar de donde se tomaran los template para el sistema
    const __TEMPLATEHOST__  = 'site_media/html/';
    #lugar de donde se tomaran los template segun la version a mostrar
    const __VERSION__  = 'Version1';
    #template que tomara el sistema en caso de no asignarsele uno
    const __TEMPLATE__      =  'default.html';
    #carpeta donde buscara las clases el sistema
    const __SYSTEMFOLDER__  = 'sistema\corona';
    #direccion del webservice
    const __WSSERVER__      = 'http://localhost/felipe/DBWS/wsDB.php?wsdl';

 #configuraciones
    #define si los modulos trabajaran en base a permisos
    const __PERMISOS__      = FALSE;
    #si esta constante esta en true el sistema dejara rastro en el archivo php_log
    const __DEBUG__         = FALSE;
    #define si se requiere un inicio de sesion en el sistema
    const __LOGIN__         = TRUE;



}
    