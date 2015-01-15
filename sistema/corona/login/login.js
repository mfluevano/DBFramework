$(document).ready(function(){
   
   $(document).on('click','#btnLogin',function(){
      $.ajax({
          dataType: "json",
          type: 'post',
          url: '?seccion=login&operacion=login&standalone=true',
          data: {usuario:$('#usuario').val(), password: $('#password').val()},
          success: function(result){
                mostrarMesnsaje(result.mensaje,result.tipo);
                if(result.tipo == 1)
                {
                    window.location.href = "index.php";
                }
          },
          error: function(){
             alert('error');
          }
      }); 
   });
   
});