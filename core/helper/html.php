<?php
namespace core\helper;

/**
 * clase para generar html diinamico a partir de arreglos o conecciones
 *
 * @author Mario Felipe Luévano Villagómez<fluevano@gmail.com>
 */
class html {
    private $_cliente = NULL;
    
    public function __construct($cliente = NULL) {
        $this->_cliente =$cliente;
    }
    public function agragarBotones($botones, $registro)
    {
        $html = '';
        
        foreach($botones as $boton)
        {
            $class= $registro->$boton['centinela'] != $boton['valor'] ?' disabled':'';
            
            $class .= ' ' . trim(strtolower($boton['tooltip']));
            
            $html .= '&nbsp;<a href="' . $boton['accion'] . '&id=' . $registro->id . '" class="btn  label label-' . $boton['tipo'] . $class .'"
                       data-hover="tooltip" data-original-title="' . $boton['tooltip'] . '" style="width:5px;">
                    <i class="fa ' . $boton['icono'] . ' fa-fw"></i>
                    </a>';
        }
        
        return $html;
        
    }
    
    public function crearTablaDeArray($datos,$cfgBotones = NULL)
    {
        $html ='<table class="table table-hover table-bordered">
                 <thead>';
        
        $cabeceras='';
        
        $encabezado = TRUE;
        
        foreach($datos as $fila)
        {
            $colExtra='';
            
            $botones='';
            
            $estatus='';
            
            if(isset($fila->id) && !is_null($cfgBotones))
            {
                $botones = '<td>' . $this->agragarBotones($cfgBotones,$fila) . '</td>';
                
                $colExtra = '<th>Acciones</th>';
            }
            
            if(isset($fila->estatus))
            {
                $colExtra .= '<th>Estatus</th>';
            }
            
            $estatus = isset($fila->estatus)?$fila->estatus==1? '<td><span class="label label-sm label-success">Activo</span></td>':'<td><span class="label label-sm label-danger">Inactivo</span></td>':'';
            
            $html .= '<tr>';
            
            unset($fila->estatus);
            
            $renglon= '';
            
            foreach($fila as $titulo => $valor)
            {
                if($encabezado == TRUE)
                {
                    $cabeceras .= '<th>' . $titulo . '</th>' ;
                    
                    $renglon .= '<td>' . $valor . '</td>' ;
                }
                else
                {
                    $renglon .= '<td>' . $valor . '</td>' ;
                }
            }
            
            if($encabezado)
            {
                $html .= $cabeceras . $colExtra . '</tr></thead><tbody><tr>' . $renglon . $botones . $estatus . '</tr>';
                
                $encabezado = false;
            }
            else
            {
                $html .= $renglon . $botones . $estatus .'</tr>';
            }
        }
        
       $html .= '</tbody></table>'; 
        return $html;
    }
}
