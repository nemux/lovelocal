<?php
session_start();
$se_id_perfil=$_SESSION["s_id_perfil"];
$se_usuario_perfil=$_SESSION["s_usuario_perfil"];
$se_password_perfil=$_SESSION["s_password_perfil"];
ini_set("display_errors","On");
include("../administrador/php/config.php");
include("../administrador/php/func.php");
include("../administrador/php/func_bd.php");
$errors=array();
if(empty($se_id_perfil) and empty($se_usuario_perfil) and empty($se_password_perfil)):
	$errors[]='<div class="error">Tu sesión ha finalizado. Es necesario que vuelvas a acceder</div>';
endif;
$p_id_articulo=$_POST["id_articulo"]*1;
if(!empty($se_id_perfil) and !empty($p_id_articulo) and empty($errors)):
	//Buscar detalle del articulo
	$c_art=buscar("articulo,imagen,descripcion_corta,descripcion_completa","articulos_perfiles","WHERE id_articulo='".$p_id_articulo."' AND id_perfil='".$se_id_perfil."'");
	while($f_art=$c_art->fetch_assoc()):
		$articulo=cadena($f_art["articulo"]);
		$imagen=$f_art["imagen"];
		$descripcion_corta=cadena($f_art["descripcion_corta"]);
		$descripcion_completa=cadena($f_art["descripcion_completa"]);
	endwhile;
	?>
	<style>
   #form_articulos{display: block; margin:10px auto; /*background:rgba(0, 0, 0, 0.1);*/ border-radius: 10px; padding: 15px }
	#form_articulos .nicEdit-main{
		background-color:#FFFFFF;
	}	
   .progress_articulos{position:relative; width:100%; border: 1px solid #ddd; padding: 1px; border-radius: 3px; }
   .bar_articulos{background-color:#03538E;width:0%; height:33px; border-radius: 3px; margin:0 !important;}
   .percent_articulos{position:absolute;color:#FFFFFF !important;display:inline-block; top:3px; left:48%; }
   </style>   
   <form id="form_articulos" action="../inc/ajax_articulos_actualizar.php" method="post" enctype="multipart/form-data">
	<h3>Actualizar artículo</h3>
	<div class="row">
		<div class="col-sm-2 col-md-2 col-lg-2">
			Artículo:
		</div>
		<div class="col-sm-10 col-md-10 col-lg-10">
			<input type="text" name="articulo" value="<?=$articulo?>" maxlength="255" required="required"> *
		</div>
	</div>
   <?
	if(!empty($imagen) and file_exists("../administrador/articulos/images/".$imagen)):
		?>
		<div class="row">
		  <div class="col-sm-2 col-md-2 col-lg-2">Imagen actual</div>
		  <div class="col-sm-10 col-md-10 col-lg-10">
			<img src="../administrador/articulos/images/<?=$imagen?>" style="max-width:100%;">
		  </div>
		</div>
		<div class="row">
		  <div class="col-sm-2 col-md-2 col-lg-2"></div>
		  <div class="col-sm-10 col-md-10 col-lg-10">
				<input type="checkbox" name="eliminar_imagen_articulo">Eliminar imagen
		  </div>
		</div>
		<div class="row">
		  <div class="col-sm-2 col-md-2 col-lg-2">Sustituir por:</div>
		  <div class="col-sm-10 col-md-10 col-lg-10">
				<input type="file" name="imagen_articulo"/>
				<br />
				<span>Le sugerimos una imagen de 600 x 400 pixeles y formato JPG</span>                                      
		  </div>
		</div>
		<?
	else:
		?>
		<div class="row">
		  <div class="col-sm-2 col-md-2 col-lg-2">Imagen</div>
		  <div class="col-sm-10 col-md-10 col-lg-10">
				<input type="file" name="imagen_articulo"/>
				<br />
				<span>Le sugerimos una imagen de  600 x 400 pixeles y formato JPG</span>                                      
			</div>
		</div>
		<?
	endif;	
	?>
	<div class="row">
		<div class="col-sm-2 col-md-2 col-lg-2">
			Descripción corta
		</div>
		<div class="col-sm-10 col-md-10 col-lg-10">
			<textarea name="descripcion_corta_articulo" id="descripcion_corta_articulo" style="width:100%; height:100px;" required><?=$descripcion_corta?></textarea> *
		</div>
	</div>                           
	<div class="row">
		<div class="col-sm-2 col-md-2 col-lg-2">
			Descripción completa
		</div>
		<div class="col-sm-10 col-md-10 col-lg-10">
			<textarea name="descripcion_completa_articulo" id="descripcion_completa_articulo" style="width:100%; height:200px;" required><?=$descripcion_completa?></textarea> *
		</div>
	</div>
	<div class="row">
		<div class="col-sm-2 col-md-2 col-lg-2">
      	<input type="hidden" name="id_articulo" value="<?=$p_id_articulo?>">
			<input type="hidden" name="action_articulos" value="send">
		</div>
		<div class="col-sm-10 col-md-10 col-lg-10">
			<button type="submit" id="form_articulos_submit" name="form_articulos_submit" class="theme_button" onclick="nicEditors.findEditor('descripcion_corta_articulo').saveContent();nicEditors.findEditor('descripcion_completa_articulo').saveContent();">Actualizar artículo</button>
		</div>
	</div>
	<div class="row">
      <div class="col-sm-2 col-md-2 col-lg-2">
      </div>
      <div class="col-sm-10 col-md-10 col-lg-10">
         <div class="progress_articulos">
            <div class="bar_articulos"></div>
            <div class="percent_articulos">0%</div>
         </div>
         <div id="status_articulos"></div>
      </div>
   </div>   
   </form>
	<?
endif;
if(!empty($errors)):
	foreach($errors as $error):
		echo $error."<br>";
	endforeach;
endif;
