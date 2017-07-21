<?
session_start();
ini_set("display_errors","Off");
$se_id_cliente=$_SESSION["s_id_cliente"];
$se_usuario_cliente=$_SESSION["s_usuario_cliente"];
$se_password_cliente=$_SESSION["s_password_cliente"];
include("../administrador/php/config.php");
include("../administrador/php/func.php");
include("../administrador/php/func_bd.php");
include("../administrador/includes/phpmailer/class.phpmailer.php");
$p_id_perfil=$_POST["id_perfil"]*1;
$p_id_promocion=$_POST["id_promocion"]*1;
$arreglo_respuestas=array();
if(empty($se_id_cliente) and empty($se_usuario_cliente) and empty($se_password_cliente)):
	$arreglo_respuestas[]='<div class="alert alert-warning">Es necesario estar logueado como Cliente para poder generar tu cupón de promoción.</div>';
elseif(!empty($p_id_perfil) and
	!empty($p_id_promocion)
	):
	date_default_timezone_set('Mexico/General');
	$fecha_hora_registro=date("Y-m-d H:i:s");
	
	/*
	//Buscar si ya tiene registrado esta promoción
	$c_reg_cli=buscar("COUNT(id_registro) AS total_promociones","promociones_clientes","WHERE id_promocion='".$p_id_promocion."' AND id_cliente='".$se_id_cliente."'");
	while($f_reg_cli=$c_reg_cli->fetch_assoc()):
		$total_promociones=$f_reg_cli["total_promociones"];
	endwhile;
	if($total_promociones>0):
		$arreglo_respuestas[]='<div class="alert alert-warning">Ya existe un cupón generado de esta promoción con tu usuario.</div>';
	else:
		*/
		$c_rec2=buscar("promocion,imagen,descripcion_corta","promociones_perfiles","WHERE id_promocion='".$p_id_promocion."' AND id_perfil='".$p_id_perfil."'");
		while($f_rec2=$c_rec2->fetch_assoc()):
			$promocion=$f_rec2["promocion"];
			$imagen_promocion=$f_rec2["imagen"];
			$descripcion_corta_promocion=cadena($f_rec2["descripcion_corta"]);
		endwhile;
		$cupon=generar_cupon(15);
		//Registrar promocion al cliente
		$c_eva_per2=insertar("id_perfil,id_promocion,id_cliente,cupon,promocion,fecha_hora_registro","promociones_clientes","'".$p_id_perfil."','".$p_id_promocion."','".$se_id_cliente."','".$cupon."','".$promocion."','".$fecha_hora_registro."'");
		if($c_eva_per2==true):
			//Buscar datos del perfil y de cliente
			$c_per=buscar("local,email","perfiles","WHERE id_perfil='".$p_id_perfil."'");
			while($f_per=$c_per->fetch_assoc()):
				$perfil=cadena($f_per["local"]);
				$email_perfil=$f_per["email"];
			endwhile;
			
			$c_cli=buscar("nombres,apellidos,email","clientes","WHERE id_cliente='".$se_id_cliente."'");
			while($f_cli=$c_cli->fetch_assoc()):
				$cliente=cadena($f_cli["nombres"])." ".cadena($f_cli["apellidos"]);
				$email_cliente=$f_cli["email"];
			endwhile;
			
			//Enviar correo...
			$mensaje1='';
			$from="LOVELOCAL";
			$subject="Registro de Cupón Promoción LoveLocal";
			$mensaje1= '
			<table width="600px" border="0" align="left" cellspacing="1" cellpadding="3" style="color:#03538E;font:13px/20px Arial,sans-serif; font-weight:bold;text-align: left;line-height:17px;">';
				if(!empty($perfil)):
					$mensaje1.='
					<tr>
						<td width="150px" align="left" valign="top" style="color:#060606;">Perfil:</td>
						<td width="450px" align="left" valign="top">'.$perfil.'</td>
					</tr>';
				endif;
				if(!empty($se_usuario_cliente)):
					$mensaje1.='
					<tr>
						<td width="150px" align="left" valign="top" style="color:#060606;">Usuario:</td>
						<td width="450px" align="left" valign="top">'.$se_usuario_cliente.'</td>
					</tr>';
				endif;
				if(!empty($cliente) and $cliente<>" "):
					$mensaje1.='
					<tr>
						<td width="150px" align="left" valign="top" style="color:#060606;">Cliente:</td>
						<td width="450px" align="left" valign="top">'.$cliente.'</td>
					</tr>';
				endif;
				if(!empty($email_cliente)):
					$mensaje1.='
					<tr>
						<td width="150px" align="left" valign="top" style="color:#060606;">Email:</td>
						<td width="450px" align="left" valign="top">'.$email_cliente.'</td>
					</tr>';
				endif;
				if(!empty($cupon)):
					$mensaje1.='
					<tr>
						<td width="150px" align="left" valign="top" style="color:#060606;">Cupón:</td>
						<td width="450px" align="left" valign="top">'.$cupon.'</td>
					</tr>';
				endif;
				if(!empty($promocion)):
					$mensaje1.='
					<tr>
						<td width="150px" align="left" valign="top" style="color:#060606;">Promoción:</td>
						<td width="450px" align="left" valign="top">'.cadena($promocion);
							if(!empty($imagen_promocion) and file_exists("../administrador/promociones/images/".$imagen_promocion)):
								$mensaje1.='
								<br>
								<img src="http://www.lovelocal.mx/administrador/promociones/images/'.$imagen_promocion.'" style="max-width:300px;">
								';
							endif;				
							if(!empty($descripcion_corta_promocion)):
								$mensaje1.='
								<br>
								'.$descripcion_corta_promocion;
							endif;
						$mensaje1.='
						</td>
					</tr>';
				endif;
				$mensaje1.='
			</table>';
			
			//echo $mensaje1."<br>";
			
			if(!empty($mensaje1) and !empty($email_cliente)):
				//Enviamos correo
				$host="p3plcpnl1030.prod.phx3.secureserver.net";
				$email_remitente="sitioweb@lovelocal.mx";
				$password_remitente="Chanona1981";
				$destinatario=$email_cliente;
				$mail = new PHPMailer(true);
				try{
					$mail->IsSMTP();
					$mail->Host=$host;
					$mail->SMTPDebug=1;
					$mail->SMTPAuth=true;
					$mail->SMTPSecure="ssl";
					$mail->Port=465;
					$mail->Username=$email_remitente;
					$mail->Password=$password_remitente;
					$mail->CharSet='UTF-8';
					$mail->AddReplyTo($email_cliente);
					$mail->AddAddress($destinatario);
					if(!empty($email_perfil)):
						$mail->AddBCC($email_perfil);
					endif;
					$mail->SetFrom($email_remitente);
					$mail->IsHTML(true);
					$mail->Subject=$subject;
					$mail->From=$email_remitente;
					$mail->FromName=$from;
					$mail->Timeout=40;
					$mail->MsgHTML($mensaje1);
					if($mail->Send()):
						$arreglo_respuestas[]='<div class="alert alert-success">Tu cupón de promoción ha sido generado y enviado exitosamente a tu correo.</div>';
					else:
						$arreglo_respuestas[]='<div class="alert alert-success">Tu cupón de promoción ha sido generado exitosamente. Sin embargo hubo un problema al enviarlo a tu correo. Puedes consultar tus cupones desde tu Intranet.</div>';
					endif;
				}catch (phpmailerException $e){
					$arreglo_respuestas[]='Error: '.$e->errorMessage();
				}catch (Exception $e) {
				  $arreglo_respuestas[]='Error: '.$e->getMessage();
				}						
			endif;
		else:
			$arreglo_respuestas[]='<div class="alert alert-warning">No fue posible generar tu Cupón de promoción. Intenta de nuevo.</div>';
		endif;
		/*
	endif;	
	*/
else:
	$arreglo_respuestas[]='<div class="alert alert-warning">No se recibieron los parámetros completos.</div>';
endif;
if(count($arreglo_respuestas)):
	foreach($arreglo_respuestas as $respuesta):
		echo $respuesta;
	endforeach;
endif;