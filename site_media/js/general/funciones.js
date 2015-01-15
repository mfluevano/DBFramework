function mostrarMesnsaje(msg,tipo)
{
    var mensaje = '';
    
    switch (tipo)
    {
        case 1:
            
            mensaje += '<div class="alert alert-success"><span class="glyphicon glyphicon glyphicon-ok-sign" aria-hidden="true"></span> ';
            
            break;
        case 2:
            
            mensaje += '<div class="alert alert-warning"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> ';
            
            break;
        case 3:
            
            mensaje += '<div class="alert alert-danger"> <span class="glyphicon glyphicon glyphicon glyphicon-remove-sign" aria-hidden="true"></span> ';
            
            break;
    }
    
    mensaje += ' ' + msg + '</div>';
    $('.mensaje').html(mensaje);
}
 
 
// esta accion se ejecutara para  todo boton de desactivar 
$('.desactivar').on('click', function(e) 
{
    elem = $(this);
    e.preventDefault();
    swal({
            title: "¿Esta seguro?",   
            text: "Una vez desactivado no podrá ser usado hasta reactivarlo.",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Si, Desactivar!",   
            cancelButtonText: "No, Cancelar",   
            closeOnConfirm: false,   
            closeOnCancel: false 
        }, function(isConfirm)
        {   
            if (isConfirm) 
            {     
                swal("Desactivado!", "El elemento ha sido desactivado.", "success");  
                
                window.location = elem.attr('href');
            } 
            else 
            {     
                 
                swal("Cancelado", "Puede continuar de forma segura", "error");   
                
            } 
        });
   
    
});

// esta accion se ejecutara para  todo boton de activar 
$('.activar').on('click', function(e) 
{
    elem = $(this);
    e.preventDefault();
    swal({
            title: "¿Esta seguro?",   
            text: "Una vez activado el elemento podra ser utilizado.",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Si, Activar!",   
            cancelButtonText: "No, Cancelar",   
            closeOnConfirm: false,   
            closeOnCancel: false 
        }, function(isConfirm)
        {   
            if (isConfirm) 
            {     
                swal("Activado!", "El elemento ha sido activado.", "success");  
                
                window.location = elem.attr('href');
            } 
            else 
            {     
                 
                swal("Cancelado", "Puede continuar de forma segura", "error");   
                
            } 
        });
   
    
});