
function verificar_aportes(id,ruta_consulta)
{
    var array = [];
   $.ajax({
                    url: ruta_consulta,
                    type: 'GET',
                    async: false,
                    data: {id:id},
                    success: function(data){
			var valor = jQuery.parseJSON(data);
			 
			array[0] = valor.estado;
			array[1] = valor.mensaje;
			
			;
                    }
                });
   
   return array
   
}