<?php
session_start();
ini_set("display_errors","On");
include("../administrador/php/config.php");
include("../administrador/php/func.php");
include("../administrador/php/func_bd.php");
include("../administrador/includes/phpmailer/class.phpmailer.php");
$p_usuario=cadenabd($_POST['usuario']);
$p_email=cadenabd($_POST['email']);

$p_password=cadenabd($_POST['password']);
$p_password2=cadenabd($_POST['password2']);

$p_code=$_POST['code'];
$p_id_perfil=$_POST["id_perfil"];
$p_action=$_POST['action'];
$p_id_idioma=1;
$arreglo_respuestas=array();
//print_r($_POST);
if(!empty($p_usuario) and 
	!empty($p_email) and 
	!empty($p_password) and
	!empty($p_password2) and	
	!empty($p_code) and
	$p_action=="send"
	):
	include("../administrador/php/captcha/securimage.php");
	$img=new Securimage();
	$valid=$img->check($p_code);
	if($valid==true): //Captcha valido	
		date_default_timezone_set('Mexico/General');
		$fecha_hora_actual=date("Y-m-d H:i:s");
		
		//Si ya existe cliente registrado con este correo
		$c_cli=buscar("id_cliente","clientes","WHERE email='".$p_email."'");
		$id_cliente=0;
		while($f_cli=$c_cli->fetch_assoc()):
			$id_cliente=$f_cli["id_cliente"];
		endwhile;
		if($id_cliente>0):
			$arreglo_respuestas[]='<div class="alert alert-warning">Ya existe un cliente registrado con este email.</div>';
		else:
			//$p_password=generate_password(10);
			//Registrar
			$c_cli2=insertar("usuario,password,email,fecha_hora_registro","clientes","'".$p_usuario."','".$p_password."','".$p_email."','".$fecha_hora_actual."'",false);
			if($c_cli2==true):
				$c_cli3=buscar("id_cliente,usuario,password,email","clientes","WHERE usuario='".$p_usuario."' AND password='".$p_password."' AND email='".$p_email."'");
				while($f_cli3=$c_cli3->fetch_assoc()):
					$id_cliente=$f_cli3["id_cliente"];
					$usuario_cliente=$f_cli3["usuario"];
					$password_cliente=$f_cli3["password"];
					$email_cliente=$f_cli3["email"];
				endwhile;
				if(!empty($id_cliente) and 
					!empty($usuario_cliente) and
					!empty($password_cliente)
					):
					//Registrar sesiones
					$_SESSION["s_id_cliente"]=$id_cliente;
					$_SESSION["s_usuario_cliente"]=$usuario_cliente;
					$_SESSION["s_password_cliente"]=$password_cliente;

					$mensaje2='';
					$from="LOVELOCAL";
					$subject2='Registro de cliente LoveLocal';
					$mensaje2.='
					<table width="600px" border="0" align="left" cellspacing="1" cellpadding="3" style="color:#03538E;font:13px/20px Arial,sans-serif; font-weight:normal;text-align: left;line-height:23px;">
						<tr>
							<td colspan="2">
								<p>
								Bienvenido(a): '.cadena($usuario_cliente).'!
								</p>
								<p>
									Estamos emocionados de tenerte en la comunidad LoveLocal. Encuentra productos y servicios que te importan cerca de ti y comienza a disfrutar de todos sus beneficios mientras apoyas los pequeños y medianos comercios de tu ciudad.
								</p>
								<ul>
									<li>Obtén un descuento siempre que visites por primera vez cada negocio afiliado.</li>
									<li>Cada vez que dejes una valoración ganas recompensas (descuentos o promociones)</li>
									<li>Descarga otras promociones de nuestros afiliados y visítalos para hacerlas válidas.</li>																				
								</ul>
								<p>
									Para acceder a tu panel y completar tu perfil o modificar tu contraseña haz clic <a href="http://www.lovelocal.mx/login/" style="color:#03538E;font:14px Arial,sans-serif; font-weight:bold;">aquí</a> con los siguientes datos:
								</p>
								<p>
									Usuario: '.cadena($usuario_cliente).'<br>
									Password: '.cadena($password_cliente).'
								</p>
								<p>
									¡Muchas gracias por registrarte!
								</p>
								<p>
									Saludos,<br>
									LoveLocal
								</p>
							</td>
						</tr>';
					$mensaje2.='
					</table>';
							
					if((!empty($mensaje2)) and !empty($email_cliente)):
						//Enviamos correo
						$host="p3plcpnl1030.prod.phx3.secureserver.net";
						$email_remitente="sitioweb@lovelocal.mx";
						$password_remitente="Chanona1981";
						$destinatario=$email_cliente;
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
								$mail2->AddReplyTo($email_cliente);
								$mail2->AddAddress($destinatario);
								$mail2->SetFrom($email_remitente);
								$mail2->IsHTML(true);
								$mail2->Subject=$subject2;
								$mail2->From=$email_remitente;
								$mail2->FromName=$from;
								$mail2->Timeout=40;
								$mail2->MsgHTML($mensaje2);
								if($mail2->Send()):
									$arreglo_respuestas[]='<div class="alert alert-success">Tus datos han sido registrados y enviados exitosamente.</div>';
								else:
									$arreglo_respuestas[]='<div class="alert alert-success">Tus datos han sido registrados exitosamente. Sin embargo hubo un problema al enviar tus datos.';
								endif;
							}catch (phpmailerException $e){
								$arreglo_respuestas[]='<div class="alert alert-warning">Error: '.$e->errorMessage().'</div>';
							}catch (Exception $e) {
							  $arreglo_respuestas[]='<div class="alert alert-warning">Error: '.$e->getMessage().'</div>';
							}
						endif;
					endif;
				endif;
			else:
				$arreglo_respuestas[]='<div class="alert alert-warning">No fue posible registrar al cliente.</div>';
			endif;
		endif;
	else:
		switch($p_id_idioma):
			case 1:
				$arreglo_respuestas[]="<div class=\"alert alert-warning\">El código CAPTCHA capturado no es correcto.</div>";
			break;					
			case 2:
				$arreglo_respuestas[]="<div class=\"alert alert-warning\">The answer you entered for the CAPTCHA is not correct.</div>";
			break;					
		endswitch;	
	endif;
else:
	switch($p_id_idioma):
		case 1:
			$arreglo_respuestas[]="<div class=\"alert alert-warning\">No se recibieron los parámetros completos...</div>";
		break;					
		case 2:
			$arreglo_respuestas[]="<div class=\"alert alert-warning\">No data received...</div>";
		break;					
	endswitch;
endif; // Fin post				
if(count($arreglo_respuestas)):
	foreach($arreglo_respuestas as $respuesta):
		echo $respuesta;
	endforeach;
endif;
?>