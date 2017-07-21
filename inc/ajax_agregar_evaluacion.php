<?
session_start();
$se_id_cliente=$_SESSION["s_id_cliente"];
$se_id_facebook=isset($_SESSION["s_id_facebook"]) ? $_SESSION["s_id_facebook"] : "";
$se_email_cliente=isset($_SESSION["s_email_cliente"]) ? $_SESSION["s_email_cliente"] : "";
$se_usuario_cliente=$_SESSION["s_usuario_cliente"];
$se_password_cliente=$_SESSION["s_password_cliente"];
ini_set("display_errors","On");
include_once("../administrador/php/config.php");
include_once("../administrador/php/func.php");
include_once("../administrador/php/func_bd.php");
include("../administrador/includes/phpmailer/class.phpmailer.php");
$p_id_perfil=$_POST["id_perfil"]*1;
$p_usuario=cadenabd($_POST["usuario"]);
$p_email=cadenabd($_POST["email"]);
$p_calificacion=$_POST["calificacion"];
$p_comentario=cadenabd($_POST["comentario"]);
$arreglo_respuestas=array();
if(!empty($p_id_perfil) and
	!empty($p_calificacion)
	):
	date_default_timezone_set('Mexico/General');
	$fecha_hora_registro=date("Y-m-d H:i:s");
	
	//Si existe sesión del cliente
	if((!empty($se_id_cliente) and !empty($se_usuario_cliente) and !empty($se_password_cliente)) or
		(!empty($se_id_cliente) and !empty($se_id_facebook) and !empty($se_email_cliente))
		):
		//Buscar si ya tiene registrada evaluacion de este perfil
		$c_eva_per=buscar("COUNT(id_evaluacion) AS total_evaluaciones","evaluaciones_perfiles","WHERE id_perfil='".$p_id_perfil."' AND id_cliente='".$se_id_cliente."'");
		while($f_eva_per=$c_eva_per->fetch_assoc()):
			$total_evaluaciones=$f_eva_per["total_evaluaciones"];
		endwhile;
		if($total_evaluaciones>0):
			$arreglo_respuestas[]='<div class="alert alert-warning">Ya existe una evaluación registrada con tu usuario.</div>';
		else:		
			
			//Nuevo-Buscar categoria del perfil
			$c_rec=buscar("id_categoria","categorias_perfiles","WHERE id_perfil='".$p_id_perfil."'");
			while($f_rec=$c_rec->fetch_assoc()):
				$id_categoria=$f_rec["id_categoria"];
				$arr_categorias[]=$id_categoria;
				$sqlcat .= ' AND cp.id_categoria != '.$id_categoria;
			endwhile;
			//Nuevo - Buscar otro perfil
			$c_rec=buscar("p.id_perfil"
				,"recompensas_perfiles rp,
				perfiles p,
				categorias_perfiles cp" 
				,"WHERE rp.id_perfil=p.id_perfil AND p.id_perfil !='".$p_id_perfil."' 
				AND p.id_perfil=cp.id_perfil ".$sqlcat." AND rp.estatus='activo'");
			while($f_rec=$c_rec->fetch_assoc()):
				$id_perfil_otro=$f_rec["id_perfil"];
				$arr_perfil_otro[]=$id_perfil_otro;
			endwhile;
			$id_perfil_aleatoria=array_random($arr_perfil_otro);

			//Buscar recompensas
			$arr_recompensas=array();
			$c_rec=buscar("id_recompensa","recompensas_perfiles","WHERE id_perfil='".$id_perfil_aleatoria."' AND estatus='activo'");
			while($f_rec=$c_rec->fetch_assoc()):
				$id_recompensa=$f_rec["id_recompensa"];
				$arr_recompensas[]=$id_recompensa;
			endwhile;
			//Seleccionar un aleatorio
			$id_recompensa_aleatoria=array_random($arr_recompensas);
			if($id_recompensa_aleatoria>0):
				$c_rec2=buscar("recompensa","recompensas_perfiles","WHERE id_recompensa='".$id_recompensa_aleatoria."'");
				while($f_rec2=$c_rec2->fetch_assoc()):
					$recompensa=$f_rec2["recompensa"];
				endwhile;
				$cupon=generar_cupon(15);
				//Registrar evaluacion
				$c_eva_per2=insertar("id_perfil,id_cliente,id_recompensa,evaluacion,comentario,cupon,recompensa,fecha_hora_registro","evaluaciones_perfiles","'".$p_id_perfil."','".$se_id_cliente."','".$id_recompensa_aleatoria."','".$p_calificacion."','".$p_comentario."','".$cupon."','".$recompensa."','".$fecha_hora_registro."'");
				if($c_eva_per2==true):
					//Buscar datos del perfil y de cliente
					$c_per_aleatorio=buscar("local,email, nombres","perfiles","WHERE id_perfil='".$id_perfil_aleatoria."'");
					while($f_per=$c_per_aleatorio->fetch_assoc()):
						$perfilnamealeatorio=cadena($f_per["nombres"]);
						$perfilaleatorio=cadena($f_per["local"]);
						$email_perfil_aleatorio=$f_per["email"];
					endwhile;

					$c_per=buscar("local,email, nombres","perfiles","WHERE id_perfil='".$p_id_perfil."'");
					while($f_per=$c_per->fetch_assoc()):
						$perfilname=cadena($f_per["nombres"]);
						$perfil=cadena($f_per["local"]);
						$email_perfil=$f_per["email"];
					endwhile;
					
					$c_cli=buscar("nombres,apellidos,email","clientes","WHERE id_cliente='".$se_id_cliente."'");
					while($f_cli=$c_cli->fetch_assoc()):
						$cliente=cadena($f_cli["nombres"])." ".cadena($f_cli["apellidos"]);
						$email_cliente=$f_cli["email"];
					endwhile;
					/*$email_cliente='jennyfervl@hotmail.com';
					$email_perfil='jennyfervl@hotmail.com';
					$email_perfil_aleatorio='jennyfervl@hotmail.com';*/
					//Enviar correo...
					$mensaje1='';
					$from="LOVELOCAL";
					$subject="Registro de evaluacion LoveLocal";
					$mensaje1= '
					<table width="600px" border="0" align="left" cellspacing="1" cellpadding="3" style="color:#03538E;font:13px/20px Arial,sans-serif; font-weight:bold;text-align: left;line-height:17px;">';
						if(!empty($perfil)):
							$mensaje1.='<tr><td colspan="2">
							Hola '.$perfilname.' has recibido una nueva evaluación por parte de '.$se_usuario_cliente.', aquí está tu puntuación y los comentarios del cliente.<br  /><br  /> Tómalos en cuenta para mejorar tus puntos débiles y potenciar tus puntos fuertes.<br  /><br  />

							Con amor, LoveLocal.<br  /><br  />
						    </td></tr>';
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
						if(!empty($p_calificacion)):
							$mensaje1.='
							<tr>
								<td width="150px" align="left" valign="top" style="color:#060606;">Calificación:</td>
								<td width="450px" align="left" valign="top">'.$p_calificacion.' de 5 estrellas.</td>
							</tr>';
						endif;
						if(!empty($p_comentario)):
							$mensaje1.='
							<tr>
								<td width="150px" align="left" valign="top" style="color:#060606;">Comentario:</td>
								<td width="450px" align="left" valign="top">'.cadena($p_comentario).'</td>
							</tr>';
						endif;
						/*if(!empty($cupon)):
							$mensaje1.='
							<tr>
								<td width="150px" align="left" valign="top" style="color:#060606;">Cupón:</td>
								<td width="450px" align="left" valign="top">'.$cupon.'</td>
							</tr>';
						endif;
						if(!empty($recompensa)):
							$mensaje1.='
							<tr>
								<td width="150px" align="left" valign="top" style="color:#060606;">Recompensa:</td>
								<td width="450px" align="left" valign="top">'.cadena($recompensa).'</td>
							</tr>';
						endif;*/
						$mensaje1.='
					</table>';				
					///
					/*if(!empty($mensaje1) and !empty($email_cliente)):
						//Enviamos correo
						$subject="Recompensa por evaluación";
						$host="hv8svg015.neubox.net";
						$email_remitente="sitioweb@lovelocal.mx";
						$password_remitente="LBVrskN@oTBK";
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
							$mail->Timeout=40;*/
							$mensaje2 = '';
							$mensaje2= '
					<table width="600px" border="0" align="left" cellspacing="1" cellpadding="3" style="color:#03538E;font:13px/20px Arial,sans-serif; font-weight:bold;text-align: left;line-height:17px;">';
						if(!empty($perfil)):
							$mensaje2.='<tr><td colspan="2">
							Hola '.$se_usuario_cliente.', 
							gracias por evaluar '.$perfil.'. <br  /><br  />
							Cada comentario es tomado en cuenta para poder ofrecerte sólo lo mejor. 
							¡Te tenemos una sorpresa! Por habernos dado tu opinión, 
							te haces acreedor a un cupón de descuento para conocer un nuevo establecimiento, 
							¡no olvides evaluarlo!<br  /><br  />

							Con amor, LoveLocal.<br  /><br  />
						    </td></tr>';
							$mensaje2.='
							<tr>
								<td width="150px" align="left" valign="top" style="color:#060606;">Perfil:</td>
								<td width="450px" align="left" valign="top">'.$perfilaleatorio.'</td>
							</tr>';
						endif;
						if(!empty($se_usuario_cliente)):
							$mensaje2.='
							<tr>
								<td width="150px" align="left" valign="top" style="color:#060606;">Usuario:</td>
								<td width="450px" align="left" valign="top">'.$se_usuario_cliente.'</td>
							</tr>';
						endif;
						if(!empty($cliente) and $cliente<>" "):
							$mensaje2.='
							<tr>
								<td width="150px" align="left" valign="top" style="color:#060606;">Cliente:</td>
								<td width="450px" align="left" valign="top">'.$cliente.'</td>
							</tr>';
						endif;
						if(!empty($email_cliente)):
							$mensaje2.='
							<tr>
								<td width="150px" align="left" valign="top" style="color:#060606;">Email:</td>
								<td width="450px" align="left" valign="top">'.$email_cliente.'</td>
							</tr>';
						endif;
						/*if(!empty($p_calificacion)):
							$mensaje1.='
							<tr>
								<td width="150px" align="left" valign="top" style="color:#060606;">Calificación:</td>
								<td width="450px" align="left" valign="top">'.$p_calificacion.' de 5 estrellas.</td>
							</tr>';
						endif;
						if(!empty($p_comentario)):
							$mensaje1.='
							<tr>
								<td width="150px" align="left" valign="top" style="color:#060606;">Comentario:</td>
								<td width="450px" align="left" valign="top">'.cadena($p_comentario).'</td>
							</tr>';
						endif;*/
						if(!empty($cupon)):
							$mensaje2.='
							<tr>
								<td width="150px" align="left" valign="top" style="color:#060606;">Cupón:</td>
								<td width="450px" align="left" valign="top">'.$cupon.'</td>
							</tr>';
						endif;
						if(!empty($recompensa)):
							$mensaje2.='
							<tr>
								<td width="150px" align="left" valign="top" style="color:#060606;">Recompensa:</td>
								<td width="450px" align="left" valign="top">'.cadena($recompensa).'</td>
							</tr>';
						endif;
						$mensaje2.='
					</table>';

					$mensaje3 = '';
							$mensaje3= '
					<table width="600px" border="0" align="left" cellspacing="1" cellpadding="3" style="color:#03538E;font:13px/20px Arial,sans-serif; font-weight:bold;text-align: left;line-height:17px;">';
						if(!empty($perfil)):
							$mensaje3.='<tr><td colspan="2">
							
Hola '.$perfilnamealeatorio.', 
¡sorpresa! '.$perfil.' acaba de invitar 
a uno de sus clientes a conocerte a través de un cupón de descuento. 
¡Manténte atento para que tu próxima evaluación sea de cinco estrellas!<br  /><br  />

							Con amor, LoveLocal.<br  /><br  />
						    </td></tr>';
							$mensaje3.='
							<tr>
								<td width="150px" align="left" valign="top" style="color:#060606;">Perfil:</td>
								<td width="450px" align="left" valign="top">'.$perfilaleatorio.'</td>
							</tr>';
						endif;
						if(!empty($se_usuario_cliente)):
							$mensaje3.='
							<tr>
								<td width="150px" align="left" valign="top" style="color:#060606;">Usuario:</td>
								<td width="450px" align="left" valign="top">'.$se_usuario_cliente.'</td>
							</tr>';
						endif;
						if(!empty($cliente) and $cliente<>" "):
							$mensaje3.='
							<tr>
								<td width="150px" align="left" valign="top" style="color:#060606;">Cliente:</td>
								<td width="450px" align="left" valign="top">'.$cliente.'</td>
							</tr>';
						endif;
						if(!empty($email_cliente)):
							$mensaje3.='
							<tr>
								<td width="150px" align="left" valign="top" style="color:#060606;">Email:</td>
								<td width="450px" align="left" valign="top">'.$email_cliente.'</td>
							</tr>';
						endif;
						/*if(!empty($p_calificacion)):
							$mensaje1.='
							<tr>
								<td width="150px" align="left" valign="top" style="color:#060606;">Calificación:</td>
								<td width="450px" align="left" valign="top">'.$p_calificacion.' de 5 estrellas.</td>
							</tr>';
						endif;
						if(!empty($p_comentario)):
							$mensaje1.='
							<tr>
								<td width="150px" align="left" valign="top" style="color:#060606;">Comentario:</td>
								<td width="450px" align="left" valign="top">'.cadena($p_comentario).'</td>
							</tr>';
						endif;*/
						if(!empty($cupon)):
							$mensaje3.='
							<tr>
								<td width="150px" align="left" valign="top" style="color:#060606;">Cupón:</td>
								<td width="450px" align="left" valign="top">'.$cupon.'</td>
							</tr>';
						endif;
						if(!empty($recompensa)):
							$mensaje3.='
							<tr>
								<td width="150px" align="left" valign="top" style="color:#060606;">Recompensa:</td>
								<td width="450px" align="left" valign="top">'.cadena($recompensa).'</td>
							</tr>';
						endif;
						$mensaje3.='
					</table>';
							/*$mail->MsgHTML($mensaje1);
							if($mail->Send()):
								$arreglo_respuestas[]='<div class="alert alert-success">Tu evaluación ha sido enviada exitosamente.</div>';
							else:
								$arreglo_respuestas[]='<div class="alert alert-success">Tu evaluación ha sido registrada exitosamente. Sin embargo hubo un problema al enviar tus datos.';
							endif;
						}catch (phpmailerException $e){
							$arreglo_respuestas[]='Error: '.$e->errorMessage();
						}catch (Exception $e) {
						  $arreglo_respuestas[]='Error: '.$e->getMessage();
						}						
					endif;*/

					///
					//Enviamos correo
					$host="p3plcpnl1030.prod.phx3.secureserver.net";
					$email_remitente="sitioweb@lovelocal.mx";
					$password_remitente="Chanona1981";
					$destinatario=$email_perfil;

					if(!empty($mensaje1)):
						$mail_1=new PHPMailer(true);
						try{
							$mail_1->IsSMTP();
							$mail_1->Host=$host;
							$mail_1->SMTPDebug=1;
							$mail_1->SMTPAuth=true;
							$mail_1->SMTPSecure="ssl";										
							$mail_1->Port=465;
							$mail_1->Username=$email_remitente;
							$mail_1->Password=$password_remitente;
							$mail_1->CharSet='UTF-8';
							$mail_1->AddReplyTo($email_perfil);
							$mail_1->AddAddress($destinatario);
							$mail_1->SetFrom($email_remitente);
							$mail_1->IsHTML(true);
							$mail_1->Subject=$subject;
							$mail_1->From=$email_remitente;
							$mail_1->FromName=$from;
							$mail_1->Timeout=40;
							$mail_1->MsgHTML($mensaje1);
							if($mail_1->Send()):
								$arreglo_respuestas[]='<div class="alert alert-success">Tu evaluación ha sido enviada exitosamente.</div>';
							else:
								$arreglo_respuestas[]='<div class="alert alert-success">Tu evaluación ha sido registrada exitosamente. Sin embargo hubo un problema al enviar tus datos.';
							endif;
						}catch (phpmailerException $e){
							$arreglo_respuestas[]='<div class="alert alert-warning">Error: '.$e->errorMessage().'</div>';
						}catch (Exception $e) {
						  $arreglo_respuestas[]='<div class="alert alert-warning">Error: '.$e->getMessage().'</div>';
						}						
					endif;
					if(!empty($mensaje2)):
						$mail_2 = new PHPMailer(true);
					    $destinatario = $email_cliente;
					    $subject = 'Recompensa por evaluación';
						try{
							$mail_2->IsSMTP();
							$mail_2->Host=$host;
							$mail_2->SMTPDebug=1;
							$mail_2->SMTPAuth=true;
							$mail_2->SMTPSecure="ssl";
							$mail_2->Port=465;
							$mail_2->Username=$email_remitente;
							$mail_2->Password=$password_remitente;
							$mail_2->CharSet='UTF-8';
							$mail_2->AddReplyTo($email_cliente);
							$mail_2->AddAddress($destinatario);
							/*if(!empty($email_perfil)):
								$mail->AddBCC($email_perfil);
							endif;*/
							$mail_2->SetFrom($email_remitente);
							$mail_2->IsHTML(true);
							$mail_2->Subject=$subject;
							$mail_2->From=$email_remitente;
							$mail_2->FromName=$from;
							$mail_2->Timeout=40;
							$mail_2->MsgHTML($mensaje2);
							if($mail_2->Send()):
								//$arreglo_respuestas[]='<div class="alert alert-success">Tu evaluación ha sido enviada exitosamente.</div>';
							else:
								//$arreglo_respuestas[]='<div class="alert alert-success">Tu evaluación ha sido registrada exitosamente. Sin embargo hubo un problema al enviar tus datos.';
							endif;
						}catch (phpmailerException $e){
							$arreglo_respuestas[]='<div class="alert alert-warning">Error: '.$e->errorMessage().'</div>';
						}catch (Exception $e){
						  $arreglo_respuestas[]='<div class="alert alert-warning">Error: '.$e->getMessage().'</div>';
						}
					endif;

					if(!empty($mensaje3)):
						$mail_3 = new PHPMailer(true);
					    $destinatario = $email_perfil_aleatorio;
					    $subject = 'Recompensa por evaluación';
						try{
							$mail_3->IsSMTP();
							$mail_3->Host=$host;
							$mail_3->SMTPDebug=1;
							$mail_3->SMTPAuth=true;
							$mail_3->SMTPSecure="ssl";
							$mail_3->Port=465;
							$mail_3->Username=$email_remitente;
							$mail_3->Password=$password_remitente;
							$mail_3->CharSet='UTF-8';
							$mail_3->AddReplyTo($email_perfil_aleatorio);
							$mail_3->AddAddress($destinatario);
							/*if(!empty($email_perfil)):
								$mail->AddBCC($email_perfil);
							endif;*/
							$mail_3->SetFrom($email_remitente);
							$mail_3->IsHTML(true);
							$mail_3->Subject=$subject;
							$mail_3->From=$email_remitente;
							$mail_3->FromName=$from;
							$mail_3->Timeout=40;
							$mail_3->MsgHTML($mensaje3);
							if($mail_3->Send()):
								//$arreglo_respuestas[]='<div class="alert alert-success">Tu evaluación ha sido enviada exitosamente.</div>';
							else:
								//$arreglo_respuestas[]='<div class="alert alert-success">Tu evaluación ha sido registrada exitosamente. Sin embargo hubo un problema al enviar tus datos.';
							endif;
						}catch (phpmailerException $e){
							$arreglo_respuestas[]='<div class="alert alert-warning">Error: '.$e->errorMessage().'</div>';
						}catch (Exception $e){
						  $arreglo_respuestas[]='<div class="alert alert-warning">Error: '.$e->getMessage().'</div>';
						}
					endif;

					///
				else:
					$arreglo_respuestas[]='<div class="alert alert-warning">No fue posible registrar tu evaluación. Intenta de nuevo.</div>';
				endif;
			else:
				$arreglo_respuestas[]='<div class="alert alert-warning">No fue posible encontrar recompensa a tu evaluación. Intenta de nuevo.</div>';
			endif;
		endif;
	//Validar si se recibe usuario y email
	elseif(!empty($p_usuario) and !empty($p_email)):
		//Si ya existe cliente registrado con este correo
		$c_cli=buscar("id_cliente","clientes","WHERE email='".$p_email."'");
		$id_cliente=0;
		while($f_cli=$c_cli->fetch_assoc()):
			$id_cliente=$f_cli["id_cliente"];
		endwhile;
		if($id_cliente>0):
			$arreglo_respuestas[]='<div class="alert alert-warning">Ya existe un cliente registrado con este email.</div>';
		else:
			$p_password=generate_password(10);
			//Registrar
			$c_cli2=insertar("usuario,password,email,fecha_hora_registro","clientes","'".$p_usuario."','".$p_password."','".$p_email."','".$fecha_hora_registro."'");
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

					//Borrar si existe evaluacion con este id
					$c_eva_per=eliminar("evaluaciones_perfiles","WHERE id_cliente='".$id_cliente."'");
					
					//Buscar recompensas
					$arr_recompensas=array();
					$c_rec=buscar("id_recompensa","recompensas_perfiles","WHERE id_perfil='".$p_id_perfil."' AND estatus='activo'");
					while($f_rec=$c_rec->fetch_assoc()):
						$id_recompensa=$f_rec["id_recompensa"];
						$arr_recompensas[]=$id_recompensa;
					endwhile;
					
					//Seleccionar un aleatorio
					$id_recompensa_aleatoria=array_random($arr_recompensas);
					if($id_recompensa_aleatoria>0):
						$c_rec2=buscar("recompensa","recompensas_perfiles","WHERE id_recompensa='".$id_recompensa_aleatoria."'");
						while($f_rec2=$c_rec2->fetch_assoc()):
							$recompensa=$f_rec2["recompensa"];
						endwhile;
						$cupon=generar_cupon(15);
						//Registrar evaluacion
						$c_eva_per2=insertar("id_perfil,id_cliente,id_recompensa,evaluacion,comentario,cupon,recompensa,fecha_hora_registro","evaluaciones_perfiles","'".$p_id_perfil."','".$id_cliente."','".$id_recompensa_aleatoria."','".$p_calificacion."','".$p_comentario."','".$cupon."','".$recompensa."','".$fecha_hora_registro."'");
						if($c_eva_per2==true):
							//Buscar datos del perfil y de cliente
							$c_per=buscar("local,email","perfiles","WHERE id_perfil='".$p_id_perfil."'");
							while($f_per=$c_per->fetch_assoc()):
								$perfil=cadena($f_per["local"]);
								$email_perfil=$f_per["email"];
							endwhile;
							
							$c_cli=buscar("nombres,apellidos,email","clientes","WHERE id_cliente='".$id_cliente."'");
							while($f_cli=$c_cli->fetch_assoc()):
								$cliente=cadena($f_cli["nombres"])." ".cadena($f_cli["apellidos"]);
								$email_cliente=$f_cli["email"];
							endwhile;
							
							$mensaje2='';
							$subject2='Registro de cliente LoveLocal';
							$mensaje2.='
							<table width="600px" border="0" align="left" cellspacing="1" cellpadding="3" style="color:#03538E;font:14px Arial,sans-serif; font-weight:normal;text-align: left;line-height:17px;">
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
							
							//Enviar correo...
							$mensaje1='';
							$from="LOVELOCAL";
							$subject="Registro de evaluacion LoveLocal";
							$mensaje1= '
							<table width="600px" border="0" align="left" cellspacing="1" cellpadding="3" style="color:#03538E;font:13px/20px Arial,sans-serif; font-weight:bold;text-align: left;line-height:17px;">';
								if(!empty($perfil)):
									$mensaje1.='
									<tr>
										<td width="150px" align="left" valign="top" style="color:#060606;">Perfil:</td>
										<td width="450px" align="left" valign="top">'.$perfil.'</td>
									</tr>';
								endif;
								if(!empty($usuario_cliente)):
									$mensaje1.='
									<tr>
										<td width="150px" align="left" valign="top" style="color:#060606;">Usuario:</td>
										<td width="450px" align="left" valign="top">'.$usuario_cliente.'</td>
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
								if(!empty($p_calificacion)):
									$mensaje1.='
									<tr>
										<td width="150px" align="left" valign="top" style="color:#060606;">Calificación:</td>
										<td width="450px" align="left" valign="top">'.$p_calificacion.' de 5 estrellas.</td>
									</tr>';
								endif;
								if(!empty($p_comentario)):
									$mensaje1.='
									<tr>
										<td width="150px" align="left" valign="top" style="color:#060606;">Comentario:</td>
										<td width="450px" align="left" valign="top">'.cadena($p_comentario).'</td>
									</tr>';
								endif;
								if(!empty($cupon)):
									$mensaje1.='
									<tr>
										<td width="150px" align="left" valign="top" style="color:#060606;">Cupón:</td>
										<td width="450px" align="left" valign="top">'.$cupon.'</td>
									</tr>';
								endif;
								if(!empty($recompensa)):
									$mensaje1.='
									<tr>
										<td width="150px" align="left" valign="top" style="color:#060606;">Recompensa:</td>
										<td width="450px" align="left" valign="top">'.cadena($recompensa).'</td>
									</tr>';
								endif;
								$mensaje1.='
							</table>';
							
							if((!empty($mensaje2) or !empty($mensaje1)) and !empty($email_cliente)):
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
											$arreglo_respuestas[]='<div class="alert alert-success">Tus datos han sido registrados y enviados  exitosamente.</div>';
										else:
											$arreglo_respuestas[]='<div class="alert alert-success">Tus datos han sido registrados exitosamente. Sin embargo hubo un problema al enviar tus datos.';
										endif;
									}catch (phpmailerException $e){
										$arreglo_respuestas[]='<div class="alert alert-warning">Error: '.$e->errorMessage().'</div>';
									}catch (Exception $e) {
									  $arreglo_respuestas[]='<div class="alert alert-warning">Error: '.$e->getMessage().'</div>';
									}						
								endif;
								if(!empty($mensaje1)):
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
											$arreglo_respuestas[]='<div class="alert alert-success">Tu evaluación ha sido enviada exitosamente.</div>';
										else:
											$arreglo_respuestas[]='<div class="alert alert-success">Tu evaluación ha sido registrada exitosamente. Sin embargo hubo un problema al enviar tus datos.';
										endif;
									}catch (phpmailerException $e){
										$arreglo_respuestas[]='<div class="alert alert-warning">Error: '.$e->errorMessage().'</div>';
									}catch (Exception $e){
									  $arreglo_respuestas[]='<div class="alert alert-warning">Error: '.$e->getMessage().'</div>';
									}
								endif;
							endif;
						else:
							$arreglo_respuestas[]='<div class="alert alert-warning">No fue posible registrar tu evaluación. Intenta de nuevo.</div>';
						endif;
					else:
						$arreglo_respuestas[]='<div class="alert alert-warning">No fue posible encontrar recompensa a tu evaluación. Intenta de nuevo.</div>';
					endif;					
				endif;
			else:
				$arreglo_respuestas[]='<div class="alert alert-warning">No fue posible registrar al cliente.</div>';
			endif;
		endif;
	endif;
else:
	$arreglo_respuestas[]='<div class="alert alert-warning">No se recibieron los parámetros completos.</div>';
endif;
if(count($arreglo_respuestas)):
	foreach($arreglo_respuestas as $respuesta):
		echo $respuesta;
	endforeach;
endif;