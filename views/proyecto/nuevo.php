<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\web\JsExpression;
use yii\widgets\Pjax;
//use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $nuevo app\models\TblPersonaSearch */
/* @var $form yii\widgets\ActiveForm */
?>





<!--<form class="contact_form" action="#" id="contact_form" runat="server">-->
<?php Pjax::begin(); ?>
    <?php $form = ActiveForm::begin(['action'=>'nuevo', 'method'=>'post', 'options' => ['class' => 'contact_form', 'data-pjax' => true ]]); ?>
    <div>
        <ul>
            <li>
                <h2>1. Formulario del Proyecto de Investigacion</h2>
                <span class="required_notification">* Datos requeridos</span>
            </li>
            
            <li>
                <h4>1.1 Titulo del Proyecto</h4>
                <?= $form->field($nuevo, 'id')->hiddenInput(['class'=>''])->label(false) ?>

                <?= $form->field($nuevo, 'titulo')->textInput(['class'=>'form-control texto','disabled'=>false])->label('Nombre del Proyecto')->error(false) ?>
                
            </li>
            <li>
                <h4>1.2 Dependencia del INIA que Ejecutara el Proyecto</h4>
                <?= $form->field($nuevo, 'direccion_linea')->textInput(['class'=>'form-control texto','disabled'=>false])->label('Señale Dirección en Linea:')->error(false) ?>
                <label for="direccionL">Señale Dirección en Linea:</label>
                <input type="text" placeholder="..." required /> 
                
            </li>
            <li>
                <label for="estacionExp">Señale Estación Experimental Agraria:</label>
                <input type="text" placeholder="..." required /> 
                
            </li>
            <li>
                <label for="subExtacionExp">Señale Sub Estación Experimental Agraria:</label>
                <input type="text" placeholder="..." required /> 
                
            </li>
            <li>
                <h4>1.3 Nombres y Apellidos del Responsable Técnico del Proyecto</h4>
                <label for="nombreRT">Nombres:</label>
                <input type="text" placeholder="..." required /> 
                
            </li>
            <li>
                <label for="apellidosRT">Apellidos:</label>
                <input type="text" placeholder="..." required /> 
                
            </li>
            <li>
                <label for="telefonoRT">Teléfono Fijo:</label>
                <input type="text" placeholder="..." required /> 
                
            </li>
            <li>
                <label for="celularRT">Celular:</label>
                <input type="text" placeholder="..." required /> 
                
            </li>
            <li>
                <label for="correoRT">Correo Electrónico:</label>
                <input type="text" placeholder="..." required />
                <span class="form_hint">Formato correcto: "name@something.com"</span>
                
            </li>
            
            <li>
                <h4>1.4 Lista de Nombres y Colaboradores Técnicos del Proyecto y Función Técnica</h4>
                <a href="#">
                 Lista de Colaboradores   
                </a>
                
            </li>
            <li>
                <h4>1.5 Alianza Estratégica establecidas para el Proyecto</h4>
                <a href="#">
                 Lista de Instituciones Asociadas.
                </a>
                
            </li>
            <li>
                <h4>1.6 Áreas Claves del Proyecto</h4>
                <h4>   1.6.1 Cultivo o Crianza priorizado en su Proyecto</h4>
                
                <label for="culcri">Cultivo o Crianza:</label>
                <select id="selecCC" name="culcri" style="width:200px;">
                    <option value="0">--Seleccione--</option>
                    <option value="1">Ganaderia, Vacunos, Camélidos o Cuyes</option>
                    <option value="2">Forestales</option>
                    <option value="3">Quinua - Otros Cultivos Andinos</option>
                    <option value="4">Café o Cacao</option>
                    <option value="5">Arroz</option>
                    <option value="6">Papa</option>
                    <option value="7">Maíz amarillo o blanco amiláceo</option>
                    <option value="8">Otros</option>
                </select>
                
                
            </li>
            <li id="especifiqueCC">
                <label for="especifiqueCC">Especifique:</label>
                <input type="text" placeholder="..." required />
                
            </li>
            <li>
                <h4>1.6.2 Señale una Acción Transversal de Áreas Temáticas Específicas</h4>
                
                <label for="culcri">Acción Transversal:</label>
                <select id="selecAT" name="acttrans" style="width:200px;">
                    <option value="0">--Seleccione--</option>
                    <option value="1">Biotecnología y Recursos Genéticos</option>
                    <option value="2">Cambio Climático y Sostenibilidad</option>
                    <option value="3">Socio ‐ Economía, Mercados y Sistemas de Apoyo a la Transferencia Tecnológica y Extensión en las Regiones</option>
                    <option value="4">Manejo Post Cosecha</option>
                    <option value="5">Otros</option>
                </select>
                
                
            </li>
            <li id="especifiqueAT">
                <label for="especifiqueAT">Especifique:</label>
                <input type="text" placeholder="..." required />
                
            </li>
            <li>
                <h4>1.6.3 Señale el Tipo de Proyecto</h4>
                
                <label for="culcri">Invetigación:</label>
                <select id="selecInv" name="acttrans" style="width:200px;">
                    <option value="0">--Seleccione--</option>
                    <option value="1">Invetigación Basica</option>
                    <option value="2">Invetigación Aplicada</option>
                    <option value="3">Invetigación Adaptativa</option>
                    <option value="4">Invetigación Estratégica</option>
                </select>
                
                
            </li>
            <li id="especifiqueAT">
                <label for="especifiqueAT">Descripción:</label>
                <textarea type="text" placeholder="..." required rows="10" cols="80" style="margin: 0px; width: 600px; height: 100px;"></textarea>
                
                
            </li>
            <li>
                <h4>1.7 Lugar de acción donde se ejecutará el trabajo de Investigación</h4>
                <a href="#">
                 Locación Geográfica(UBIGEO) 
                </a>
                
            </li>
            <li>
                <h4>1.8 Resumen Ejcutivo del Proyecto</h4>
                <label for="especifiqueAT">Descripción:</label>
                <textarea type="text" placeholder="..." required rows="10" cols="80" style="margin: 0px; width: 600px; height: 150px;"></textarea>

            </li>
            <li>
                <h4>1.9 Relevancia del Proyecto y Referencias a Resultados Obtenidos en INIA u otras Instituciones</h4>
                <label for="especifiqueAT">Descripción:</label>
                <textarea type="text" placeholder="..." required rows="10" cols="80" style="margin: 0px; width: 600px; height: 150px;"></textarea>

            </li>
            <li>
                <h4>1.10 Objeto General</h4>
                <label for="especifiqueAT">Señale Objeto General:</label>
                <textarea type="text" placeholder="..." required rows="10" cols="80" style="margin: 0px; width: 600px; height: 80px;"></textarea>
                <h5>Señale los Objetos Especificos:<h5>
                <a href="#" >
                 Lista Objetos Especificos
                </a> 
            </li>
            <li>
                <h4>1.11 Plan de Trabajo</h4>
                <label for="especifiqueAT">Descripción:</label>
                <textarea type="text" placeholder="..." required rows="10" cols="80" style="margin: 0px; width: 600px; height: 300px;"></textarea>
                <h5>Señale las Actividades para cada Objetivo Específico referidos en el punto 1.10.:<h5>
                <a href="#" >
                 Lista de Actividades
                </a> 
            </li>
            <li>
                <h4>1.12 Resultados Esperados en Innovación Agraria o Transferencia de Tecnología</h4>
                <label for="especifiqueAT">Descripción:</label>
                <textarea type="text" placeholder="..." required rows="10" cols="80" style="margin: 0px; width: 600px; height: 200px;"></textarea>

            </li>
            <li>
                <h4>1.13 Detallar la Infraestructura, Equipos, y Apoyo Logístico disponibles y solicitados para el desarrollo del proyecto</h4>
                <a href="#">
                 Lista de Recursos del Proyecto 
                </a>
                
            </li>
            <li>
                <h4>1.14 Cronograma del Proyecto</h4>
                <a href="#">
                 Listar Actividades para Cronograma 
                </a>
                
            </li>
            <li>
                <h4>1.15 Presupuesto del Proyecto</h4>
                <label for="name">Monto Total:</label>
                <input type="text" placeholder="..." required />
                
            </li>
            <li>
                <h4>1.16 Lista de Referencias Bibliográficas</h4>
                <label for="especifiqueAT">Señale las Referencias:</label>
                <textarea type="text" placeholder="..." required rows="10" cols="80" style="margin: 0px; width: 600px; height: 200px;"></textarea>

            </li>
            <li>
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Guardar
              </button>  
            </li>
            <li>
                
                
            </li>
        
        </ul>
    </div>

 <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>    
<!--</form>-->


<script type="text/javascript">
$(document).ready(function(){
$("#especifiqueCC").hide();
$("#especifiqueAT").hide();
});

$('#selecCC').change(function(){ 
     var valor = $('#selecCC').val(); 
     
     if (valor != 0) {
       $("#especifiqueCC").show();;
     }
     else
     {
      $("#especifiqueCC").hide();  
     }
     //saludo(nombre); 
});

$('#selecAT').change(function(){ 
     var valor2 = $('#selecAT').val(); 
     
     if (valor2 == 5) {
       $("#especifiqueAT").show();
     }
     else
     {
      $("#especifiqueAT").hide();  
     }
     saludo(valor2); 
});


</script>