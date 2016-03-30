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

    <?php $form = ActiveForm::begin(['options' => ['class' => 'contact_form', ]]); ?>
    <div>
        <ul>
            <li>
                <h2>1. Formulario del Proyecto de Investigacion</h2>
                <span class="required_notification">* Datos requeridos</span>
            </li>
            
            <li>
                <h4>1.1 Titulo del Proyecto</h4>
                <input type="hidden" value="<?= $proyecto->id?>" id="proyecto-id" name="Proyecto[id]" /> 
                <label for="proyecto-titulo">Nombre del Proyecto:</label>
                <input type="text" value="<?= $proyecto->titulo?>" placeholder="Nombre del Proyecto" id="proyecto-titulo" name="Proyecto[titulo]"  required/> <!-- required-->
                
             
                
            </li>
            <li>
                <h4>1.2 Dependencia del INIA que Ejecutara el Proyecto</h4>
                <label for="proyecto-direccion_linea">Señale Dirección en Linea:</label>
                <input type="text" value="<?= $proyecto->direccion_linea?>" placeholder="Señale Dirección en Linea" id="proyecto-direccion_linea" name="Proyecto[direccion_linea]"  required/> <!-- required-->
                
             
                
            </li>
            <li>
                <label for="proyecto-estacion_exp">Señale Estación Experimental Agraria:</label>
                <input type="text" value="<?= $proyecto->estacion_exp?>" placeholder="Señale Estación Experimental Agraria" id="proyecto-estacion_exp" name="Proyecto[estacion_exp]"  required/> <!-- required-->
                
            </li>
            <li>
                <label for="proyecto-sub_estacion_exp">Señale Sub Estación Experimental Agraria:</label>
                <input type="text" value="<?= $proyecto->sub_estacion_exp?>" placeholder="Señale Sub Estación Experimental Agraria" id="proyecto-sub_estacion_exp" name="Proyecto[sub_estacion_exp]"  required/> <!-- required-->
                
            </li>
            <li>
                <h4>1.3 Nombres y Apellidos del Responsable Técnico del Proyecto</h4>
                <label for="proyecto-nombres">Nombres:</label>
                <input type="text" value="<?= $responsable->nombres?>" placeholder="Nombres" id="proyecto-nombres" name="Proyecto[nombres]"  required/> <!-- required-->
                
            </li>
            <li>
                <label for="proyecto-apellidos">Apellidos:</label>
                <input type="text" value="<?= $responsable->apellidos?>" placeholder="Apellidos" id="proyecto-apellidos" name="Proyecto[apellidos]"  required/> <!-- required-->
                
            </li>
            <li>
                <label for="proyecto-telefono">Teléfono Fijo:</label>
                <input type="text" value="<?= $responsable->telefono?>" placeholder="Teléfono Fijo" id="proyecto-telefono" name="Proyecto[telefono]"  required/> <!-- required-->
                
            </li>
            <li>
                <label for="proyecto-celular">Celular:</label>
                <input type="text" value="<?= $responsable->celular?>" placeholder="Celular" id="proyecto-celular" name="Proyecto[celular]"  required/> <!-- required-->
                
            </li>
            <li>
                <label for="proyecto-correo">Correo Electrónico:</label>
                <input type="text" value="<?= $responsable->correo?>" placeholder="Correo Electrónico" id="proyecto-correo" name="Proyecto[correo]"  required/> <!-- required-->
                <span class="form_hint">Formato correcto: "nombre@dominio.com"</span>
                
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
                <input type="text" placeholder="..."  />
                
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
                <input type="text" placeholder="..."  />
                
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
            <li>
                <label for="proyecto-desc_tipo_proy">Descripción:</label>
                <textarea type="text" placeholder="..."  rows="10" cols="80" style="margin: 0px; width: 600px; height: 100px;" id="proyecto-desc_tipo_proy" name="Proyecto[desc_tipo_proy]"  required><?= $proyecto->desc_tipo_proy?></textarea>
                
                
            </li>
            <li>
                <h4>1.7 Lugar de acción donde se ejecutará el trabajo de Investigación</h4>
                <a href="#">
                 Locación Geográfica(UBIGEO) 
                </a>
                
            </li>
            <li>
                <h4>1.8 Resumen Ejecutivo del Proyecto</h4>
                <label for="proyecto-resumen_ejecutivo">Descripción:</label>
                <textarea type="text"  placeholder="..."  rows="10" cols="80" style="margin: 0px; width: 600px; height: 150px;" id="proyecto-resumen_ejecutivo" name="Proyecto[resumen_ejecutivo]"  required><?= $proyecto->resumen_ejecutivo?></textarea>

            </li>
            <li>
                <h4>1.9 Relevancia del Proyecto y Referencias a Resultados Obtenidos en INIA u otras Instituciones</h4>
                <label for="proyecto-relevancia">Descripción:</label>
                <textarea type="text" placeholder="..."  rows="10" cols="80" style="margin: 0px; width: 600px; height: 150px;" id="proyecto-relevancia" name="Proyecto[relevancia]"  required><?= $proyecto->relevancia?></textarea>

            </li>
            <li>
                <h4>1.10 Objeto General</h4>
                <label for="proyecto-objetivo_general">Señale Objeto General:</label>
                <textarea type="text"  placeholder="..."  rows="10" cols="80" style="margin: 0px; width: 600px; height: 80px;" id="proyecto-objetivo_general" name="Proyecto[objetivo_general]"  required><?= $proyecto->objetivo_general?></textarea>
                <h5>Señale los Objetos Especificos:<h5>
                <a href="#" >
                 Lista Objetos Especificos
                </a> 
            </li>
            <li>
                <h4>1.11 Plan de Trabajo</h4>
                <label for="proyecto-plan_trabajo">Descripción:</label>
                <textarea type="text"  placeholder="..."  rows="10" cols="80" style="margin: 0px; width: 600px; height: 300px;" id="proyecto-plan_trabajo" name="Proyecto[plan_trabajo]"  required><?= $proyecto->plan_trabajo?></textarea>
                <h5>Señale las Actividades para cada Objetivo Específico referidos en el punto 1.10.:<h5>
                <a href="#" >
                 Lista de Actividades
                </a> 
            </li>
            <li>
                <h4>1.12 Resultados Esperados en Innovación Agraria o Transferencia de Tecnología</h4>
                <label for="proyecto-resultados_esperados">Descripción:</label>
                <textarea type="text"  placeholder="..."  rows="10" cols="80" style="margin: 0px; width: 600px; height: 200px;" id="proyecto-resultados_esperados" name="Proyecto[resultados_esperados]"  required><?= $proyecto->resultados_esperados?></textarea>

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
                <label for="proyecto-presupuesto">Monto Total:</label>
                <input type="text" value="<?= $proyecto->presupuesto?>" placeholder="Presupuesto"  id="proyecto-presupuesto" name="Proyecto[presupuesto]"  required/>
                
            </li>
            <li>
                <h4>1.16 Lista de Referencias Bibliográficas</h4>
                <label for="proyecto-referencias_bibliograficas">Señale las Referencias:</label>
                <textarea type="text"  placeholder="..."  rows="10" cols="80" style="margin: 0px; width: 600px; height: 200px;" id="proyecto-referencias_bibliograficas" name="Proyecto[referencias_bibliograficas]"  required><?= $proyecto->referencias_bibliograficas?></textarea>

            </li>
            <li>
            <button type="submit" id="btnproyecto" class="btn btn-primary">Guardar</button>
            </li>
            <li>
                
                
            </li>
        
        </ul>
    </div>

 <?php ActiveForm::end(); ?>


<?php

    $urlproyecto= Yii::$app->getUrlManager()->createUrl('proyecto/guardar');
    $urlresponsable= Yii::$app->getUrlManager()->createUrl('responsable/guardar');
    /*$validarintegrante2= Yii::$app->getUrlManager()->createUrl('equipo/validarintegrante2');
    $existeequipo=Yii::$app->getUrlManager()->createUrl('equipo/existeequipo');*/
?>

