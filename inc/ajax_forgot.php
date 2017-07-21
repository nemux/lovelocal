<?php
session_start();
ini_set("display_errors","On");
include("../administrador/php/config.php");
include("../administrador/php/func.php");
include("../administrador/php/func_bd.php");
include("../administrador/includes/phpmailer/class.phpmailer.php");
$p_tipo_usuario=$_POST["tipo_usuario"];
$p_email=$_POST['email'];
$p_action=$_POST['action'];
$p_code=$_POST['code'];
$p_id_idioma=1;
//print_r($_POST);
if(!empty($p_tipo_usuario) and
	!empty($p_email) and
	!empty($p_code) and
	$p_action=="send"
	):
	include("../administrador/php/captcha/securimage.php");
	$img=new Securimage();
	$valid=$img->check($p_code);
	if($valid==true): //Captcha valido	
		date_default_timezone_set('Mexico/General');
		$fecha_hora_actual=date("Y-m-d H:i:s");
		if($p_tipo_usuario=="perfil"):
			$c_per=buscar("id_perfil,usuario,password","perfiles","WHERE email='".$p_email."'");
			while($f_per=$c_per->fetch_assoc()):
				$id_perfil=$f_per["id_perfil"];
				$usuario_perfil=$f_per["usuario"];
				$password_perfil=$f_per["password"];
			endwhile;
			if(!empty($id_perfil) and !empty($usuario_perfil) and !empty($password_perfil)):
				/*$_SESSION["s_id_perfil"]=$id_perfil;
				$_SESSION["s_usuario_perfil"]=$usuario_perfil;
				$_SESSION["s_password_perfil"]=$password_perfil;*/

					$mensaje2='';
					$from="LOVELOCAL";
					$subject2='Datos de cuenta en LoveLocal';
					$mensaje2.='
					<table width="600px" border="0" align="left" cellspacing="1" cellpadding="3" style="color:#03538E;font:13px/20px Arial,sans-serif; font-weight:normal;text-align: left;line-height:23px;">
						<tr>
							<td colspan="2">
								<p>
								Hola '.cadena($usuario_perfil).'
								</p>
								<p>
									Solicitaste recuperar tu contraseña, tus datos de acceso son los siguientes.
								</p>								
								
								<p>
									Usuario: '.cadena($usuario_perfil).'<br>
									Password: '.cadena($password_perfil).'
								</p>
								
								<p>
									Saludos,<br>
									LoveLocal
								</p>
							</td>
						</tr>';
					$mensaje2.='
					</table>';
							
					if((!empty($mensaje2)) and !empty($p_email)):
						//Enviamos correo
						$host="p3plcpnl1030.prod.phx3.secureserver.net";
						$email_remitente="sitioweb@lovelocal.mx";
						$password_remitente="Chanona1981";
						$destinatario=$p_email;
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
								$mail2->AddReplyTo($p_email);
								$mail2->AddAddress($destinatario);
								$mail2->SetFrom($email_remitente);
								$mail2->IsHTML(true);
								$mail2->Subject=$subject2;
								$mail2->From=$email_remitente;
								$mail2->FromName=$from;
								$mail2->Timeout=40;
								$mail2->MsgHTML($mensaje2);
								if($mail2->Send()):
									$arreglo_respuestas[]='<div class="alert alert-success">Tus datos han sido enviados exitosamente.</div>';
								else:
									$arreglo_respuestas[]='<div class="alert alert-success">Tus datos han sido obtenidos exitosamente. Sin embargo hubo un problema al enviar tus datos.';
								endif;
							}catch (phpmailerException $e){
								$arreglo_respuestas[]='<div class="alert alert-warning">Error: '.$e->errorMessage().'</div>';
							}catch (Exception $e) {
							  $arreglo_respuestas[]='<div class="alert alert-warning">Error: '.$e->getMessage().'</div>';
							}
						endif;
					endif;


				$respuesta="exito";
			else:
				$respuesta="El usuario con los datos capturados no existe en nuestra Base de datos o no se encuentra activo.";
			endif;
		elseif($p_tipo_usuario=="cliente"):
			$c_cli=buscar("id_cliente,usuario,password","clientes","WHERE email='".$p_email."'");
			while($f_cli=$c_cli->fetch_assoc()):
				$id_cliente=$f_cli["id_cliente"];
				$usuario_cliente=$f_cli["usuario"];
				$password_cliente=$f_cli["password"];
			endwhile;
			if(!empty($id_cliente) and !empty($usuario_cliente) and !empty($password_cliente)):
				/*$_SESSION["s_id_cliente"]=$id_cliente;
				$_SESSION["s_usuario_cliente"]=$usuario_cliente;
				$_SESSION["s_password_cliente"]=$password_cliente;*/

				$mensaje2='';
					$from="LOVELOCAL";
					$subject2='Datos de cuenta en LoveLocal';
					$mensaje2.='
					<table width="600px" border="0" align="left" cellspacing="1" cellpadding="3" style="color:#03538E;font:13px/20px Arial,sans-serif; font-weight:normal;text-align: left;line-height:23px;">
						<tr>
							<td colspan="2">
								<p>
								Hola '.cadena($usuario_cliente).'
								</p>
								<p>
									Solicitaste recuperar tu contraseña, tus datos de acceso son los siguientes.
								</p>								
								
								<p>
									Usuario: '.cadena($usuario_cliente).'<br>
									Password: '.cadena($password_cliente).'
								</p>
								
								<p>
									Saludos,<br>
									LoveLocal
								</p>
							</td>
						</tr>';
					$mensaje2.='
					</table>';
							
					if((!empty($mensaje2)) and !empty($p_email)):
						//Enviamos correo
						$host="p3plcpnl1030.prod.phx3.secureserver.net";
						$email_remitente="sitioweb@lovelocal.mx";
						$password_remitente="Chanona1981";
						$destinatario=$p_email;
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
								$mail2->AddReplyTo($p_email);
								$mail2->AddAddress($destinatario);
								$mail2->SetFrom($email_remitente);
								$mail2->IsHTML(true);
								$mail2->Subject=$subject2;
								$mail2->From=$email_remitente;
								$mail2->FromName=$from;
								$mail2->Timeout=40;
								$mail2->MsgHTML($mensaje2);
								if($mail2->Send()):
									$arreglo_respuestas[]='<div class="alert alert-success">Tus datos han sido enviados exitosamente.</div>';
								else:
									$arreglo_respuestas[]='<div class="alert alert-success">Tus datos han sido obtenidos exitosamente. Sin embargo hubo un problema al enviar tus datos.';
								endif;
							}catch (phpmailerException $e){
								$arreglo_respuestas[]='<div class="alert alert-warning">Error: '.$e->errorMessage().'</div>';
							}catch (Exception $e) {
							  $arreglo_respuestas[]='<div class="alert alert-warning">Error: '.$e->getMessage().'</div>';
							}
						endif;
					endif;


				$respuesta="exito";
			else:
				$respuesta="El usuario con los datos capturados no existe en nuestra Base de datos o no se encuentra activo.";
			endif;
		endif;
	else:
		switch($p_id_idioma):
			case 1:
				$respuesta='El código CAPTCHA capturado no es correcto.';
			break;					
			case 2:
				$respuesta='The answer you entered for the CAPTCHA is not correct.';
			break;					
		endswitch;	
	endif;
else:
	switch($p_id_idioma):
		case 1:
			$respuesta="No se recibieron los parámetros completos...";
		break;					
		case 2:
			$respuesta='No data received...';
		break;					
	endswitch;
endif; // Fin post				
echo $respuesta;
?>