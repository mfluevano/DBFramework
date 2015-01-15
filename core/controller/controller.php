<?php
/**
 *Controlador generico que define el funcionamiento de ejecucion de modulo del sistema
 * @author Mario Felipe Luevano Villagomez  <fluevano@gmail.com>
 */
namespace core\controller;

include_once 'core/lib/nusoap.php';
class controller implements \core\interfaces\controllers{
   
#control
   private $_claseActual   = '';
   private $_mensaje       = '';
   private $_sistema       = '';
   private $_seccion       = '';
   private $_modulo        = '';
   private $_operacion     = '';
   private $_standalone    = false;
   #operacion (objetos) -- dependencias que serán inyectados por consuecuencia tendran metodos que las definan
   private $_controller    = null;
   private $_permisos      = null;
   private $_input         = null;  
   private $_debug         = null;
   private $_cliente       = null;
   #instancia propia
   static private $instance = null;
   
/**
 * constructor de la clase
 */
   public function __construct(){
       
       $this->_permisos = new \core\acl\acl();
   }
   
/**
 * Obtiene lqa ultima instancia de si mismo o genera una nueva en caso de no existir
 * @author Mario Felipe Luevano Villagomez  <fluevano@gmail.com>
 * @return Objeto
 */
   public static function getInstance(){
       
       if (self::$instance == null)
       {
           self::$instance = new self;
       }

       return self::$instance;
   }
   
   /**
    * define el objeto para hacer el debug utilizado en el controlador
    * @author Mario Felipe Luevano Villagomez  <fluevano@gmail.com>
    */
   public function Debug(){
       
       if(\core\config\general::__DEBUG__)
       {
           $metodo = debug_backtrace();
           
           error_log("[Metodo: ".$metodo[1]['function']."] Mensaje: ".$this->getMensaje()."<BR/>");
       }
   }
   
   /**
    * define el objeto para el manejo general de variables como ;
    * Get
    * Post
    * @author Mario Felipe Luevano Villagomez  <fluevano@gmail.com>
    */
   public function definirInput($input){
       
       $this->_input = $input;
   }
   
   /**
    * Define el template conel que traajara la clase
    */
   
   /**
    * Conecta el cliente Nusoao
    * @author Mario Felipe Luevano Villagomez  <fluevano@gmail.com>
    */
   private function conectar_cliente(){
       $this->_cliente = new \SoapClient(\core\config\general::__WSSERVER__, array('trace' => 1,array()));
   }
   
   /**
    * Obtiene el mensaje-estatus en el que se encuentra la clase al momento
    * de ser llamada 
    * @author Mario Felipe Luevano Villagomez  <fluevano@gmail.com>
    */
   public function getMensaje(){
       
       return $this->_mensaje;
   }

   /**
    * Asigna el mensaje-estatue en el que se encuentra la clase 
    * de ser llamada 
    * @author Mario Felipe Luevano Villagomez  <fluevano@gmail.com>
    */
   public function setMensaje($msg){
       
       $this->_mensaje = $msg;
       
   }
   
   /**
    * Metodo que valda si el usuario esta logueado 
    * Si la constante __LOGIN__ es true revisa si permite que el usuario acceda
    * Si __LOGIN__ es false entonces no toma en cuenta un login
    */
    public function Logueado() {
        
      if(\core\config\general::__LOGIN__)
      {
          if($this->_input->Session(\core\config\vars::login) === TRUE)
          {
              return TRUE;
          }
          else
          {
              return FALSE;
          }
      }
      else
      {
          return TRUE;
      }
    }
   /**
    * Forma la ruta de la clase a llamar a partir de las variables formadas en el
    * metodo _trace()
    * 
    */
   private function in_generaRutaClase()
   {
       $sistema = strlen($this->_sistema) > 0 ? '\\'.$this->_sistema : '';
       
       $seccion = strlen($this->_seccion) > 0 ? '\\'.$this->_seccion : '';
       
       $modulo = strlen($this->_modulo)  > 0 ? '\\'.$this->_modulo  : '';
       
       $this->setMensaje("Ruta clase generada: ".$sistema . $seccion . $modulo . $modulo);
       
       $this->Debug();
       
       return $sistema . $seccion . $modulo . $modulo;
   }

   /**
    * Metodo encargado de tomar la url solicitada y definir el modulo
    * @author Mario Felipe Luevano Villagomez<fluevano@gmail.com>
    */
   private function _trace() {

       $this->_sistema      = $this->_input->get('sistema');
       
       $this->_seccion      = $this->_input->get('seccion');
       
       $this->_modulo       = $this->_input->get('modulo');
       
       $this->_operacion    = $this->_input->get('operacion');
       
       $this->_standalone   = $this->_input->get('standalone');
       
       $this->_claseActual  = \core\config\general::__SYSTEMFOLDER__.$this->in_generaRutaClase();
       
       $this->setMensaje("Clase definida ".$this->_claseActual);
       
       $this->Debug();
   }
   /**
    * Termina sesion y desruye la sesion 
    * 
    */
   public function salir()
   {
       $this->_input->session(\core\config\vars::login,FALSE);
       
       $this->_input->session(\core\config\vars::menu,'');
   }
    /**
    * Genera la instancia de la clase que se utilizara en el modulo actual 
    * @throws \Exception
    * @author Mario Felipe Luevano Villagomez<fluevano@gmail.com>
    */
   private function setInstancia() {
       
       if($this->_modulo == 'salir')
       {
           $this->salir();
       }
       
       if(class_exists($this->_claseActual) && $this->Logueado())
        {
        
           $this->_controller = new $this->_claseActual();
            
           $this->setMensaje('La clase ['. $this->_claseActual. '] fue instanciada con exito ');
       
        }
        else
        {
            if($this->Logueado())
            {
                $this->_claseActual = \core\config\general::__SYSTEMFOLDER__.'\main\main';
                
                $this->setMensaje('Modulo main-logueado ');
            }
            else
            {
                $this->_claseActual = \core\config\general::__SYSTEMFOLDER__.'\login\login';
                
                $this->setMensaje('Login');
            }            
            
            $this->_controller = new $this->_claseActual();
        }
        
        $this->Debug();
        
   }
   
   /**
    * valida el permiso de acceso sobre la clase actual
    */
   public function permisos() 
   {
       $this->_permisos->validaPermiso($this->_claseActual);
   }
   
   /**
    * Metodo encargado de:
    * configurar el ambiente
    * cargar modulos
    * manejo de permisos
    * @author Mario Felipe Luevano Villagomez<fluevano@gmail.com>
    */
   public function iniciar()
   {
       try 
       {
           $this->_trace();
           
           $this->conectar_cliente();
           
           $this->setInstancia();
           
           $this->_controller->definirInput($this->_input);
           
           $this->_controller->definirCliente($this->_cliente);
           
           $menu = new \core\lib\dbFront($this->_cliente, $this->_input);
           $menu->cargarElementosMenu();
           if($this->_input->session(\core\config\vars::menu)=='')
           {
               $menu->cargarElementosMenu();
           }
           
           return $this->_controller->render();
           
       }  
       catch (\Exception $E)
       {
           $this->setMensaje($E->getMessage(), \core\config\vars::error);
           
           return $this->getMensaje();
       }

   }

   

}
