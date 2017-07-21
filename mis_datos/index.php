<?
session_start();
$se_id_doctor=$_SESSION["s_id_doctor"];
$se_usuario_doctor=$_SESSION["s_usuario_doctor"];
$se_password_doctor=$_SESSION["s_password_doctor"];
include("../administrador/php/conexion.php");
include("../administrador/php/func_bd.php");
include("../administrador/php/func.php");
if(!empty($se_id_doctor) and !empty($se_usuario_doctor) and !empty($se_password_doctor)):
	//Buscar datos de doctor
	$c_doc=buscar("doc.id_doctor
						,doc.titulo
						,doc.nombres
						,doc.apellidos
						,doc.usuario
						,doc.password						
						,doc.portada
						,doc.imagen		
						,doc.id_especialidad
						,esp.especialidad
						,doc.calle
						,doc.no_exterior
						,doc.no_interior
						,doc.consultorio
						,doc.colonia
						,doc.municipio
						,doc.id_estado
						,est.estado
						,doc.codigo_postal
						,doc.hospital
						,doc.email
						,doc.sitio_web
						,doc.telefono
						,doc.celular
						,doc.horarios
						,doc.institucion_egreso
						,doc.institucion_especialidad
						,doc.subespecialidad
						,doc.expertise
						,doc.cedula_profesional
						,doc.certificaciones
						,doc.anios_experiencia
						,doc.formacion
						,doc.actividades_realizadas
						,doc.membresias_asociaciones
						,doc.porcentaje_descuento
						,doc.costo_vrim_de
						,doc.costo_vrim_a
						,doc.costo_aseguradora_de
						,doc.costo_aseguradora_a
						,doc.costo_normal_de
						,doc.costo_normal_a
						,doc.activar_articulos
						,doc.activar_paquetes				
						,doc.activar_videos
						,doc.activar_fotos
						"
						,"doctores doc
						LEFT OUTER JOIN
						especialidades esp
						ON esp.id_especialidad=doc.id_especialidad
						LEFT OUTER JOIN
						estados est
						ON est.id_estado=doc.id_estado"
						,"WHERE 	doc.id_doctor=".$se_id_doctor." 
							AND	doc.usuario='".$se_usuario_doctor."'
							AND	doc.password='".$se_password_doctor."' /*
							AND	doc.estatus='activo' */");
	while($f_doc=mysql_fetch_assoc($c_doc)):
		$id_doctor=$f_doc["id_doctor"];
		$titulo=cadena($f_doc["titulo"]);
		$nombres=cadena($f_doc["nombres"]);
		$apellidos=cadena($f_doc["apellidos"]);
		$doctor=cadena($f_doc["titulo"])." ".cadena($f_doc["nombres"])." ".cadena($f_doc["apellidos"]);
		$usuario=cadena($f_doc["usuario"]);
		$password=cadena($f_doc["password"]);
		$portada_doctor=$f_doc["portada"];
		$imagen_doctor=$f_doc["imagen"];
		$id_especialidad_doctor=$f_doc["id_especialidad"];
		$especialidad_doctor=cadena($f_doc["especialidad"]);
		$calle=cadena($f_doc["calle"]);
		$no_exterior=cadena($f_doc["no_exterior"]);
		$no_interior=cadena($f_doc["no_interior"]);
		$consultorio=cadena($f_doc["consultorio"]);
		$colonia=cadena($f_doc["colonia"]);
		$municipio=cadena($f_doc["municipio"]);
		$id_estado_doctor=$f_doc["id_estado"];
		$estado=cadena($f_doc["estado"]);
		$codigo_postal=cadena($f_doc["codigo_postal"]);
		$hospital=cadena($f_doc["hospital"]);
		$email=cadena($f_doc["email"]);
		$sitio_web=cadena($f_doc["sitio_web"]);
		$telefono=cadena($f_doc["telefono"]);
		$celular=cadena($f_doc["celular"]);
		$horarios=cadena($f_doc["horarios"]);
		$institucion_egreso=cadena($f_doc["institucion_egreso"]);
		$institucion_especialidad=cadena($f_doc["institucion_especialidad"]);
		$subespecialidad=cadena($f_doc["subespecialidad"]);
		$expertise=cadena($f_doc["expertise"]);
		$cedula_profesional=cadena($f_doc["cedula_profesional"]);
		$certificaciones=cadena($f_doc["certificaciones"]);
		$anios_experiencia=$f_doc["anios_experiencia"];
		$formacion=cadena($f_doc["formacion"]);
		$actividades_realizadas=cadena($f_doc["actividades_realizadas"]);
		$membresias_asociaciones=cadena($f_doc["membresias_asociaciones"]);
		$porcentaje_descuento=$f_doc["porcentaje_descuento"];
		$costo_vrim_de=moneda($f_doc["costo_vrim_de"],2);
		$costo_vrim_a=moneda($f_doc["costo_vrim_a"],2);
		$costo_aseguradora_de=moneda($f_doc["costo_aseguradora_de"],2);
		$costo_aseguradora_a=moneda($f_doc["costo_aseguradora_a"],2);
		$costo_normal_de=moneda($f_doc["costo_normal_de"],2);
		$costo_normal_a=moneda($f_doc["costo_normal_a"],2);
		$activar_articulos=$f_doc["activar_articulos"];
		$activar_paquetes=$f_doc["activar_paquetes"];
		$activar_videos=$f_doc["activar_videos"];
		$activar_fotos=$f_doc["activar_fotos"];
	endwhile;
endif;
if(empty($doctor)):
	$seccion="Mis Datos";
else:
	$seccion=$doctor;	
endif;
if(empty($tipo_seccion)):
	$tipo_seccion="mis_datos";
endif;
$descripcion_corta="consultatudoc.com.mx es una herramienta web que simplifica la interacción entre pacientes y doctores a través de una estrategia basada en contenidos médicos de calidad elaborados por los doctores mismos, redactados de manera sencilla; los cuales les permiten darse a conocer con los usuarios.";
require_once('../libraries/Page.php');
$page = new Page;
$page->setTitle($seccion);
$page->setTipo($tipo_seccion);
$page->setDescription($descripcion_corta);
$page->setKeywords($palabras_clave);
$page->addCSS('../css/doctores.css');
$page->startBody();
?>
<script src="../assets/nicEdit/nicEdit.js" type="text/javascript"></script>
<script type="text/javascript">
//bkLib.onDomLoaded(function(){nicEditors.allTextAreas()});
//bkLib.onDomLoaded(function(){
	new nicEditor().panelInstance("sitio_web");
	<? /*
	new nicEditor().panelInstance("expertise");
	new nicEditor().panelInstance("institucion_egreso");
	new nicEditor().panelInstance("institucion_especialidad");
	new nicEditor().panelInstance("subespecialidad");
	new nicEditor().panelInstance("membresias_asociaciones");
	new nicEditor().panelInstance("certificaciones");
	*/
	?>
//});
</script>
<section id="breadcrumbs" class="breadcrumbs_section cs section_padding_25 gradient table_section table_section_md">
    <div class="container">
        <div class="row">
            <div class="col-md-6 text-center text-md-left">
            </div>
            <div class="col-md-6 text-center text-md-right">
                <ol class="breadcrumb">
                    <li>
                        <a href="http://consultatudoc.com.mx/">
                            <span>
                                <i class="rt-icon2-home"></i>
                            </span>
                        </a>
                    </li>
                    <li class="active">Mis Datos</li>
                </ol>
        	</div>
        </div>
    </div>
</section>
<?
if(!empty($id_doctor) and $se_id_doctor==$id_doctor):
	//Idiomas del doctor
	$arreglo_idiomas=array();
	$c_idi=buscar("id_idioma","idiomas_doctores","WHERE id_doctor='".$se_id_doctor."'");
	if(mysql_num_rows($c_idi)>0):
		while($f_idi=mysql_fetch_assoc($c_idi)):
			$id_idioma=$f_idi["id_idioma"];
			$arreglo_idiomas[]=$id_idioma;
			unset($id_idioma);
		endwhile; unset($f_idi);
	endif; unset($c_idi);

	//Aseguradoras del doctor
	$arreglo_aseguradoras=array();
	$c_ase=buscar("id_aseguradora","aseguradoras_doctores","WHERE id_doctor='".$se_id_doctor."'");
	if(mysql_num_rows($c_ase)>0):
		while($f_ase=mysql_fetch_assoc($c_ase)):
			$id_aseguradora=$f_ase["id_aseguradora"];
			$arreglo_aseguradoras[]=$id_aseguradora;
			unset($id_aseguradora);
		endwhile; unset($f_ase);
	endif; unset($c_ase);

	//Hospitales del doctor
	$arreglo_hospitales=array();
	$c_hos=buscar("id_hospital","hospitales_doctores","WHERE id_doctor='".$se_id_doctor."'");
	if(mysql_num_rows($c_hos)>0):
		while($f_hos=mysql_fetch_assoc($c_hos)):
			$id_hospital=$f_hos["id_hospital"];
			$arreglo_hospitales[]=$id_hospital;
			unset($id_hospital);
		endwhile; unset($f_ase);
	endif; unset($c_hos);
	
	//Padecimientos del doctor
	$arreglo_padecimientos=array();
	$c_pad=buscar("id_padecimiento","padecimientos_doctores","WHERE id_doctor='".$se_id_doctor."'");
	if(mysql_num_rows($c_pad)>0):
		while($f_pad=mysql_fetch_assoc($c_pad)):
			$id_padecimiento=$f_pad["id_padecimiento"];
			$arreglo_padecimientos[]=$id_padecimiento;
			unset($id_padecimiento);
		endwhile; unset($f_pad);
	endif; unset($c_pad);
endif;
?>
<section id="content" class="ls section_padding_top_25 section_padding_bottom_25">
    <div class="container">
    	<div class="row ls_fondo4">
      	<?
			if(!empty($id_doctor) and $se_id_doctor==$id_doctor):
				$page->addDoctor($doctor);
				?>
            <div class="col-xs-12 col-sm-12 col-md-11 col-md-offset-1">
           	   <!-- Nav tabs -->
					<ul class="nav nav-tabs topmargin_0" role="tablist">
               	<li class="active"><a href="#tab1" role="tab" data-toggle="tab">Mis Datos</a></li>
                  <li><a href="#tab2" role="tab" data-toggle="tab">Formación Profesional</a></li>    
                  <li><a href="#tab3" role="tab" data-toggle="tab">Información laboral</a></li>
                  <?
						if($activar_articulos=="si"):
							?>
	                  <li><a href="#tab4" role="tab" data-toggle="tab">Mis artículos</a></li>
                     <?
						 endif;
						if($activar_paquetes=="si"):
							?>
	                  <li><a href="#tab5" role="tab" data-toggle="tab">Mis paquetes</a></li>
                     <?
						 endif;
						 if($activar_videos=="si"):
							?>
	                  <li><a href="#tab6" role="tab" data-toggle="tab">Mis videos</a></li>
                   	<?
						 endif;
						 if($activar_fotos=="si"):
						 	?>
	                  <li><a href="#tab7" role="tab" data-toggle="tab">Mis fotos</a></li>
                     <?
						 endif;
						?>
					</ul>
					<!-- Tab panes -->
                <div class="tab-content top-color-border bottommargin_30">
                    <div class="tab-pane fade in active" id="tab1">
                 			<style>
								#form_datos{display: block; margin:10px auto; background:rgba(0, 0, 0, 0.1); border-radius: 10px; padding: 15px }
								#form_datos .nicEdit-main{
									background-color:#FFFFFF;
								}
								.progress_datos{position:relative; width:100%; border: 1px solid #ddd; padding: 1px; border-radius: 3px; }
								.bar_datos{background-color:#0087a4;width:0%; height:33px; border-radius: 3px; margin:0 !important;}
								.percent_datos{position:absolute;color:#FFFFFF !important;display:inline-block; top:3px; left:48%; }
								</style>   
                        <h3>Mis Datos:</h3>
                        <form id="form_datos" action="../inc/ajax_datos.php" method="post" enctype="multipart/form-data">
                         <!--mis_datos-->
                        <div id="div_datos">
                           <div class="row">
                              <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                              Título:
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                 <select name="titulo">
                                 <option value="Lic." <? if($titulo=="Lic."): ?> selected="selected" <? endif;?>>Lic.</option>
                                 <option value="Dr." <? if($titulo=="Dr."): ?> selected="selected" <? endif;?>>Dr.</option>
                                 <option value="Dra." <? if($titulo=="Dra."): ?> selected="selected" <? endif;?>>Dra.</option>
                                 </select>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                 Nombre(s):
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                 <input type="text" name="nombres" value="<?=$nombres?>" maxlength="255" required="required"> *
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                 Apellidos:
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                 <input type="text" name="apellidos" value="<?=$apellidos?>" maxlength="255" required="required"> *
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                 Usuario:
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                 <input type="text" name="usuario" value="<?=$usuario?>" maxlength="100" required="required"> *
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                 Contraseña:
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                 <input type="password" name="password" value="<?=$password?>" maxlength="100" required="required"> *
                              </div>
                           </div>
                           <?
                           if(!empty($portada_doctor) and file_exists("../administrador/doctores/images/".$portada_doctor)):
                              ?>
                              <div class="row">
                                 <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                    Portada actual:
                                 </div>
                                 <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                    <img src="../administrador/doctores/images/<?=$portada_doctor?>" style="max-width:100%;">
                                 </div>
                              </div>                        
                              <div class="row">
                                 <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                 </div>
                                 <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                    <input type="checkbox" name="eliminar_portada">Eliminar portada
                                 </div>
                              </div>                        
                              <div class="row">
                                 <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                    Sustituir por:
                                 </div>
                                 <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                    <input type="file" name="portada"/>
                                    <br />
                                    <span>Le sugerimos una imagen de 1140 x 422 pixeles y formato JPG</span>
                                 </div>
                              </div>                        
                              <?
                           else:
                              ?>
                              <div class="row">
                                 <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                    Portada:
                                 </div>
                                 <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                    <input type="file" name="portada"/>
                                    <br />
                                    <span>Le sugerimos una imagen de 1140 x 422 pixeles y formato JPG</span> 
                                 </div>
                              </div>      
                              <?
                           endif;
                           if(!empty($imagen_doctor) and file_exists("../administrador/doctores/images/".$imagen_doctor)):
                              ?>
                              <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">Imagen actual</div>
                                <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                 <img src="../administrador/doctores/images/<?=$imagen_doctor?>" style="max-width:100%;">
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2"></div>
                                <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                    <input type="checkbox" name="eliminar_imagen">Eliminar imagen
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">Sustituir por:</div>
                                <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                    <input type="file" name="imagen"/>
                                    <br />
                                    <span>Le sugerimos una imagen de 225 x 225 pixeles y formato JPG</span>                                      
                                </div>
                              </div>
                              <?
                           else:
                              ?>
                              <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">Imagen</div>
                                <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                    <input type="file" name="imagen"/>
                                    <br />
                                    <span>Le sugerimos una imagen de  225 x 225 pixeles y formato JPG</span>                                      
                                 </div>
                              </div>
                              <?
                           endif;
                           ?>
                           <div class="row">
                              <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                 Calle
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                 <input type="text" name="calle" value="<?=$calle?>" maxlength="255" required="required"> *
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                 Número exterior
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                 <input type="text" name="no_exterior" value="<?=$no_exterior?>" maxlength="100">
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                 Número interior
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                 <input type="text" name="no_interior" value="<?=$no_interior?>" maxlength="100">
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                 Consultorio
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                 <input type="text" name="consultorio" value="<?=$consultorio?>" maxlength="100">
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                 Colonia
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                 <input type="text" name="colonia" value="<?=$colonia?>" maxlength="255" required="required"> *
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                 Código Postal
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                 <input type="text" name="codigo_postal" value="<?=$codigo_postal?>" maxlength="100" required="required"> *
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                 Delegación o Municipio
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                 <input type="text" name="municipio" value="<?=$municipio?>" maxlength="255" required="required"> *
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                 Estado
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                 <?
                                    $c_est=buscar("id_estado,estado","estados","ORDER BY estado ASC");
                                    ?>
                                    <select name="id_estado" required>
                                       <option value="">Seleccione ...</option>
                                       <?
                                       if(mysql_num_rows($c_est)):
                                          while($f_est=mysql_fetch_assoc($c_est)):
                                             $id_estado=$f_est["id_estado"];
                                             $estado=cadena($f_est["estado"]);
                                             ?>
                                             <option value="<?=$id_estado?>" <? if($id_estado==$id_estado_doctor): ?> selected="selected" <? endif;?>><?=$estado?></option>
                                             <?
                                             unset($id_estado,$estado);
                                          endwhile; unset($f_est);
                                       endif; unset($c_est);
                                       ?>
                                    </select>
                                  *
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                 Hospital
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                 <input type="text" name="hospital" value="<?=$hospital?>" maxlength="255">
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                 Email
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                 <input type="text" name="email" value="<?=$email?>" maxlength="255" required/> *
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                 Sitio web
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                 <textarea id="sitio_web" name="sitio_web" style="width:100%;height:100px;"><?=$sitio_web?></textarea>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                 Teléfono(s)
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                 <input type="text" name="telefono" value="<?=$telefono?>" maxlength="255"/>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                 Celular
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                 <input type="text" name="celular" value="<?=$celular?>" maxlength="255"/>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                 Consultorios
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                              	<?
                                 $c_con=buscar("consultorio,telefonos,horarios","consultorios_doctores","WHERE id_doctor='".$se_id_doctor."' ORDER BY consultorio ASC");
                                 $ficon=mysql_num_rows($c_con);
                                 if($ficon>0):
                                    ?>
                                    <input type="hidden" id="contador_consultorios" name="contador_consultorios" value="<?=$ficon?>">
                                    <input type="button" class="agregar_consultorio" value="Agregar consultorio" style="margin-bottom:10px; clear:both;">
                                    <div id="message_consultorios" style="clear:both;"></div>
                                    <div id="div_consultorios">
                                       <?
                                       $con_con=0;
                                       while($f_con=mysql_fetch_assoc($c_con)):
                                          $con_con++;
														$consultorio=cadena($f_con["consultorio"]);
														$telefonos=cadena($f_con["telefonos"]);
														$horarios=cadena($f_con["horarios"]);
                                          ?>
                                          <div style="clear:both; margin-bottom:10px;padding-top:10px;">
	                                          <div style="display:inline-block; margin-right:7px; margin-bottom:7px;">
                                             Consultorio: <input type="text" name="consultorio<?=$con_con?>" id="consultorio<?=$con_con?>" value="<?=$consultorio?>">
                                             </div>
                                             <div style="display:inline-block; margin-right:7px; margin-bottom:7px;">
                                                Tel(s): <input type="text" name="telefonos<?=$con_con?>" id="telefonos<?=$con_con?>" value="<?=$telefonos?>"> 
                                             </div>
                                             <div style="display:inline-block; margin-right:7px; margin-bottom:7px;">
	                                             Horarios: <input type="text" name="horarios<?=$con_con?>" id="horarios<?=$con_con?>" value="<?=$horarios?>"> 
                                             </div>
                                          </div>
                                          <?
                                          unset($consultorio,$telefonos,$horarios);
                                       endwhile;
                                       unset($con_con,$f_con);
                                       ?>
                                    </div>
                                    <?
                                 else:
                                    ?>
                                    <input type="hidden" id="contador_consultorios" name="contador_consultorios" value="1">
                                    <input type="button" class="agregar_consultorio" value="Agregar consultorio" style="margin-bottom:10px; clear:both;">
                                    <div id="message_consultorios" style="clear:both;"></div>
                                    <div id="div_consultorios">
                                       <div style="clear:both; margin-bottom:10px;padding-top:10px;">
                                       	<div style="display:inline-block; margin-right:7px; margin-bottom:7px;">
	                                       	Consultorio: <input type="text" name="consultorio1" id="consultorio1" value="">
                                          </div>
                                          <div style="display:inline-block; margin-right:7px; margin-bottom:7px;">
		                                       Tel(s): <input type="text" name="telefonos1" id="telefonos1" value=""> 
                                          </div>
                                          <div style="display:inline-block; margin-right:7px; margin-bottom:7px;">
		                                       Horarios: <input type="text" name="horarios1" id="horarios1" value=""> 
                                          </div>
                                       </div>
                                    </div>
												<?
                                 endif;
                                 unset($c_con,$ficon);
                                 ?>
                           	</div>
                           </div>
                           <div class="row">
                              <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                 Horarios de Atención
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                 <?
                                 $c_hor=buscar("horario_de,horario_a,dias","horarios_doctores","WHERE id_doctor='".$se_id_doctor."' ORDER BY horario_de ASC");
                                 $fihor=mysql_num_rows($c_hor);
                                 if($fihor>0):
                                    ?>
                                    <input type="hidden" id="contador_horario" name="contador_horario" value="<?=$fihor?>">
                                    <input type="button" class="agregar_horario" value="Agregar horario" style="margin-bottom:10px; clear:both;">
                                    <div id="message" style="clear:both;"></div>
                                    <div id="div_horarios">
                                       <?
                                       $con_hor=0;
                                       while($f_hor=mysql_fetch_assoc($c_hor)):
                                          $con_hor++;
                                          $horario_de=$f_hor["horario_de"];
                                          $horario_a=$f_hor["horario_a"];
                                          $dias=explode(",",cadena($f_hor["dias"]));
                                          ?>
                                          <div style="clear:both; margin-bottom:10px;padding-top:10px;">
                                          De: <select id="horarios_de<?=$con_hor?>" name="horarios_de<?=$con_hor?>">
                                             <?
                                             for($hor=8;$hor<=20;$hor++):
                                                $var_hor=sprintf("%02d",$hor).":00:00";
                                                if($hor<12):
                                                   $for_hor=sprintf("%02d",$hor).":00 a.m.";
                                                else:
                                                   if($hor==12):
                                                      $for_hor=sprintf("%02d",$hor).":00 p.m.";
                                                   else:
                                                      $for_hor=sprintf("%02d",($hor-12)).":00 p.m.";
                                                   endif;
                                                endif;
                                                ?>
                                                <option value="<?=$var_hor?>" <? if($horario_de==$var_hor):?> selected="selected" <? endif;?>><?=$for_hor?></option>
                                                <?
                                             endfor;
                                             ?>
                                          </select>
                                          
                                          A: <select name="horarios_a<?=$con_hor?>">
                                             <?
                                             for($hor=8;$hor<=20;$hor++):
                                                $var_hor=sprintf("%02d",$hor).":00:00";
                                                if($hor<12):
                                                   $for_hor=sprintf("%02d",$hor).":00 a.m.";
                                                else:
                                                   if($hor==12):
                                                      $for_hor=sprintf("%02d",$hor).":00 p.m.";
                                                   else:
                                                      $for_hor=sprintf("%02d",($hor-12)).":00 p.m.";
                                                   endif;
                                                endif;
                                                ?>
                                                <option value="<?=$var_hor?>" <? if($horario_a==$var_hor):?> selected="selected" <? endif;?>><?=$for_hor?></option>
                                                <?
                                             endfor;
                                             ?>
                                          </select>
                                          <br>
                                          <div style="display:inline-block; margin-right:15px; margin-bottom:7px;">
                                             <input type="checkbox" name="horarios_dias<?=$con_hor?>[]" value="Domingo" <? if(in_array("Domingo",$dias)):?> checked="checked" <? endif;?>>Domingo 
                                          </div>
                                          <div style="display:inline-block; margin-right:15px; margin-bottom:7px;">
                                             <input type="checkbox" name="horarios_dias<?=$con_hor?>[]" value="Lunes" <? if(in_array("Lunes",$dias)):?> checked="checked" <? endif;?>>Lunes 
                                          </div>
                                          <div style="display:inline-block; margin-right:15px; margin-bottom:7px;">
                                             <input type="checkbox" name="horarios_dias<?=$con_hor?>[]" value="Martes" <? if(in_array("Martes",$dias)):?> checked="checked" <? endif;?>>Martes
                                          </div>
                                          <div style="display:inline-block; margin-right:15px; margin-bottom:7px;">
                                             <input type="checkbox" name="horarios_dias<?=$con_hor?>[]" value="Miércoles" <? if(in_array("Miércoles",$dias)):?> checked="checked" <? endif;?>>Miércoles
                                          </div>
                                          <div style="display:inline-block; margin-right:15px; margin-bottom:7px;">
                                             <input type="checkbox" name="horarios_dias<?=$con_hor?>[]" value="Jueves" <? if(in_array("Jueves",$dias)):?> checked="checked" <? endif;?>>Jueves
                                          </div>
                                          <div style="display:inline-block; margin-right:15px; margin-bottom:7px;">
                                             <input type="checkbox" name="horarios_dias<?=$con_hor?>[]" value="Viernes" <? if(in_array("Viernes",$dias)):?> checked="checked" <? endif;?>>Viernes
                                          </div>
                                          <div style="display:inline-block; margin-right:15px; margin-bottom:7px;">
                                             <input type="checkbox" name="horarios_dias<?=$con_hor?>[]" value="Sábado" <? if(in_array("Sábado",$dias)):?> checked="checked" <? endif;?>>Sábado
                                          </div>
                                          </div>
                                          <?
                                          unset($horario_de,$horario_a,$dias);
                                       endwhile;
                                       unset($con_hor,$f_hor);
                                       ?>
                                    </div>
                                    <?
                                 else:
                                    ?>
                                    <input type="hidden" id="contador_horario" name="contador_horario" value="1">
                                    <input type="button" class="agregar_horario" value="Agregar horario" style="margin-bottom:10px; clear:both;">
                                    <div id="message" style="clear:both;"></div>
                                    <div id="div_horarios">
                                       <div style="clear:both; margin-bottom:10px;padding-top:10px;">
                                       De: <select id="horarios_de1" name="horarios_de1">
                                          <?
                                          for($hor=8;$hor<=20;$hor++):
                                             if($hor<12):
                                                $for_hor=sprintf("%02d",$hor).":00 a.m.";
                                             else:
                                                if($hor==12):
                                                   $for_hor=sprintf("%02d",$hor).":00 p.m.";
                                                else:
                                                   $for_hor=sprintf("%02d",($hor-12)).":00 p.m.";
                                                endif;
         
                                             endif;
                                             ?>
                                             <option value="<?=sprintf("%02d",$hor).":00"?>"><?=$for_hor?></option>
                                             <?
                                          endfor;
                                          ?>
                                       </select>
                                       
                                       A: <select name="horarios_a1">
                                          <?
                                          for($hor=8;$hor<=20;$hor++):
                                             if($hor<12):
                                                $for_hor=sprintf("%02d",$hor).":00 a.m.";
                                             else:
                                                if($hor==12):
                                                   $for_hor=sprintf("%02d",$hor).":00 p.m.";
                                                else:
                                                   $for_hor=sprintf("%02d",($hor-12)).":00 p.m.";
                                                endif;
                                             endif;
                                             ?>
                                             <option value="<?=sprintf("%02d",$hor).":00"?>"><?=$for_hor?></option>
                                             <?
                                          endfor;
                                          ?>
                                       </select>
                                       <br>
                                       <div style="display:inline-block; margin-right:15px; margin-bottom:7px;">
                                          <input type="checkbox" name="horarios_dias1[]" value="Domingo">Domingo 
                                       </div>
                                       <div style="display:inline-block; margin-right:15px; margin-bottom:7px;">
                                          <input type="checkbox" name="horarios_dias1[]" value="Lunes" checked>Lunes 
                                       </div>
                                       <div style="display:inline-block; margin-right:15px; margin-bottom:7px;">
                                          <input type="checkbox" name="horarios_dias1[]" value="Martes" checked>Martes
                                       </div>
                                       <div style="display:inline-block; margin-right:15px; margin-bottom:7px;">
                                          <input type="checkbox" name="horarios_dias1[]" value="Miércoles" checked>Miércoles
                                       </div>
                                       <div style="display:inline-block; margin-right:15px; margin-bottom:7px;">
                                          <input type="checkbox" name="horarios_dias1[]" value="Jueves" checked>Jueves
                                       </div>
                                       <div style="display:inline-block; margin-right:15px; margin-bottom:7px;">
                                          <input type="checkbox" name="horarios_dias1[]" value="Viernes" checked>Viernes
                                       </div>
                                       <div style="display:inline-block; margin-right:15px; margin-bottom:7px;">
                                          <input type="checkbox" name="horarios_dias1[]" value="Sábado">Sábado
                                       </div>
                                       </div>
                                    </div>
												<?
                                 endif;
                                 unset($c_hor,$fihor);
                                 ?>                                 
		                        </div>
                           </div>
                        </div>
                        <!--mis_datos-->
                        <div class="row">
                           <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                              <input type="hidden" name="action_datos" value="send">
                           </div>
                           <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                              <button type="submit" id="form_datos_submit" name="form_datos_submit" class="theme_button" onclick="nicEditors.findEditor('sitio_web').saveContent();">Actualizar Datos</button>
                           </div>
                        </div>
                        <div class="row">
                        	<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                           </div>
                           <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                           	<div class="progress_datos">
                                 <div class="bar_datos"></div>
                                 <div class="percent_datos">0%</div>
                              </div>
                              <div id="status_datos"></div>
                           </div>
                        </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="tab2">
                 			<style>
								#form_formacion{display: block; margin:10px auto; background:rgba(0, 0, 0, 0.1); border-radius: 10px; padding: 15px }
								#form_formacion .nicEdit-main{
									background-color:#FFFFFF;
								}
								.progress_formacion{position:relative; width:100%; border: 1px solid #ddd; padding: 1px; border-radius: 3px; }
								.bar_formacion{background-color:#0087a4;width:0%; height:33px; border-radius: 3px; margin:0 !important;}
								.percent_formacion{position:absolute;color:#FFFFFF !important;display:inline-block; top:3px; left:48%; }
								</style>   
                        <h3>Formación Profesional:</h3>
                        <form id="form_formacion" action="../inc/ajax_formacion_profesional.php" method="post" enctype="multipart/form-data">
                         <!--div_formacion-->
                        <div id="div_formacion"></div>
                        <!--div_formacion-->                           
                        <div class="row">
                           <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                              <input type="hidden" name="action_formacion" value="send">
                           </div>
                           <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                              <button type="submit" id="form_formacion_submit" name="form_formacion_submit" class="theme_button" onclick="nicEditors.findEditor('expertise').saveContent();">Actualizar Datos</button>
                           </div>
                        </div>
                        <div class="row">
                        	<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                           </div>
                           <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                           	<div class="progress_formacion">
                                 <div class="bar_formacion"></div>
                                 <div class="percent_formacion">0%</div>
                              </div>
                              <div id="status_formacion"></div>
                           </div>
                        </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="tab3">
                 			<style>
								#form_laboral{display: block; margin:10px auto; background:rgba(0, 0, 0, 0.1); border-radius: 10px; padding: 15px }
								#form_laboral .nicEdit-main{
									background-color:#FFFFFF;
								}
								.progress_laboral{position:relative; width:100%; border: 1px solid #ddd; padding: 1px; border-radius: 3px; }
								.bar_laboral{background-color:#0087a4;width:0%; height:33px; border-radius: 3px; margin:0 !important;}
								.percent_laboral{position:absolute;color:#FFFFFF !important;display:inline-block; top:3px; left:48%; }
								</style>   
	                     <h3>Información laboral</h3>
                        <form id="form_laboral" action="../inc/ajax_informacion_laboral.php" method="post" enctype="multipart/form-data">
                         <!--div_laboral-->
                        <div id="div_laboral"></div>
                        <!--div_laboral-->
                        <div class="row">
                           <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                              <input type="hidden" name="action_laboral" value="send">
                           </div>
                           <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                              <button type="submit" id="form_laboral_submit" name="form_laboral_submit" class="theme_button" onclick="nicEditors.findEditor('institucion_egreso').saveContent();nicEditors.findEditor('institucion_especialidad').saveContent();nicEditors.findEditor('subespecialidad').saveContent();nicEditors.findEditor('membresias_asociaciones').saveContent();nicEditors.findEditor('certificaciones').saveContent();">Actualizar Datos</button>
                           </div>
                        </div>
                        <div class="row">
                        	<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                           </div>
                           <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                           	<div class="progress_laboral">
                                 <div class="bar_laboral"></div>
                                 <div class="percent_laboral">0%</div>
                              </div>
                              <div id="status_laboral"></div>
                           </div>
                        </div>                        
                        </form>
                    </div>
                    <?
						  if($activar_articulos=="si"):
							  ?>
							  <!--Mis artículos-->
							  <div class="tab-pane fade" id="tab4">
									<div class="row">
										<div class="col-sm-12 col-md-12 col-lg-12">
											<button id="nuevo_articulo" name="nuevo_articulo" class="theme_button">Nuevo artículo</button>
										</div>
									</div>
									<!--div_articulo-->
									<div id="div_articulo"></div>
									<!--div_articulo-->
									 <!--div_articulos-->
									<div id="div_articulos">
									</div>
									 <!--div_articulos-->
							  </div>
							  <!--Mis artículos-->
                      	<?
							endif;
							if($activar_paquetes=="si"):
							  ?>
							  <!--Mis paquetes-->
							  <div class="tab-pane fade" id="tab5">
									<div class="row">
										<div class="col-sm-12 col-md-12 col-lg-12">
											<button id="nuevo_paquete" name="nuevo_paquete" class="theme_button">Nuevo paquete</button>
										</div>
									</div>
									<!--div_paquete-->
									<div id="div_paquete">
									</div>
									<!--div_paquete-->
									 <!--div_paquetes-->
									<div id="div_paquetes">
									</div>
									 <!--div_paquetes-->
							  </div>
							  <!--Mis paquetes-->
                      	<?
							endif;
							if($activar_videos=="si"):
								?>
                       <!--Mis videos-->
                       <div class="tab-pane fade" id="tab6">
                          <div class="row">
                              <div class="col-sm-12 col-md-12 col-lg-12">
                                 <button id="nuevo_video" name="nuevo_video" class="theme_button">Nuevo video</button>
                              </div>
                           </div>
                           <!--div_video-->
                           <div id="div_video">
                           </div>
                           <!--div_video-->
                            <!--div_videos-->
                           <div id="div_videos">
                           </div>
                            <!--div_videos-->
                       </div>
                       <!--Mis videos-->                        
                        <?
							endif;
							if($activar_fotos=="si"):
								?>
                       <!--Mis fotos-->
                       <div class="tab-pane fade" id="tab7">
                           <div class="row">
                              <div class="col-sm-12 col-md-12 col-lg-12">
                                 <button id="nuevo_foto" name="nuevo_foto" class="theme_button">Nueva foto</button>
                              </div>
                           </div>
                           <!--div_foto-->
                           <div id="div_foto">
                           </div>
                           <!--div_foto-->
                            <!--div_fotos-->
                           <div id="div_fotos">
                           </div>
                            <!--div_fotos-->              
                       </div>
                       <!--Mis fotos-->                        
                        <?
							endif;
							?>
                 </div>
            </div>
            <?
			endif;
			?>
      </div>
    </div>
</section>
<?
$page->endBody();
echo $page->render('../inc/template.php');
?>