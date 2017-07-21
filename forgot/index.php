<?
session_start();
$se_id_cliente=$_SESSION["s_id_cliente"];
$se_id_facebook=isset($_SESSION["s_id_facebook"]) ? $_SESSION["s_id_facebook"] : "";
$se_email_cliente=isset($_SESSION["s_email_cliente"]) ? $_SESSION["s_email_cliente"] : "";
$se_usuario_cliente=$_SESSION["s_usuario_cliente"];
$se_password_cliente=$_SESSION["s_password_cliente"];
if((!empty($se_id_cliente) and !empty($se_usuario_cliente) and !empty($se_password_cliente)) or
	(!empty($se_id_cliente) and !empty($se_id_facebook) and !empty($se_email_cliente))
	):
	header('Location: ../cliente_datos/');
endif;
include("../administrador/php/config.php");
include("../administrador/php/func_bd.php");
include("../administrador/php/func.php");
?>
<!DOCTYPE html> <html class="no-js">
<head>
<title>Login - Panel de Administración - LoveLocal</title>
<!-- Favicon -->
<link rel="shortcut icon" href="http://www.lovelocal.mx/images/favicon.png">
<meta charset="utf-8"><!--[if IE]> <meta http-equiv="X-UA-Compatible" content="IE=edge"><![endif]--> 
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../css/bootstrap.min.css">
<link rel="stylesheet" href="../css/main.css" id="color-switcher-link">
<link rel="stylesheet" href="../css/animations.css">
<link rel="stylesheet" href="../css/fonts.css">
<script src="../js/vendor/modernizr-2.6.2.min.js"></script>
<!--[if lt IE 9]> <script src="js/vendor/html5shiv.min.js"></script> <script src="js/vendor/respond.min.js"></script><![endif]-->
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
              <div class="row">
						<div class="col-sm-12 col-md-12 col-lg-12">
	                  <h3>Recupera tu cuenta</h3>
                  </div>
                 <div class="col-sm-6 ls_fondo4">
                  <div id="message_login" style="padding-bottom:7px;color:#34B4E4;font-weight:bolder;"></div>
                  <form  class="shop-register" role="form" method="post" action="">
                      <div class="form-group validate-required" id="billing_first_name_field">
                              <label for="tipo_usuario" class="control-label">
                                  <strong class="grey">Tipo de usuario</strong>
                                  <span class="required">*</span>
                              </label>
                              <select name="tipo_usuario" id="tipo_usuario" class="form-control">
                              	<option value="cliente">Cliente</option>
                                 <option value="perfil">Perfil</option>
                              </select>
                       </div>
                      <div class="col-sm-12 col-md-12 col-lg-12">
                          
                          <div class="form-group validate-required" id="billing_first_name_field">
                              <label for="usuario" class="control-label">
                                  <strong class="grey">Correo Electronico</strong>
                                  <span class="required">*</span>
                              </label>
                              <input type="text" class="form-control " name="email" id="email" placeholder="" value="">
                          </div>
                         
                      </div>
                       <div class="col-sm-12">
                            <div class="form-group validate-required" id="code_campo">
                              <label for="code" class="control-label">
                                  <strong class="grey">Capture los caracteres que aparecen en la imagen</strong>
                                  <span class="required">*</span>
                              </label>
                              <br />
                              <img src="../administrador/php/captcha/securimage_show.php?sid=<?php echo md5(uniqid(time())); ?>" id="image" style="display:inline-block;padding:7px 0;"/> 
                              <a href="#" onClick="document.getElementById('image').src = '../administrador/php/captcha/securimage_show.php?sid='+Math.random(); return false" style="display:inline-block;padding:7px;">
                              <img src="../administrador/php/captcha/images/refresh.gif" border="0" alt="Actualizar Imagen"/>
                              </a>
                              <input type="text" class="form-control" name="code" id="code" style="width:200px;" value="" required/>
                              <input type="hidden" id="action_login" name="action_login" value="send">
                            </div>
                       </div>
                      <div class="col-sm-12 col-md-12 col-lg-12">
                          <button type="submit" id="submit_login" class="theme_button color1">Enviar</button>
                          <button type="reset" class="theme_button color2">Borrar</button>
                      </div>
                  </form>
                  </div>
                 
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
<script type="text/javascript">
"use strict";
jQuery(document).ready(function() {				 
	jQuery('#submit_login').click(
		function(event){
			event.preventDefault();	
			var tipo_usuario=jQuery("#tipo_usuario").val();		
			var email=jQuery("#email").val();
			var code=jQuery("#code").val();
			var action=jQuery("#action_login").val();
			var parametros = {
				     "tipo_usuario":tipo_usuario,
					 "email":email,
					 "code":code,
					 "action":action
			};
			jQuery.ajax({
					 data:  parametros,
					 url:   '../inc/ajax_forgot.php',
					 type:  'post',
					 beforeSend: function () {
					 jQuery("#message_login").html("Validando tus datos, espera por favor...");
					 },
					 success:function(response){
						if(response=="exito"){
							jQuery("#message_login").html("Le acabamos de enviar un correo por favor reviselo, gracias.");
						}
						else{
							jQuery("#message_login").html(response);
							document.getElementById('image').src='../administrador/php/captcha/securimage_show.php?sid='+Math.random();
							code=jQuery("#code").val("");
						}
					 }
			});
		 }
	);
});	 
</script>          
</body></html>