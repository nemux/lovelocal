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
if(!empty($se_id_perfil) and empty($errors)):
	?>
	<style>
   #form_productos{display: block; margin:10px auto; /*background:rgba(0, 0, 0, 0.1); */border-radius: 10px; padding: 15px }
	#form_productos .nicEdit-main{
		background-color:#FFFFFF;
	}
   .progress_productos{position:relative; width:100%; border: 1px solid #ddd; padding: 1px; border-radius: 3px; }
   .bar_productos{background-color:#0087a4;width:0%; height:33px; border-radius: 3px; margin:0 !important;}
   .percent_productos{position:absolute;color:#FFFFFF !important;display:inline-block; top:3px; left:48%; }
   </style>   
   <form id="form_productos" action="../inc/ajax_productos.php" method="post" enctype="multipart/form-data">
	<h3>Nuevo producto</h3>
	<div class="row">
		<div class="col-sm-2 col-md-2 col-lg-2">
			Producto:
		</div>
		<div class="col-sm-10 col-md-10 col-lg-10">
			<input type="text" name="producto" maxlength="255" required="required"> *
		</div>
	</div>                       		
	<div class="row">
		<div class="col-sm-2 col-md-2 col-lg-2">
			Tipo
		</div>
		<div class="col-sm-10 col-md-10 col-lg-10">
         <select name="tipo">
         	<option value="Producto">Producto</option>
         	<option value="Servicio">Servicio</option>            
         </select>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-2 col-md-2 col-lg-2">
			<input type="hidden" name="action_productos" value="send">
		</div>
		<div class="col-sm-10 col-md-10 col-lg-10">
			<button type="submit" id="form_productos_submit" name="form_productos_submit" class="theme_button">Registrar producto</button>
		</div>
	</div>
	<div class="row">
      <div class="col-sm-2 col-md-2 col-lg-2">
      </div>
      <div class="col-sm-10 col-md-10 col-lg-10">
         <div class="progress_productos">
            <div class="bar_productos"></div>
            <div class="percent_productos">0%</div>
         </div>
         <div id="status_productos"></div>
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
