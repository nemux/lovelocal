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
			Tipo
		</div>
		<div class="col-sm-10 col-md-10 col-lg-10">
         <select name="tipo" id="tipoprod" onchange="selectOption()">
         	<option value="Producto">Producto</option>
         	<option value="Servicio">Servicio</option>            
         </select>
		</div>
	</div>
	<div class="row prod" id="Servicio" style="display:none">
		<div class="col-sm-2 col-md-2 col-lg-2">
			Servicios
		</div>
		<div class="col-sm-10 col-md-10 col-lg-10">
         <select name="servicio">
         	<option value="Accesible para personas con discapacidad">Accesible para personas con discapacidad</option>
         	<option value="Wifi">Wifi</option>    
         	<option value="Enchufes">Enchufes</option> 
         	<option value="Estacionamiento">Estacionamiento</option>
         	<option value="Valet Parking">Valet Parking</option>
         	<option value="Servicio a Domicilio">Servicio a Domicilio</option>
         	<option value="Pet Friendly">Pet Friendly</option>
         	<option value="Sección de Fumar">Sección de Fumar</option>
         	<option value="Vinos y Cervezas">Vinos y Cervezas</option>
         	<option value="Bar">Bar</option>
         	<option value="Sommelier">Sommelier</option>
         	<option value="Tarjeta de Débito y Crédito">Tarjeta de Débito y Crédito</option>
         	<option value="Música">Música</option>
         	<option value="Televisión">Televisión</option>
         	<option value="Entretenimiento en vivo">Entretenimiento en vivo</option>
         	<option value="Terraza o jardín">Terraza o jardín</option>
         	<option value="Banquete">Banquete</option>
         	<option value="Bebidas y café">Bebidas y café</option>
         	


       
         </select>
		</div>
	</div>
	<div class="row prod" id="Producto">
		<div class="row">
		<div class="col-sm-2 col-md-2 col-lg-2">
			Producto:
		</div>
		<div class="col-sm-10 col-md-10 col-lg-10">
			<input type="text" name="producto" maxlength="255"> *
		</div>
		</div>
		<div class="row">
		  <div class="col-sm-2 col-md-2 col-lg-2">Imagen</div>
		  <div class="col-sm-10 col-md-10 col-lg-10">
				<input type="file" name="imagen"/>
				<br />
				<span>Le sugerimos una imagen de  240 x 165 pixeles y formato JPG</span>                                      
			</div>
		</div>
		<div class="row">
			<div class="col-sm-2 col-md-2 col-lg-2">
				Descripción corta
			</div>
			<div class="col-sm-10 col-md-10 col-lg-10">
				<textarea name="descripcion_corta_producto" id="descripcion_corta_articulo" style="width:100%; height:100px;"></textarea>
			</div>
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
