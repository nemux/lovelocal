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
$p_id_foto=$_POST["id_foto"]*1;
if(!empty($se_id_perfil) and !empty($p_id_foto) and empty($errors)):
	//Buscar detalle del foto
	$c_art=buscar("titulo,foto","fotos_perfiles","WHERE id_foto='".$p_id_foto."' AND id_perfil='".$se_id_perfil."'");
	while($f_art=$c_art->fetch_assoc()):
		$titulo=cadena($f_art["titulo"]);
		$foto=$f_art["foto"];
	endwhile;
	?>
	<style>
   #form_fotos{display: block; margin:10px auto; background:rgba(0, 0, 0, 0.1); border-radius: 10px; padding: 15px }
   .progress_fotos{position:relative; width:100%; border: 1px solid #ddd; padding: 1px; border-radius: 3px; }
   .bar_fotos{background-color:#0087a4;width:0%; height:33px; border-radius: 3px; margin:0 !important;}
   .percent_fotos{position:absolute;color:#FFFFFF !important;display:inline-block; top:3px; left:48%; }
   </style>   
   <form id="form_fotos" action="../inc/ajax_fotos_actualizar.php" method="post" enctype="multipart/form-data">
	<h3>Actualizar foto</h3>
	<div class="row">
		<div class="col-sm-2 col-md-2 col-lg-2">
			Título:
		</div>
		<div class="col-sm-10 col-md-10 col-lg-10">
			<input type="text" name="titulo" value="<?=$titulo?>" maxlength="255" required="required"> *
		</div>
	</div>
   <?
	if(!empty($foto) and file_exists("../administrador/galeria_fotos/images/".$foto)):
		?>
		<div class="row">
		  <div class="col-sm-2 col-md-2 col-lg-2">Imagen actual</div>
		  <div class="col-sm-10 col-md-10 col-lg-10">
			<img src="../administrador/galeria_fotos/images/<?=$foto?>" style="max-width:100%;">
		  </div>
		</div>
		<div class="row">
		  <div class="col-sm-2 col-md-2 col-lg-2"></div>
		  <div class="col-sm-10 col-md-10 col-lg-10">
				<input type="checkbox" name="eliminar_imagen_foto">Eliminar imagen
		  </div>
		</div>
		<div class="row">
		  <div class="col-sm-2 col-md-2 col-lg-2">Sustituir por:</div>
		  <div class="col-sm-10 col-md-10 col-lg-10">
				<input type="file" name="imagen_foto"/>
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
				<input type="file" name="imagen_foto"/>
				<br />
				<span>Le sugerimos una imagen de  600 x 400 pixeles y formato JPG</span>                                      
			</div>
		</div>
		<?
	endif;	
	?>
	<div class="row">
		<div class="col-sm-2 col-md-2 col-lg-2">
      	<input type="hidden" name="id_foto" value="<?=$p_id_foto?>">
			<input type="hidden" name="action_fotos" value="send">
		</div>
		<div class="col-sm-10 col-md-10 col-lg-10">
			<button type="submit" id="form_fotos_submit" name="form_fotos_submit" class="theme_button">Actualizar foto</button>
		</div>
	</div>
	<div class="row">
      <div class="col-sm-2 col-md-2 col-lg-2">
      </div>
      <div class="col-sm-10 col-md-10 col-lg-10">
         <div class="progress_fotos">
            <div class="bar_fotos"></div>
            <div class="percent_fotos">0%</div>
         </div>
         <div id="status_fotos"></div>
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