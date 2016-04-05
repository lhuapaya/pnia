<a href="#" data-toggle="modal" data-target="#institucion_" id="instituciones">
    Lista de Instituciones Asociadas
</a>
<!--Lista de Objetivos Especificos -->
<div class="modal fade" id="institucion_" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Lista de Instituciones asociadas</h4>
            </div>
            <div class="modal-body">
                <div id="agrupador"  class="panel-group" id="accordion">
		    <div id="alianza_addr_0" class="panel panel-default">
			<div class="panel-heading">
			    <h4 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion" href="#collapse0">
				Collapsible Group 0</a>
			    </h4>
			</div>
			<div id="collapse0" class="panel-collapse collapse in">
			    <input type="text" id="proyecto-alianza_institucion_0" name="Proyecto[alianzas_instituciones]" class="form-group" placeholder="Institución">
			    <br><textarea id="proyecto-alianza_descripcion_0" name="Proyecto[alianzas_descripciones]" class="form-group" placeholder="Resumen"></textarea>
			    <br><input type="text" id="proyecto-alianza_nombres_0" name="Proyecto[alianzas_nombres]" class="form-group" placeholder="Nombres">
			    <br><input type="text" id="proyecto-alianza_apellidos_0" name="Proyecto[alianzas_apellidos]" class="form-group" placeholder="Apellidos">
			    <br><input type="email" id="proyecto-alianza_correo_0" name="Proyecto[alianzas_correos]" class="form-group" placeholder="Email">
			    <br><input type="text" id="proyecto-alianza_telefono_0" name="Proyecto[alianzas_telefonos]" class="form-group" placeholder="Telefono">
				
			</div>
		    </div>
		    
		    <div id="alianza_addr_1" class="panel panel-default"></div>
		</div>
		
		
		<div class="clearfix"></div>
		<div id="alianza_row_1" class="btn btn-default pull-left" value="1">Agregar</div>
		<div class="clearfix"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="submit" id="btn_objetivos_especificos" class="btn btn-primary" data-dismiss="modal">Guardar</button>
            </div>
        </div>
    </div>
</div>

<?php
    $eliminaractividad= Yii::$app->getUrlManager()->createUrl('proyecto/eliminarobjetivoespecifico');
?>
<script>
    var inst=1;
    
    $("#objetivos_especificos_tabla").on('click','.eliminar',function(){
        var r = confirm("Estas seguro?");
        if (r == true) {
            id=$(this).children().val();
            if (id) {
		$.ajax({
                    url: '<?= $eliminaractividad ?>',
                    type: 'GET',
                    async: true,
                    data: {id:id},
                    success: function(data){
                        
                    }
                });
		$(this).parent().parent().remove();	
	    }
	    else
	    {
		$(this).parent().parent().remove();
	    }
        } 
    });
    
    
    $("#alianza_row_1").click(function(){
       var alianzas_instituciones=$('input[name=\'Proyecto[alianzas_instituciones][]\']').length;
       var error='';
       for (var i=0; i<alianzas_instituciones; i++) {
            if($('#proyecto-alianza_institucion_'+i).val()=='')
            {
                error=error+'ingrese la institución #'+i+'  <br>';
                $('.field-proyecto-alianza_institucion_'+i).addClass('has-error');
            }
            else
            {
                $('.field-proyecto-alianza_institucion_'+i).addClass('has-success');
                $('.field-proyecto-alianza_institucion_'+i).removeClass('has-error');
            }
	    
	    if($('#proyecto-alianza_descripcion_'+i).val()=='')
            {
                error=error+'ingrese la descripción #'+i+'  <br>';
                $('.field-proyecto-alianza_descripcion_'+i).addClass('has-error');
            }
            else
            {
                $('.field-proyecto-alianza_descripcion_'+i).addClass('has-success');
                $('.field-proyecto-alianza_descripcion_'+i).removeClass('has-error');
            }
	    
	    if($('#proyecto-alianza_nombres_'+i).val()=='')
            {
                error=error+'ingrese los nombres #'+i+'  <br>';
                $('.field-proyecto-alianza_nombres_'+i).addClass('has-error');
            }
            else
            {
                $('.field-proyecto-alianza_nombres_'+i).addClass('has-success');
                $('.field-proyecto-alianza_nombres_'+i).removeClass('has-error');
            }
	    
	    if($('#proyecto-alianza_apellidos_'+i).val()=='')
            {
                error=error+'ingrese el apellido #'+i+'  <br>';
                $('.field-proyecto-alianza_apellidos_'+i).addClass('has-error');
            }
            else
            {
                $('.field-proyecto-alianza_apellidos_'+i).addClass('has-success');
                $('.field-proyecto-alianza_apellidos_'+i).removeClass('has-error');
            }
	    
	    
        }
	if (error!='') {
            $.notify({
                message: error 
            },{
                type: 'danger',
                z_index: 1000000,
                placement: {
                    from: 'bottom',
                    align: 'right'
                },
            });
            return false;
        }
        else
        {
	   $('#alianza_addr_'+inst).html('<div class="panel panel-default">'+
				       '<div class="panel-heading">'+
				       '<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse'+inst+'">Collapsible Group '+inst+'</a></h4>'+
				       '</div>'+
				       '<div id="collapse'+inst+'" class="panel-collapse collapse in">'+
				       '<input type="text" id="proyecto-alianza_institucion" name="Proyecto[alianzas_instituciones][]" class="form-group" placeholder="Institución">'+
				       '<br><textarea id="proyecto-alianza_descripcion_'+inst+'" name="Proyecto[alianzas_descripciones][]" class="form-group" placeholder="Resumen"></textarea>'+
				       '<br><input type="text" id="proyecto-alianza_nombres_'+inst+'" name="Proyecto[alianzas_nombres][]" class="form-group" placeholder="Nombres">'+
				       '<br><input type="text" id="proyecto-alianza_apellidos_'+inst+'" name="Proyecto[alianzas_apellidos][]" class="form-group" placeholder="Apellidos">'+
				       '<br><input type="email" id="proyecto-alianza_correo_'+inst+'" name="Proyecto[alianzas_correos][]" class="form-group" placeholder="Email">'+
				       '<br><input type="text" id="proyecto-alianza_telefono_'+inst+'" name="Proyecto[alianzas_telefonos][]" class="form-group" placeholder="Telefono">'+
				       '</div>'+
				       '</div>');
	    if ((inst+1)<3) {
		$('#agrupador').append('<div id="alianza_addr_'+(inst+1)+'" class="panel panel-default"></div>');
		inst++;
	    }
            
        }
	
            
        
        
        
        return true;
    });
    
    $("#btn_objetivos_especificos").click(function(event){
	var error='';
        var objetivo1=$('input[name=\'Proyecto[objetivos_descripciones][]\']').length;
        for (var i=0; i<objetivo1; i++) {
            if($('#proyecto-objetivos_descripciones_'+i).val()=='')
            {
                error=error+'ingrese el objetivo especifico #'+i+'  <br>';
                $('.field-proyecto-objetivos_descripciones_'+i).addClass('has-error');
            }
            else
            {
                $('.field-proyecto-objetivos_descripciones_'+i).addClass('has-success');
                $('.field-proyecto-objetivos_descripciones_'+i).removeClass('has-error');
            }
        }
	
	if (error!='') {
            $.notify({
                message: error 
            },{
                type: 'danger',
                z_index: 1000000,
                placement: {
                    from: 'bottom',
                    align: 'right'
                },
            });
            return false;
        }
        else
        {
	    $( "#w0" ).submit();
            return true;
        }
    });
    
    $("#instituciones").click(function( ) {
	var id='<?= $proyecto_id ?>';
	console.log(id);
	if (id=='') {
	    $.notify({
                message: 'No existe proyecto registrado'
            },{
                type: 'danger',
                offset: 20,
                spacing: 10,
                z_index: 1031,
                placement: {
                    from: 'top',
                    align: 'right'
                },
            });
            return false;
	}
	return true;
    });
    
</script>