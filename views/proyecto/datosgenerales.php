<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\web\JsExpression;
use yii\widgets\Pjax;
use app\models\Maestros;

//use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $nuevo app\models\TblPersonaSearch */
/* @var $form yii\widgets\ActiveForm */
?>





<!--<form class="contact_form" action="#" id="contact_form" runat="server">-->
<div >
    <?php $form = ActiveForm::begin(['options' => ['class' => '', ]]); ?>
    <div ><a name="general" ></a>
            <div class="clearfix"></div>
            <div class="clearfix"><h4>Datos Generales</h4></div>
            
            <div class="col-xs-12 col-sm-7 col-md-12" >
                <div class="form-group field-proyecto-titulo required">
                <input type="hidden" value="<?= $proyecto->id?>" id="proyecto-id" name="Proyecto[id]" /> 
                <label for="proyecto-titulo">Nombre del Proyecto:</label>
                <input class="form-control" type="text" value="<?= $proyecto->titulo?>" placeholder="Nombre del Proyecto" id="proyecto-titulo" name="Proyecto[titulo]"  required/> <!-- required-->
                </div>
             
                
            </div>
            <div class="col-xs-12 col-sm-7 col-md-3" >
                <div class="form-group field-proyecto-vigencia required">
                <label for="proyecto-vigencia">Vigencia (En Meses):</label>
                <input class="form-control" type="text" id="proyecto-vigencia" value="<?= $proyecto->vigencia?>" placeholder="Vigencia del Proyecto en Meses" name="Proyecto[vigencia]"  required/> <!-- required-->
            </div>    
            </div>
            <div class="col-xs-12 col-sm-7 col-md-3" >
                <div class="form-group field-proyecto-departamento required">
                <label for="proyecto-departamento">Departamento:</label>
                <select class="form-control" onchange="provincia(1)" id="proyecto-departamento" name="Proyecto[departamento][]" style="width:200px;" >
                                                <option value="0">--Departamento--</option>
                                                <?php
                                                       foreach($departamentos as $departamentos2)
                                                        {
                                                ?>
                                                           <option value="<?= $departamentos2->department_id; ?>" <?=($departamentos2->department_id == substr($proyecto->ubigeo,0,2))?'selected':'' ?> > <?= $departamentos2->department ?></option>
                                                <?php   } ?>
                            
                                             
                            
                                            </select>
            </div>    
            </div>
            <div class="col-xs-12 col-sm-7 col-md-3" >
                <div class="form-group field-proyecto-provincia required">
                    <label for="proyecto-provincia">Provincia:</label>
                    <select class="form-control" onchange="distrito(1)" id="proyecto-provincia" name="Proyecto[provincia]" style="width:200px;">
                                                <option value="0">--Provincia--</option>
                    <?php
                    if ($proyecto->ubigeo) {
                        
                        foreach($provincias as $provincias2)
                        {
                            echo '<option value="'.$provincias2->province_id.'" '.($provincias2->province_id == substr($proyecto->ubigeo,0,4) ? 'selected="selected"' : '' ).'> '.$provincias2->province .'</option>';
                        }
                        
                    }
                    ?>
                    
                    </select>
            </div>    
            </div>
            <div class="col-xs-12 col-sm-7 col-md-3" >
                <div class="form-group field-proyecto-distrito required">
                    <label for="proyecto-distrito">Distrito:</label>
                    <select class="form-control" id="proyecto-distrito" name="Proyecto[distrito]" style="width:200px;">
                                                <option value="0">--Provincia--</option>
                    <?php
                    if ($proyecto->ubigeo) {
                        
                        foreach($distritos as $distritos2)
                        {
                            echo '<option value="'.$distritos2->district_id.'" '.($distritos2->district_id == $proyecto->ubigeo ? 'selected="selected"' : '' ).'> '.$distritos2->district .'</option>';
                        }
                        
                    }
                    ?>
                    
                    </select>
            </div>    
            </div>
            <div class="clearfix"></div>
            <div class="clearfix"><h4>Dependencia del INIA que Ejecutara el Proyecto</h4></div>
            
            <div class="col-xs-12 col-sm-7 col-md-4" >
                <div class="form-group field-proyecto-id_direccion_linea required">
                <label for="proyecto-id_direccion_linea">Dirección en Linea:</label>
                <select  class="form-control" id="proyecto-id_direccion_linea" name="Proyecto[id_direccion_linea]" style="width:200px;">
                    <option value="0">--Seleccione--</option>
                    <?php
                 
                    $tipoDireccion = Maestros::find()
                                ->where('id_padre = 21 and estado = 1')
                                ->orderBy('orden')
                                ->all();

                    
                           foreach($tipoDireccion as $tipoDireccion2)
                            {
                    ?>
                               <option value="<?= $tipoDireccion2->id; ?>" <?=($tipoDireccion2->id == $proyecto->id_direccion_linea)?'selected':'' ?> required> <?= $tipoDireccion2->descripcion ?></option>;
                    <?php   } ?>

                 

                </select>
             </div>    
            </div>
            <div class="col-xs-12 col-sm-7 col-md-4" >
                <div class="form-group field-proyecto-id_unidad_ejecutora required">
                <label for="proyecto-id_unidad_ejecutora">Unidad Ejecutora:</label>
                <select class="form-control" id="proyecto-id_unidad_ejecutora" name="Proyecto[id_unidad_ejecutora]" style="width:200px;">
                    <option value="0">--Seleccione--</option>
                    <?php
                 
                    $tipoUnidadEj = Maestros::find()
                                ->where('id_padre = 25 and estado = 1')
                                ->orderBy('orden')
                                ->all();

                    
                           foreach($tipoUnidadEj as $tipoUnidadEj2)
                            {
                    ?>
                               <option value="<?= $tipoUnidadEj2->id; ?>" <?=($tipoUnidadEj2->id == $proyecto->id_unidad_ejecutora)?'selected':'' ?> required> <?= $tipoUnidadEj2->descripcion ?></option>;
                    <?php   } ?>

                 

                </select>
                
            </div>    
            </div>
            <div class="col-xs-12 col-sm-7 col-md-4" >
                <div class="form-group field-proyecto-id_dependencia_inia required">
                <label for="proyecto-id_dependencia_inia">Dependencia del INIA :</label>
                <select class="form-control" name="Proyecto[id_dependencia_inia]" id="proyecto-id_dependencia_inia" style="width:200px;">
                    <option value="0">--Seleccione--</option>

                </select>
                
            </div>    
            </div>
            <div class="clearfix"></div>
            <div class="clearfix"><h4>Nombres y Apellidos del Responsable Técnico del Proyecto</h4></div>
            <div class="col-xs-12 col-sm-7 col-md-12" >
                <div class="form-group field-proyecto-nombres required">
                <label for="proyecto-nombres">Nombres:</label>
                <input class="form-control" type="text" value="<?= $responsable->nombres?>" placeholder="Nombres" id="proyecto-nombres" name="Proyecto[nombres]"  required/> <!-- required-->
                
            </div>    
            </div>
            <div class="col-xs-12 col-sm-7 col-md-12" >
                <div class="form-group field-proyecto-apellidos required">
                <label for="proyecto-apellidos">Apellidos:</label>
                <input class="form-control" type="text" value="<?= $responsable->apellidos?>" placeholder="Apellidos" id="proyecto-apellidos" name="Proyecto[apellidos]"  required/> <!-- required-->
                
            </div>    
            </div>
            <div class="col-xs-12 col-sm-7 col-md-6" >
                <div class="form-group field-proyecto-telefono required">
                <label for="proyecto-telefono">Teléfono Fijo:</label>
                <input class="form-control" type="text" value="<?= $responsable->telefono?>" placeholder="Teléfono Fijo" id="proyecto-telefono" name="Proyecto[telefono]"  required/> <!-- required-->
                
            </div>    
            </div>
            <div class="col-xs-12 col-sm-7 col-md-6" >
                <div class="form-group field-proyecto-celular required">
                <label for="proyecto-celular">Celular:</label>
                <input class="form-control" type="text" value="<?= $responsable->celular?>" placeholder="Celular" id="proyecto-celular" name="Proyecto[celular]"  required/> <!-- required-->
                
            </div>    
            </div>
            <div class="col-xs-12 col-sm-7 col-md-12" >
                <div class="form-group field-proyecto-correo required">
                <label for="proyecto-correo">Correo Electrónico:</label>
                <input class="form-control" type="text" value="<?= $responsable->correo?>" placeholder="Correo Electrónico" id="proyecto-correo" name="Proyecto[correo]"  required/> <!-- required-->
                <span class="form_hint">Formato correcto: "nombre@dominio.com"</span>
                
            </div>    
            </div>
            
            <div class="clearfix"></div>
            <div class="clearfix"><h4>Lista de Nombres y Colaboradores Técnicos del Proyecto y Función Técnica</h4></div>
            <div class="col-xs-12 col-sm-7 col-md-12" >
                <?= \app\widgets\colaboradores\ColaboradoresWidget::widget(['id'=>$proyecto->id]); ?>   
            </div>
            <div class="clearfix"></div>
            <div class="clearfix"><h4>Alianza Estratégica establecidas para el Proyecto</h4></div>
            <div class="col-xs-12 col-sm-7 col-md-12" >
                <?= \app\widgets\instituciones\InstitucionesWidget::widget(['proyecto_id'=>$proyecto->id]); ?> 
                
                
            </div>
            <div class="clearfix"></div>
            <div class="clearfix"><h4>Resumen Ejecutivo del Proyecto</h4></div>
            <div class="col-xs-12 col-sm-7 col-md-12" >
                <div class="form-group field-proyecto-resumen_ejecutivo required">
                <label for="proyecto-resumen_ejecutivo">Descripción:</label>
                <textarea class="form-control" type="text"  placeholder="..."  rows="10"  id="proyecto-resumen_ejecutivo" name="Proyecto[resumen_ejecutivo]"  required><?= $proyecto->resumen_ejecutivo?></textarea>

            </div>    
            </div>
            <div class="clearfix"></div>
            <div class="clearfix"><h4>Relevancia del Proyecto y Referencias a Resultados Obtenidos en INIA u otras Instituciones</h4></div>
            <div class="col-xs-12 col-sm-7 col-md-12" >
                <div class="form-group field-proyecto-relevancia required">
                <label for="proyecto-relevancia">Descripción:</label>
                <textarea class="form-control" type="text" placeholder="..."  rows="10" id="proyecto-relevancia" name="Proyecto[relevancia]"  required><?= $proyecto->relevancia?></textarea>

            </div>    
            </div>
            <div class="col-xs-12 col-sm-7 col-md-12" >
            <button type="submit" id="btnproyecto" class="btn btn-primary">Guardar</button>   
            </div>
        
    </div>
    
    
    
    
 <?php ActiveForm::end(); ?>
</div>

<?php

    $urlproyectoExiste= Yii::$app->getUrlManager()->createUrl('proyecto/existeproyecto');
    $urlresponsable= Yii::$app->getUrlManager()->createUrl('responsable/guardar');
    $urlDependencia= Yii::$app->getUrlManager()->createUrl('maestros/dependencia');
    $obtenerprovincia = Yii::$app->getUrlManager()->createUrl('proyecto/obtenerprovincia');
    $obtenerdistrito = Yii::$app->getUrlManager()->createUrl('proyecto/obtenerdistrito');
?>


<script type="text/javascript">
    
$(document).ready(function(){

var inicialdependencia = <?= $proyecto-> id_dependencia_inia;?>;
if (inicialdependencia != '')
{
    var dependencia = $("#proyecto-id_dependencia_inia");
     var unidad = $("#proyecto-id_unidad_ejecutora");
     
     if(unidad.val() != '0')
        {
        $.ajax({
                    url: '<?= $urlDependencia ?>',
                    type: 'GET',
                    async: true,
                    data: {unidadejecutora:unidad.val()},
                    success: function(data){
                        dependencia.find('option').remove();
                        dependencia.append(data);
                        $("#proyecto-id_dependencia_inia option[value="+inicialdependencia+"]").attr('selected','selected');
                        dependencia.prop('disabled', false);
                    }
                });
        }
}
else
{
$("#proyecto-id_dependencia_inia").prop('disabled', true);
}
    
$("#proyecto-id_unidad_ejecutora").change(function(){
    
     var dependencia = $("#proyecto-id_dependencia_inia");
     var unidad = $(this);
     
     if($(this).val() != '0')
        {
        $.ajax({
                    url: '<?= $urlDependencia ?>',
                    type: 'GET',
                    async: true,
                    data: {unidadejecutora:unidad.val()},
                    success: function(data){
                        dependencia.find('option').remove();
                        dependencia.append(data);
                        dependencia.prop('disabled', false);
                    }
                });
        }
        else
        {
            dependencia.find('option').remove();
            dependencia.append('<option value="0">--Seleccione--</option>');
            dependencia.prop('disabled', true);
        }
 });

});



function provincia(valor) {
	
	var departamento = $('#proyecto-departamento');
	var provincia = $('#proyecto-provincia');
	var distrito = $('#proyecto-distrito');
	
     if(departamento.val() != '0')
        {
        $.ajax({
                    url: '<?= $obtenerprovincia ?>',
                    type: 'GET',
                    async: true,
                    data: {id:departamento.val()},
                    success: function(data){
                        provincia.find('option').remove();
                        provincia.append(data);
                        provincia.prop('disabled', false);
                    }
                });
        }
        else
        {
            provincia.find('option').remove();
            provincia.append('<option value="0">--Seleccione--</option>');
	    provincia.prop('disabled', true);
	    distrito.find('option').remove();
            distrito.append('<option value="0">--Seleccione--</option>');
            distrito.prop('disabled', true);
        }

    }


function distrito(identificador) {
	var provincia = $('#proyecto-provincia');
	var distrito = $('#proyecto-distrito');
	
     if(provincia.val() != '0')
        {
        $.ajax({
                    url: '<?= $obtenerdistrito ?>',
                    type: 'GET',
                    async: true,
                    data: {id:provincia.val()},
                    success: function(data){
                        distrito.find('option').remove();
                        distrito.append(data);
                        distrito.prop('disabled', false);
                    }
                });
        }
        else
        {
	    distrito.find('option').remove();
            distrito.append('<option value="0">--Seleccione--</option>');
            distrito.prop('disabled', true);
        }
    }


$("#btnproyecto").click(function( ) {
    
    var error='';
    if($.trim($('#proyecto-titulo').val())=='')
        {
            error=error+'Ingrese Nombre del Proyecto<br>';
            $('#proyecto-titulo').addClass('has-error');
            //alert('hola');
        }
        
    if($.trim($('#proyecto-id_direccion_linea').val())=='0')
        {
            error=error+'Seleccione la Dirección en Linea<br>';
            $('#proyecto-id_direccion_linea').addClass('has-error');
            //alert('hola');
        }
    
    if($.trim($('#proyecto-id_unidad_ejecutora').val())=='0')
        {
            error=error+'Seleccione La Unidad Ejecutora<br>';
            $('#proyecto-id_unidad_ejecutora').addClass('has-error');
            //alert('hola');
        }
    
    if($.trim($('#proyecto-id_dependencia_inia').val())=='0')
        {
            error=error+'Seleccione la Dependencia INIA<br>';
            $('#proyecto-id_dependencia_inia').addClass('has-error');
            //alert('hola');
        }
    
    if($.trim($('#proyecto-nombres').val())=='')
        {
            error=error+'Ingrese Nombres del Responsable<br>';
            $('#proyecto-titulo').addClass('has-error');
            //alert('hola');
        }
    
     if($.trim($('#proyecto-apellidos').val())=='')
        {
            error=error+'Ingrese Apellidos del Responsable<br>';
            $('#proyecto-titulo').addClass('has-error');
            //alert('hola');
        }
    
    if($.trim($('#proyecto-telefono').val())=='')
        {
            error=error+'Ingrese Nro Teléfonico del Responsable<br>';
            $('#proyecto-titulo').addClass('has-error');
            //alert('hola');
        }
    
     if($.trim($('#proyecto-celular').val())=='')
        {
            error=error+'Ingrese Nombre Nro Celular del Responsable<br>';
            $('#proyecto-titulo').addClass('has-error');
            //alert('hola');
        }
    
     if($.trim($('#proyecto-correo').val())=='')
        {
            error=error+'Ingrese Correo Electrónico del Responsable<br>';
            $('#proyecto-titulo').addClass('has-error');
            //alert('hola');
        }
    
    if($.trim($('#proyecto-resumen_ejecutivo').val())=='')
        {
            error=error+'Ingrese el Resumen Ejecutivo<br>';
            $('#proyecto-resumen_ejecutivo').addClass('has-error');
            //alert('hola');
        }
        
    if($.trim($('#proyecto-relevancia').val())=='')
        {
            error=error+'Ingrese La Relevancia del Proyecto<br>';
            $('#proyecto-relevancia').addClass('has-error');
            //alert('hola');
        }
   
     if($.trim($('#proyecto-vigencia').val())=='')
        {
            error=error+'Ingrese la Vigencia del Proyecto<br>';
            $('#proyecto-vigencia').addClass('has-error');
            //alert('hola');
        }
    
    if($.trim($('#proyecto-departamento').val())=='0' || $.trim($('#proyecto-provincia').val())=='0' || $.trim($('#proyecto-distrito').val())=='0')
        {
            error=error+'Seleccione Ubigeo<br>';
            $('#proyecto-departamento').addClass('has-error');
            $('#proyecto-provincia').addClass('has-error');
            $('#proyecto-distrito').addClass('has-error');
            //alert('hola');
        }
                 
        
    if(error!='')
        {
            $.notify({
                message: error 
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
        
       /* var id = $('#proyecto-id').val();
        var titulo = $('#proyecto-id').val();
        var direccion_linea = $('#proyecto-direccion_linea').val();
        var estacion_exp = $('#proyecto-estacion_exp').val();
        var sub_estacion_exp = $('#proyecto-sub_estacion_exp').val();
        var nombres = $('#responsable-nombres').val();
        var apellidos = $('#responsable-apellidos').val();
        var telefono = $('#responsable-telefono').val();
        var celular = $('#responsable-celular').val();
        var correo = $('#responsable-correo').val();*/
        
  /*  var validarproyecto=$.ajax({
                url: '<? $urlproyecto ?>',
                type: 'POST',
                async: false,
                data: {'Proyecto[id]':id,'Proyecto[titulo]':titulo,'Proyecto[direccion_linea]':direccion_linea,'Proyecto[estacion_exp]':estacion_exp,'Proyecto[sub_estacion_exp]':sub_estacion_exp},
                success: function(data){
                    
                }
            });    */
        
        
        
    
    return true;
});

/*
$("#proyecto-colaboradores").click(function( ) {
    var existe=$.ajax({
                url: '<?= $urlproyectoExiste ?>',
                type: 'POST',
                async: false,
                //data: {},
                success: function(data){
                    
                }
            });
    if(existe.responseText!=1)
        {
            $.notify({
                message: existe.responseText
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
});*/

</script>

