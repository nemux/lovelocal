<?
session_start();
ini_set("display_errors","On");
$se_id_perfil=isset($_SESSION["s_id_perfil"]) ? $_SESSION["s_id_perfil"] : "";
$se_usuario_perfil=isset($_SESSION["s_usuario_perfil"]) ? $_SESSION["s_usuario_perfil"] : "";
$se_password_perfil=isset($_SESSION["s_password_perfil"]) ? $_SESSION["s_password_perfil"] : "";
include("../administrador/php/config.php");
include("../administrador/php/func_bd.php");
include("../administrador/php/func.php");
if(!empty($se_id_perfil) and !empty($se_usuario_perfil) and !empty($se_password_perfil)):
	//Buscar datos de perfil
	$c_per=buscar("per.id_perfil
						,per.perfil
						,per.nombres
						,per.apellidos
						,per.usuario
						,per.password		
						,per.local				
						,per.imagen		
						,per.calle
						,per.no_exterior
						,per.no_interior
						,per.colonia
						,per.municipio
						,per.id_estado
						,est.estado
						,per.codigo_postal
						,per.email
						,per.sitio_web
						,per.telefono
						,per.celular
						,per.descripcion_corta
						,per.descripcion_completa
						,per.precio_de
						,per.precio_a"
						,"perfiles per
						LEFT OUTER JOIN
						estados est
						ON est.id_estado=per.id_estado"
						,"WHERE 	per.id_perfil=".$se_id_perfil." 
							AND	per.usuario='".$se_usuario_perfil."'
							AND	per.password='".$se_password_perfil."' 
							AND	per.estatus='activo'",false);
	while($f_per=$c_per->fetch_assoc()):
		$id_perfil=$f_per["id_perfil"];
		$perfil=cadena($f_per["perfil"]);
		$nombres=cadena($f_per["nombres"]);
		$apellidos=cadena($f_per["apellidos"]);
		$perfil=cadena($f_per["perfil"]);
		$usuario=cadena($f_per["usuario"]);
		$password=cadena($f_per["password"]);
		$local=cadena($f_per["local"]);
		$imagen_perfil=$f_per["imagen"];
		$calle=cadena($f_per["calle"]);
		$no_exterior=cadena($f_per["no_exterior"]);
		$no_interior=cadena($f_per["no_interior"]);
		$colonia=cadena($f_per["colonia"]);
		$municipio=cadena($f_per["municipio"]);
		$id_estado_perfil=$f_per["id_estado"];
		$estado=cadena($f_per["estado"]);
		$codigo_postal=cadena($f_per["codigo_postal"]);
		$email=cadena($f_per["email"]);
		$sitio_web=cadena($f_per["sitio_web"]);
		$telefono=cadena($f_per["telefono"]);
		$celular=cadena($f_per["celular"]);
		$descripcion_corta=cadena($f_per["descripcion_corta"]);
		$descripcion_completa=cadena($f_per["descripcion_completa"]);
		$precio_de=$f_per["precio_de"];
		$precio_a=$f_per["precio_a"];
	endwhile;
	//Buscar categorias
	$c_cat=buscar("id_categoria","categorias_perfiles","WHERE id_perfil='".$se_id_perfil."'");
	$arreglo_categorias=array();
	while($f_cat=$c_cat->fetch_assoc()):
		$arreglo_categorias[]=$f_cat["id_categoria"];
	endwhile;
endif;
?>
<!DOCTYPE html> <html class="no-js">
<head>
<title>Mis Datos | Perfiles - ZiiKFOR</title>
<!-- Favicon -->
<link rel="shortcut icon" href="http://www.ziikfor.com/images/favicon.png">
<meta charset="utf-8"><!--[if IE]> <meta http-equiv="X-UA-Compatible" content="IE=edge"><![endif]--> 
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../css/bootstrap.min.css">
<link rel="stylesheet" href="../css/main.css" id="color-switcher-link">
<link rel="stylesheet" href="../css/animations.css">
<link rel="stylesheet" href="../css/fonts.css">
<script src="../js/vendor/modernizr-2.6.2.min.js"></script>
<!--[if lt IE 9]> <script src="js/vendor/html5shiv.min.js"></script> <script src="js/vendor/respond.min.js"></script><![endif]-->
<script src="../assets/nicEdit/nicEdit.js" type="text/javascript"></script>
</head>
<body><!--[if lt IE 9]> <div class="bg-danger text-center">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/" class="highlight">upgrade your browser</a> to improve your 
experience.</div><![endif]-->
<div class="boxed pattern8" id="canvas">
	<div class="container" id="box_wrapper">
   	<?
		include_once("../inc/header.php");
		include_once("../inc/form_busqueda_horizontal2.php");
		?>
      <section id="content" class="ls section_padding_top_25 section_padding_bottom_25">
          <div class="container">
            <div class="row ls_fondo4">
               <?
               if(!empty($id_perfil) and $se_id_perfil==$id_perfil):
						/*
                  <div class="col-xs-12 col-sm-12 col-md-11 col-md-offset-1">*/
                  ?>
                  <div class="col-xs-12 col-sm-12 col-md-12">
                     <!-- Nav tabs -->
                     <ul class="nav nav-tabs topmargin_0" role="tablist">
                        <li class="active"><a href="#tab1" role="tab" data-toggle="tab">Mis Datos</a></li>
                        <li><a href="#tab3" role="tab" data-toggle="tab">Recompensas</a></li>    
                        <li><a href="#tab5" role="tab" data-toggle="tab">Productos</a></li>
                        <?
								if($perfil=="Perfil 2" or $perfil=="Perfil 3"):
									?>
                           <li><a href="#tab7" role="tab" data-toggle="tab">Artículos</a></li>
                           <?
								endif;								
								if($perfil=="Perfil 2" or $perfil=="Perfil 3"):
									?>
                           <li><a href="#tab4" role="tab" data-toggle="tab">Fotos</a></li>    
									<?
								endif;
								if($perfil=="Perfil 3"):
									?>
                           <li><a href="#tab6" role="tab" data-toggle="tab">Videos</a></li>
                          	<?
								endif;
								?>
                        <li><a href="#tab_cupones_perfil" role="tab" data-toggle="tab">Cupones</a></li>
                        <li><a href="#tab8" role="tab" data-toggle="tab">Evaluaciones</a></li>
                        <li><a href="#tab_promociones_perfil" role="tab" data-toggle="tab">Promociones</a></li>
                        <li><a href="#tab_promociones_asignadas_perfil" role="tab" data-toggle="tab">Promociones asignadas</a></li>
                     </ul>
                     <!-- Tab panes -->
                      <div class="tab-content top-color-border bottommargin_30">
                          <div class="tab-pane fade in active" id="tab1">
                              <style>
                              #form_datos{display: block; margin:10px auto; /*background:rgba(0, 0, 0, 0.1);*/ border-radius: 10px; padding: 15px }
                              #form_datos .nicEdit-main{
                                 background-color:#FFFFFF;
                              }
                              .progress_datos{position:relative; width:100%; border: 1px solid #ddd; padding: 1px; border-radius: 3px; }
                              .bar_datos{background-color:#03538E;width:0%; height:33px; border-radius: 3px; margin:0 !important;}
                              .percent_datos{position:absolute;color:#FFFFFF !important;display:inline-block; top:3px; left:48%; }
                              </style>   
                              <form id="form_datos" action="../inc/ajax_datos_perfil.php" method="post" enctype="multipart/form-data">
                               <!--mis_datos-->
                              <div id="div_datos">
	                              <h3>Mis Datos:</h3>
                                 <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                    Perfil:
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                    	<?=$perfil?>
                                       <input type="hidden" id="perfil" value="<?=$perfil?>">
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
	                              <h3>Datos del Local:</h3>        
                                 <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                       Local:
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                       <input type="text" name="local" value="<?=$local?>" maxlength="255" required="required"> *
                                    </div>
                                 </div>              
                                 <?
                                 if(!empty($imagen_perfil) and file_exists("../administrador/perfiles/images/".$imagen_perfil)):
                                    ?>
                                    <div class="row">
                                      <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">Imagen actual</div>
                                      <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                       <img src="../administrador/perfiles/images/<?=$imagen_perfil?>" style="max-width:100%;">
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
                                          <span>Le sugerimos una imagen de 600 x 400 pixeles y formato JPG</span>                                      
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
                                          <span>Le sugerimos una imagen de  600 x 400 pixeles y formato JPG</span>                                      
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
                                             if($c_est->num_rows>0):
                                                while($f_est=$c_est->fetch_assoc()):
                                                   $id_estado=$f_est["id_estado"];
                                                   $estado=cadena($f_est["estado"]);
                                                   ?>
                                                   <option value="<?=$id_estado?>" <? if($id_estado==$id_estado_perfil): ?> selected="selected" <? endif;?>><?=$estado?></option>
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
                                       Rango de precios
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                          De: <input name="precio_de" step="1.00" placeholder="100.00" type="number" value="<?=$precio_de?>"> A: <input name="precio_a" step="1.00" placeholder="100.00" type="number" value="<?=$precio_a?>">
                                    </div>
                                 </div>
											<div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                       Descripción breve del lugar
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
	                                    <textarea id="descripcion_corta" name="descripcion_corta" style="width:100%;height:100px;"><?=$descripcion_corta?></textarea>
                                    </div>
                                 </div>                                 
                                 <?
											if($perfil=="Perfil 2" or $perfil=="Perfil 3"):
												?>
                                    <div class="row">
                                       <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                          Descripción completa del lugar
                                       </div>
                                       <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                          <textarea id="descripcion_completa" name="descripcion_completa" style="width:100%;height:200px;"><?=$descripcion_completa?></textarea>
                                       </div>
                                    </div>     
                                    <?
											endif;
											?>
                                 <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                       Categorías
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                    	<?
													//Buscar categorías 
													$c_cat=buscar("id_categoria,categoria","categorias","WHERE estatus='activo' ORDER BY orden ASC");
													if($c_cat->num_rows>0):
                                          while($f_cat=$c_cat->fetch_assoc()):
                                             $id_categoria=$f_cat["id_categoria"];
                                             $categoria=cadena($f_cat["categoria"]);
                                             ?>
                                             <div style="display:inline-block; margin-right:15px; margin-bottom:7px;">
                                                <input type="checkbox" name="categorias[]" <? if(in_array($id_categoria,$arreglo_categorias)): ?> checked="checked" <? endif;?> value="<?=$id_categoria?>"> <?=$categoria?>
                                             </div>
                                             <?
                                             unset($id_categoria,$categoria);
                                          endwhile;
													endif;
													?>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                       Recompensa inicial
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                    	<?
													$regalo1="";
													$c_rec=buscar("regalo","regalos_perfiles","WHERE id_perfil='".$se_id_perfil."'");
													while($f_rec=$c_rec->fetch_assoc()):
														$regalo1=cadena($f_rec["regalo"]);
													endwhile;
													?>
                                    	<input type="text" name="regalo1" style="width:90%;" maxlength="255" required value="<?=$regalo1?>"> *
                                    </div>
                                 </div>
                              </div>
                              <!--mis_datos-->
                              
                              <div class="row">
                                 <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                    <input type="hidden" name="action_datos" value="send">
                                 </div>
                                 <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                    <button type="submit" id="form_datos_submit" name="form_datos_submit" class="theme_button topmargin_10" onclick="nicEditors.findEditor('sitio_web').saveContent();nicEditors.findEditor('descripcion_corta').saveContent();<? if($perfil=="Perfil 2" or $perfil=="Perfil 3"): ?> nicEditors.findEditor('descripcion_completa').saveContent(); <? endif;?>">Actualizar Datos</button>
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
                          <div class="tab-pane fade" id="tab3">
                              <style>
                              #div_recompensas{display: block; margin:10px auto; /*background:rgba(0, 0, 0, 0.1); */border-radius: 10px; padding: 15px }
                              </style>   
										<div class="row">
                              	<h3>Recompensas:</h3>
										<div class="col-sm-12 col-md-12 col-lg-12">
											<button id="nuevo_recompensa" name="nuevo_recompensa" class="theme_button">Nueva recompensa</button>
										</div>
                              </div>
                              <!--div_recompensa-->
                              <div id="div_recompensa"></div>
                              <!--div_recompensa-->                            
                               <!--div_recompensas-->
                              <div id="div_recompensas"></div>
                              <!--div_recompensas-->                           
                          </div>
                          <?
								  if($perfil=="Perfil 2" or $perfil=="Perfil 3"):
								  	?>
                             <div class="tab-pane fade" id="tab4">
                                 <style>
                                 #div_fotos{display: block; margin:10px auto; /*background:rgba(0, 0, 0, 0.1); */border-radius: 10px; padding: 15px }
                                 </style>   
                                 <div class="row">
                              	<h3>Galería de fotos:</h3>
                                 <div class="col-sm-12 col-md-12 col-lg-12">
                                    <button id="nuevo_foto" name="nuevo_foto" class="theme_button">Nueva foto</button>
                                 </div>
                                 </div>
                                 <!--div_foto-->
                                 <div id="div_foto"></div>
                                 <!--div_foto-->                            
                                  <!--div_fotos-->
                                 <div id="div_fotos"></div>
                                 <!--div_fotos-->
                             </div>
                             <?
								  endif;
								  ?>
                             <div class="tab-pane fade" id="tab5">
                                 <style>
                                 #div_productos{display: block; margin:10px auto; /*background:rgba(0, 0, 0, 0.1); */border-radius: 10px; padding: 15px }
                                 </style>   
                                 <div class="row">
                                 <h3>Productos / Servicios:</h3>
                                 <div class="col-sm-12 col-md-12 col-lg-12">
                                    <button id="nuevo_producto" name="nuevo_producto" class="theme_button">Nuevo producto</button>
                                 </div>
                                 </div>
                                 <!--div_producto-->
                                 <div id="div_producto"></div>
                                 <!--div_producto-->                            
                                  <!--div_div_productos-->
                                 <div id="div_productos"></div>
                                 <!--div_div_productos-->
                             </div>                           
                           <?
								  if($perfil=="Perfil 3"):
								  	?>
                             <div class="tab-pane fade" id="tab6">
                                 <style>
                                 #div_videos{display: block; margin:10px auto; /*background:rgba(0, 0, 0, 0.1); */border-radius: 10px; padding: 15px }
                                 </style>   
                                 <div class="row">
                              	<h3>Videos:</h3>
                                 <div class="col-sm-12 col-md-12 col-lg-12">
                                    <button id="nuevo_video" name="nuevo_video" class="theme_button">Nuevo video</button>
                                 </div>
                                 </div>
                                 <!--div_video-->
                                 <div id="div_video"></div>
                                 <!--div_video-->                            
                                  <!--div_videos-->
                                 <div id="div_videos"></div>
                                 <!--div_videos-->
                             </div>
                           <?
								  endif;
								  if($perfil=="Perfil 2" or $perfil=="Perfil 3"):
									  ?>
                             <div class="tab-pane fade" id="tab7">
                                 <style>
                                 #div_articulos{display: block; margin:10px auto; /*background:rgba(0, 0, 0, 0.1); */border-radius: 10px; padding: 15px }
                                 </style>   
                                 <div class="row">
                              	<h3>Artículos:</h3>
                                 <div class="col-sm-12 col-md-12 col-lg-12">
                                    <button id="nuevo_articulo" name="nuevo_articulo" class="theme_button">Nuevo artículo</button>
                                 </div>
                                 </div>
                                 <!--div_articulo-->
                                 <div id="div_articulo"></div>
                                 <!--div_articulo-->                            
                                  <!--div_articulos-->
                                 <div id="div_articulos"></div>
                                 <!--div_articulos-->
                             </div>  
                           	<?
									endif;                         
									?>
                           <div class="tab-pane fade" id="tab_cupones_perfil">
										<style>
	                              #div_cupones{display: block; margin:10px auto; /*background:rgba(0, 0, 0, 0.1); */border-radius: 10px; padding: 15px }
                              </style>   
                              <div class="row">
	                              <h3>Cupones:</h3>
                              </div>
                              <!--div_cupon-->
                              <div id="div_cupon"></div>
                              <!--div_cupon-->                      
                               <!--div_cupones-->
                              <div id="div_cupones"></div>
                              <!--div_cupones-->
                          	</div>
                           <div class="tab-pane fade" id="tab8">
										<style>
	                              #div_evaluaciones{display: block; margin:10px auto; /*background:rgba(0, 0, 0, 0.1); */border-radius: 10px; padding: 15px }
                              </style>   
                              <div class="row">
	                              <h3>Evaluaciones:</h3>
                              </div>
                              <!--div_evaluacion-->
                              <div id="div_evaluacion"></div>
                              <!--div_evaluacion-->                            
                               <!--div_evaluaciones-->
                              <div id="div_evaluaciones"></div>
                              <!--div_evaluaciones-->
                          </div> 
                           <div class="tab-pane fade" id="tab_promociones_perfil">
										<style>
	                              #div_promociones{display: block; margin:10px auto; /*background:rgba(0, 0, 0, 0.1); */border-radius: 10px; padding: 15px }
                              </style>   
                              <div class="row">
	                              <h3>Promociones:</h3>
                                 <div class="col-sm-12 col-md-12 col-lg-12">
                                    <button id="nuevo_promocion" name="nuevo_promocion" class="theme_button">Nueva promoción</button>
                                 </div>
                              </div>
                              <!--div_promocion-->
                              <div id="div_promocion"></div>
                              <!--div_promocion-->                            
                               <!--div_promociones-->
                              <div id="div_promociones"></div>
                              <!--div_promociones-->
                          </div> 
                           <div class="tab-pane fade" id="tab_promociones_asignadas_perfil">
										<style>
	                              #div_promociones_asignadas{display: block; margin:10px auto; /*background:rgba(0, 0, 0, 0.1); */border-radius: 10px; padding: 15px }
                              </style>   
                              <div class="row">
	                              <h3>Promociones asignadas:</h3>
                              </div>
                              <!--div_promocion_asignada-->
                              <div id="div_promocion_asignada"></div>
                              <!--div_promocion_asignada-->                            
                               <!--div_promociones_asignadas-->
                              <div id="div_promociones_asignadas"></div>
                              <!--div_promociones_asignadas-->
                          </div> 
                       </div>
                  </div>
                  <?
               endif;
               ?>
            </div>
          </div>
      </section>      
   <?
	include_once("../inc/publicidad.php");
	include_once("../inc/copyright.php");
	?>
	</div><!-- eof #box_wrapper -->
</div>
<script src="../js/compressed.js"></script><script src="../js/main.js"></script>
<script src="../js/jquery.form.js"></script>
<script>
"use strict";
jQuery(document).ready(function(){
	configuracion_textareas();
	
	var bar = jQuery('.bar_datos');
	var percent = jQuery('.percent_datos');
	var status = jQuery('#status_datos');
	jQuery('#form_datos').ajaxForm(
		{
		 beforeSend: function(){
			  status.empty();
			  var percentVal='0%';
			  bar.width(percentVal)
			  percent.html(percentVal);
		 },
		 uploadProgress: function(event, position, total, percentComplete) {
			  var percentVal = percentComplete + '%';
			  bar.width(percentVal)
			  percent.html(percentVal);
		 },
		 success: function() {
			  var percentVal = '100%';
			  bar.width(percentVal)
			  percent.html(percentVal);
		 },
		complete: function(xhr) {
			var respuesta=xhr.responseText;
			status.html(respuesta);
			if(jQuery('#status_datos div.exito').length){
				setTimeout(function(){
					status.empty();
					var percentVal = '0%';
					bar.width(percentVal)
					percent.html(percentVal);
					consultar_datos();
				}, 4000);
			}
			else if(jQuery('#status div.error').length){
				setTimeout(function(){ 
					status.empty();
					var percentVal = '0%';
					bar.width(percentVal)
					percent.html(percentVal);
				}, 4000);
			}
		}
	});
	function consultar_datos(){
		//alert("desde consultar datos");
		jQuery("#div_datos").empty().append("<img src='http://www.ziikfor.com/administrador/images/gifs/loading.gif' width='30' style='border:none;'>");			
		var url="../inc/ajax_consulta_datos_perfil.php";
		var posting=jQuery.post(url);
		posting.done(function(data){
			jQuery("#div_datos").empty().append(data);
			new nicEditor({buttonList:['bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','image','link','unlink']}).panelInstance("sitio_web");
			new nicEditor({buttonList:['bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','image','link','unlink']}).panelInstance("descripcion_corta");
			var perfil=jQuery("#perfil").val();
			if(perfil=="Perfil 2" || perfil=="Perfil 3"){
				new nicEditor({buttonList:['bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','image','link','unlink']}).panelInstance("descripcion_completa");
			}
		});
	}
	function configuracion_textareas(){
		new nicEditor({buttonList:['bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','image','link','unlink']}).panelInstance("sitio_web");
		new nicEditor({buttonList:['bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','image','link','unlink']}).panelInstance("descripcion_corta");
		<?
		if($perfil=="Perfil 2" or $perfil=="Perfil 3"):
			?>
			new nicEditor({buttonList:['bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','image','link','unlink']}).panelInstance("descripcion_completa");
			<?
		endif;
		?>
	}
});
</script>       
</body></html>