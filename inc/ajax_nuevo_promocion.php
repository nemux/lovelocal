<?php
session_start();
$se_id_perfil=$_SESSION["s_id_perfil"];
$se_usuario_perfil=$_SESSION["s_usuario_perfil"];
$se_password_perfil=$_SESSION["s_password_perfil"];
//ini_set("display_errors","On");
include("../administrador/php/config.php");
include("../administrador/php/func.php");
include("../administrador/php/func_bd.php");
$errors=array();
if(empty($se_id_perfil) and empty($se_usuario_perfil) and empty($se_password_perfil)):
	$errors[]='<div class="error">Tu sesión ha finalizado. Es necesario que vuelvas a acceder</div>';
endif;
if(!empty($se_id_perfil) and empty($errors)):
	?>
	<style>
   #form_promociones{display: block; margin:10px auto; /*background:rgba(0, 0, 0, 0.1);*/ border-radius: 10px; padding: 15px }
	#form_promociones .nicEdit-main{
		background-color:#FFFFFF;
	}
   .progress_promociones{position:relative; width:100%; border: 1px solid #ddd; padding: 1px; border-radius: 3px; }
   .bar_promociones{background-color:#03538E;width:0%; height:33px; border-radius: 3px; margin:0 !important;}
   .percent_promociones{position:absolute;color:#FFFFFF !important;display:inline-block; top:3px; left:48%; }
   </style>   
   <form id="form_promociones" action="../inc/ajax_promociones.php" method="post" enctype="multipart/form-data">
	<h3>Nueva promoción</h3>
	<div class="row">
		<div class="col-sm-2 col-md-2 col-lg-2">
			Promoción:
		</div>
		<div class="col-sm-10 col-md-10 col-lg-10">
			<input type="text" name="promocion" maxlength="255" required="required"> *
		</div>
	</div>                       		
	<div class="row">
	  <div class="col-sm-2 col-md-2 col-lg-2">Imagen</div>
	  <div class="col-sm-10 col-md-10 col-lg-10">
			<input type="file" name="imagen_promocion"/>
			<br />
			<span>Le sugerimos una imagen de  360 x 210 pixeles y formato JPG</span>                                      
		</div>
	</div>
	<div class="row">
		<div class="col-sm-2 col-md-2 col-lg-2">
			Descripción corta
		</div>
		<div class="col-sm-10 col-md-10 col-lg-10">
			<textarea name="descripcion_corta_promocion" id="descripcion_corta_promocion" style="width:100%; height:100px;" required></textarea> *
		</div>
	</div>           
   <? /*                
	<div class="row">
		<div class="col-sm-2 col-md-2 col-lg-2">
			Descripción completa
		</div>
		<div class="col-sm-10 col-md-10 col-lg-10">
			<textarea name="descripcion_completa_promocion" id="descripcion_completa_promocion" style="width:100%; height:200px;" required></textarea> *
		</div>
	</div>
	*/
	?>
	<div class="row">
		<div class="col-sm-2 col-md-2 col-lg-2">
			Estatus
		</div>
		<div class="col-sm-10 col-md-10 col-lg-10">
         <select name="estatus_promocion">
         	<option value="Activo">Activo</option>
         	<option value="Inactivo">Inactivo</option>         
         </select>
		</div>
	</div>        
	<div class="row">
		<div class="col-sm-2 col-md-2 col-lg-2">
			<input type="hidden" name="action_promociones" value="send">
		</div>
		<div class="col-sm-10 col-md-10 col-lg-10">
      	<? /*
			<button type="submit" id="form_promociones_submit" name="form_promociones_submit" class="theme_button" onclick="nicEditors.findEditor('descripcion_corta_promocion').saveContent();nicEditors.findEditor('descripcion_completa_promocion').saveContent();">Registrar promoción</button>
         */?>
			<button type="submit" id="form_promociones_submit" name="form_promociones_submit" class="theme_button" onclick="nicEditors.findEditor('descripcion_corta_promocion').saveContent();">Registrar promoción</button>
		</div>
	</div>
	<div class="row">
      <div class="col-sm-2 col-md-2 col-lg-2">
      </div>
      <div class="col-sm-10 col-md-10 col-lg-10">
         <div class="progress_promociones">
            <div class="bar_promociones"></div>
            <div class="percent_promociones">0%</div>
         </div>
         <div id="status_promociones"></div>
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
