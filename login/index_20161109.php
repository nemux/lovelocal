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
<title>Login - Panel de Administración - ZiiKFOR</title>
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
	                  <h3>Login - Panel de Administración</h3>
                  </div>
                 <div class="col-sm-6 ls_fondo4">
                  <div id="message_login" style="padding-bottom:7px;color:#34B4E4;font-weight:bolder;"></div>
                  <form  class="shop-register" role="form" method="post" action="">
                      <div class="col-sm-12 col-md-12 col-lg-12">
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
                          <div class="form-group validate-required" id="billing_first_name_field">
                              <label for="usuario" class="control-label">
                                  <strong class="grey">Usuario</strong>
                                  <span class="required">*</span>
                              </label>
                              <input type="text" class="form-control " name="usuario" id="usuario" placeholder="" value="">
                          </div>
                          <div class="form-group" id="billing_password_field">
                              <label for="password" class="control-label">
                                  <strong class="grey">Password</strong>
                                  <span class="required">*</span>
                              </label>
                              <input type="password" class="form-control " name="password" id="password" placeholder="" value="">
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
                          <button type="submit" id="submit_login" class="theme_button color1">Login</button>
                          <button type="reset" class="theme_button color2">Borrar</button>
                      </div>
                  </form>
                  </div>
                 <div class="col-sm-6 ls_fondo4 text-center">
                 		<?
							require_once __DIR__ . '/src/Facebook/autoload.php';
							$fb = new Facebook\Facebook([
							  'app_id' => '263928443976890',
							  'app_secret' => '3777bee4cf4d43264b5441b83c88db24',
							  'default_graph_version' => 'v2.6',
							  ]);
							$helper = $fb->getRedirectLoginHelper();
							$permissions = ['email']; // optional
							try {
								if (isset($_SESSION['facebook_access_token'])) {
									$accessToken = $_SESSION['facebook_access_token'];
								} else {
									$accessToken = $helper->getAccessToken();
								}
							} catch(Facebook\Exceptions\FacebookResponseException $e) {
								// When Graph returns an error
								echo 'Graph returned an error: ' . $e->getMessage();
							
								exit;
							} catch(Facebook\Exceptions\FacebookSDKException $e) {
								// When validation fails or other local issues
								echo 'Facebook SDK returned an error: ' . $e->getMessage();
								exit;
							}
							if(isset($accessToken)) {
								date_default_timezone_set('Mexico/General');
								$fecha_hora_actual=date("Y-m-d H:i:s");
								if (isset($_SESSION['facebook_access_token'])) {
									$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
								} else {
									// getting short-lived access token
									$_SESSION['facebook_access_token'] = (string) $accessToken;
							
									// OAuth 2.0 client handler
									$oAuth2Client = $fb->getOAuth2Client();
							
									// Exchanges a short-lived access token for a long-lived one
									$longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
							
									$_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;
							
									// setting default access token to be used in script
									$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
								}
							
								// redirect the user back to the same page if it has "code" GET variable
								if (isset($_GET['code'])){
									?>
                           <script>
                          		location.href="./";
                          	</script>
                           <?
									//header('Location: ./');
								}
								// getting basic info about user
								try {
									$profile_request = $fb->get('/me?fields=name,first_name,last_name,email,id');
									$profile = $profile_request->getGraphNode()->asArray();
								} catch(Facebook\Exceptions\FacebookResponseException $e) {
									// When Graph returns an error
									echo 'Graph returned an error: ' . $e->getMessage();
									session_destroy();
									// redirecting user back to app login page
									?>
                           <script>
                           location.href="./";
                          	</script>
                           <?
									//header("Location: ./");
									exit;
								} catch(Facebook\Exceptions\FacebookSDKException $e) {
									// When validation fails or other local issues
									echo 'Facebook SDK returned an error: ' . $e->getMessage();
									exit;
								}
								/*
								// printing $profile array on the screen which holds the basic info about user
								echo "<pre>";
								print_r($profile);
								echo "</pre>";	
								echo "<br>";
								echo 'Logged in as:' .$profile["name"].'<br>';
								echo "accessToken: ".$accessToken."<br>";
								*/
								$name=cadenabd($profile["name"]);
								$first_name=cadenabd($profile["first_name"]);
								$last_name=cadenabd($profile["last_name"]);
								$email=cadenabd($profile["email"]);
								$id=$profile["id"];
								//Buscar con email e ID Facebook
								$c_cli=buscar("id_cliente","clientes","WHERE email='".$email."' AND id_facebook='".$id."'");
								while($f_cli=$c_cli->fetch_assoc()):
									$id_cliente=$f_cli["id_cliente"];
								endwhile;
								if(!empty($id_cliente))://Ya existe con ID Facebook y email
									//Crear las sesiones
									$_SESSION["s_id_cliente"]=$id_cliente;
									$_SESSION["s_id_facebook"]=$id;
									$_SESSION["s_email_cliente"]=$email;
									?>
                           <script>
                              location.href="../cliente_datos/";
                           </script>
                           <?
									//header('Location: ../cliente_datos/');
								else://No existe 
									//Buscar con email
									$c_cli2=buscar("id_cliente","clientes","WHERE email='".$email."'");
									while($f_cli2=$c_cli2->fetch_assoc()):
										$id_cliente2=$f_cli2["id_cliente"];
									endwhile;
									if(!empty($id_cliente2))://Ya existe con email registrado
										//Actualizar para agregar el ID Facebook
										$c_cli3=actualizar("nombres='".$first_name."',apellidos='".$last_name."',id_facebook='".$id."'","clientes","WHERE id_cliente='".$id_cliente2."'");
										//Crear las sesiones
										$_SESSION["s_id_cliente"]=$id_cliente2;
										$_SESSION["s_id_facebook"]=$id;
										$_SESSION["s_email_cliente"]=$email;
										?>
										<script>
                              location.href="../cliente_datos/";
                              </script>
										<?
										//header('Location: ../cliente_datos/');
									else:
										//Registrarlo
										$c_cli3=insertar("nombres,apellidos,id_facebook,email,estatus,fecha_hora_registro","clientes","'".$first_name."','".$last_name."','".$id."','".$email."','activo','".$fecha_hora_actual."'",false);
										if($c_cli3==true):
											//Buscar id_cliente
											$c_cli4=buscar("id_cliente","clientes","WHERE email='".$email."' AND id_facebook='".$id."'");
											while($f_cli4=$c_cli4->fetch_assoc()):
												$id_cliente4=$f_cli4["id_cliente"];
											endwhile;
											if(!empty($id_cliente4)):
												//Crear las sesiones
												$_SESSION["s_id_cliente"]=$id_cliente4;
												$_SESSION["s_id_facebook"]=$id;
												$_SESSION["s_email_cliente"]=$email;
												
												//Enviar correo
												include("../administrador/includes/phpmailer/class.phpmailer.php");												
												$mensaje2='';
												$from="ZIIKFOR";
												$subject2='Registro de cliente Ziikfor';
												$mensaje2.='
												<table width="600px" border="0" align="left" cellspacing="1" cellpadding="3" style="color:#03538E;font:13px/20px Arial,sans-serif; font-weight:normal;text-align: left;line-height:23px;">
													<tr>
														<td colspan="2">
															<p>
															Bienvenido(a): '.cadena($first_name).' '.cadena($last_name).'!
															</p>
															<p>
																Estamos emocionados de tenerte en la comunidad Ziikfor. Encuentra productos y servicios que te importan cerca de ti y comienza a disfrutar de todos sus beneficios mientras apoyas los pequeños y medianos comercios de tu ciudad.
															</p>
															<ul>
																<li>Obtén un descuento siempre que visites por primera vez cada negocio afiliado.</li>
																<li>Cada vez que dejes una valoración ganas recompensas (descuentos o promociones)</li>
																<li>Descarga otras promociones de nuestros afiliados y visítalos para hacerlas válidas.</li>																				
															</ul>
															<p>
																Para acceder a tu panel y completar tu perfil o modificar tu contraseña haz clic <a href="http://www.ziikfor.com/login/" style="color:#03538E;font:14px Arial,sans-serif; font-weight:bold;">aquí</a> e ingresa con tu facebook.
															</p>
															<p>
																¡Muchas gracias por registrarte!
															</p>
															<p>
																Saludos,<br>
																Ziikfor
															</p>
														</td>
													</tr>';
												$mensaje2.='
												</table>';
												if((!empty($mensaje2)) and !empty($email)):
													//Enviamos correo
													$host="hv8svg015.neubox.net";
													$email_remitente="sitioweb@ziikfor.com";
													$password_remitente="LBVrskN@oTBK";
													$destinatario=$email;
													if(!empty($mensaje2)):
														$mail2=new PHPMailer(true);
														try{
															$mail2->IsSMTP();
															$mail2->Host=$host;
															$mail2->SMTPDebug=1;
															$mail2->SMTPAuth=true;
															$mail2->SMTPSecure="ssl";										
															$mail2->Port=465;
															$mail2->Username=$email_remitente;
															$mail2->Password=$password_remitente;
															$mail2->CharSet='UTF-8';
															$mail2->AddReplyTo($email);
															$mail2->AddAddress($destinatario);
															$mail2->SetFrom($email_remitente);
															$mail2->IsHTML(true);
															$mail2->Subject=$subject2;
															$mail2->From=$email_remitente;
															$mail2->FromName=$from;
															$mail2->Timeout=40;
															$mail2->MsgHTML($mensaje2);
															if($mail2->Send()):
																echo '<div class="alert alert-success">Tus datos han sido registrados y enviados exitosamente.</div>';
															else:
																echo '<div class="alert alert-success">Tus datos han sido registrados exitosamente. Sin embargo hubo un problema al enviar tus datos.';
															endif;
														}catch (phpmailerException $e){
															echo '<div class="alert alert-warning">Error: '.$e->errorMessage().'</div>';
														}catch (Exception $e) {
														  echo '<div class="alert alert-warning">Error: '.$e->getMessage().'</div>';
														}
													endif;
												endif;													
												?>
												<script>
												location.href="../cliente_datos/";
												</script>
												<?
												//header('Location: ../cliente_datos/');
											endif;
										else:
											echo 'Error: No fue posible registrarte. Intenta de nuevo.';
										endif;
									endif;
								endif;
								// Now you can redirect to another page and use the access token from $_SESSION['facebook_access_token']
							} else {
								// replace your website URL same as added in the developers.facebook.com/apps e.g. if you used http instead of https and you used non-www version or www version of your website then you must add the same here
								$loginUrl = $helper->getLoginUrl('http://ziikfor.com/login/index.php', $permissions);
								echo '<a href="' . $loginUrl . '"><img src="img/btn_facebook.png" style="max-width:300px;"></a><br><br>
                        <a href="../registro-clientes/" style="font-size:16px;">¡Regístrate con tu email!</a>';
							}							
							?>
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
			var usuario=jQuery("#usuario").val();
			var password=jQuery("#password").val();
			var code=jQuery("#code").val();
			var action=jQuery("#action_login").val();
			var parametros = {
					"tipo_usuario":tipo_usuario,
					"usuario":usuario,
					 "password":password,
					 "code":code,
					 "action":action
			};
			jQuery.ajax({
					 data:  parametros,
					 url:   '../inc/ajax_login.php',
					 type:  'post',
					 beforeSend: function () {
					 jQuery("#message_login").html("Validando tus datos, espera por favor...");
					 },
					 success:function(response){
						if(response=="exito"){
							if(tipo_usuario=="perfil"){
								jQuery(location).attr('href','http://www.ziikfor.com/perfil_datos/');
							}
							else if(tipo_usuario=="cliente"){
								jQuery(location).attr('href','http://www.ziikfor.com/cliente_datos/');
							}
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