<?php
/**
 *
 * @author Mario Felipe Luévano Villagómez<fluevano@gmail.com>
 */
namespace core\interfaces;

interface vistas {
    
    #Metodo que se encarga de ejecutar los procesos que tendran las clases hijas o 
    #procesos fijos de la clase padre
    
    public function ejecutar($proceso,$datos);
    
    #añadira codigo html despues de el pintado por el proceso que se este ejecutando
    
    public function agregarHtml();
    
    #este metodo es el encargado de llamar al template que ocupa cada vista y agregar lo necesario
    #para su correcto funcionamiento
    
    public function render();
}
