<?php
error_reporting(0);
session_start();
ini_set("display_errors","On");
include("../administrador/php/config.php");
include("../administrador/php/func.php");
include("../administrador/php/func_bd.php");
include("../administrador/includes/phpmailer/class.phpmailer.php");
$p_tipo_usuario=$_POST["tipo_usuario"];
$p_usuario=cadenabd($_POST['usuario']);
$p_password=cadenabd($_POST['password']);
$p_code=$_POST['code'];
$p_action=$_POST['action'];
$p_id_idioma=1;
//print_r($_POST);
if(!empty($p_tipo_usuario) and
	!empty($p_usuario) and 
	!empty($p_password) and
	!empty($p_code) and
	$p_action=="send"
	):
	include("../administrador/php/captcha/securimage.php");
	$img=new Securimage();
	$valid=$img->check($p_code);
	//$valid = true;
	if($valid==true): //Captcha valido	
		date_default_timezone_set('Mexico/General');
		$fecha_hora_actual=date("Y-m-d H:i:s");
		if($p_tipo_usuario=="perfil"):
			$c_per=buscar("id_perfil,usuario,password","perfiles","WHERE usuario='".$p_usuario."' AND password='".$p_password."'");
			while($f_per=$c_per->fetch_assoc()):
				$id_perfil=$f_per["id_perfil"];
				$usuario_perfil=$f_per["usuario"];
				$password_perfil=$f_per["password"];
			endwhile;
			if(!empty($id_perfil) and !empty($usuario_perfil) and !empty($password_perfil)):
				$_SESSION["s_id_perfil"]=$id_perfil;
				$_SESSION["s_usuario_perfil"]=$usuario_perfil;
				$_SESSION["s_password_perfil"]=$password_perfil;
				$respuesta="exito";
			else:
				$respuesta="El usuario con los datos capturados no existe en nuestra Base de datos o no se encuentra activo.";
			endif;
		elseif($p_tipo_usuario=="cliente"):
			$c_cli=buscar("id_cliente,usuario,password","clientes","WHERE usuario='".$p_usuario."' AND password='".$p_password."'");
			while($f_cli=$c_cli->fetch_assoc()):
				$id_cliente=$f_cli["id_cliente"];
				$usuario_cliente=$f_cli["usuario"];
				$password_cliente=$f_cli["password"];
			endwhile;
			if(!empty($id_cliente) and !empty($usuario_cliente) and !empty($password_cliente)):
				$_SESSION["s_id_cliente"]=$id_cliente;
				$_SESSION["s_usuario_cliente"]=$usuario_cliente;
				$_SESSION["s_password_cliente"]=$password_cliente;
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