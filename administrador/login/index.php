<?
error_reporting(0);
session_start();
include("../php/config.php");
include("../php/func.php");
include("../php/func_bd.php");
clearstatcache();
$p_action=$_POST['action'];
$p_usuario=cadenabd($_POST["usuario"]);
$p_password=cadenabd($_POST["password"]);
$p_code=$_POST['code'];
if(	$p_action=="send" 
and	!empty($p_usuario) 
and 	!empty($p_password)
and	!empty($p_code)
	):
	include("../php/captcha/securimage.php");
	$img=new Securimage();
	$valid=$img->check($p_code);
	//$valid = true;
	if($valid==true): //Captcha valido	
		$c_us=buscar("id_usuario
							,tipo_usuario
							,altas_secciones
							,bajas_secciones
							,actualizaciones_secciones
							,reportes_secciones"
						,"adm_usuarios"
						,"where usuario='".$p_usuario."' and password='".$p_password."'");
		while($f_us=$c_us->fetch_assoc()):
			$id_usuario=$f_us["id_usuario"];
			$tipo_usuario=$f_us["tipo_usuario"];
			$altas=$f_us['altas_secciones'];
			$bajas=$f_us['bajas_secciones'];
			$actualizaciones=$f_us['actualizaciones_secciones'];
			$reportes=$f_us['reportes_secciones'];
		endwhile;
		if($id_usuario>0 and !empty($tipo_usuario)):
			$_SESSION["s_id_usuario"]=$id_usuario;
			$_SESSION["s_tipo_usuario"]=$tipo_usuario;
			$_SESSION['s_altas']=$altas;
			$_SESSION['s_bajas']=$bajas;
			$_SESSION['s_actualizaciones']=$actualizaciones;
			$_SESSION['s_reportes']=$reportes;
			?>
			<script type="text/javascript" language="JavaScript">
				location.href="../";
			</script>
			<?
		else:
			$respuesta="inexistente";
		endif;
	else:	
		$respuesta="error_code";
	endif;	// Fin captcha
endif;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>LOGIN</title>
 <!-- Favicon -->
  <link rel="shortcut icon" href="http://www.lovelocal.mx/images/favicon.png">

<link href="../css/etiquetas.css" rel="stylesheet" type="text/css" />
<link href="../css/form.css" rel="stylesheet" type="text/css" />
<link href="../css/administrador.css" rel="stylesheet" type="text/css" />
<style>
table td{
	background-color:#FFF;
}
</style>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js"></script>
<? //include("../includes/ajuste.php");?>
<script type="text/javascript" language="javascript">
var $b=jQuery.noConflict();
$b(document).ready(function(){
	$b(window).resize(function(){
		var alto_resolucion=$b(window).height();
		var ancho_resolucion=$b(window).width();
		
		var total_alto=$b('#div_login').outerHeight();
		var total_ancho=$b('#div_login').outerWidth();
		
		if(alto_resolucion>total_alto){
			var diferencia=(alto_resolucion-total_alto)/2;
			var posicion=diferencia;
			
			$b('#div_login').css({
			top:posicion+'px',
			position:'absolute'
			});
		}
		if(ancho_resolucion>total_ancho){
			var diferencia2=(ancho_resolucion-total_ancho)/2;
			var posicion2=diferencia2;
			
			//alert("ancho resolucion "+ancho_resolucion+" y total_ancho "+total_ancho+" diferencia: "+diferencia2);
			
			$b('#div_login').css({
			left:posicion2+'px',
			position:'absolute'
			});
		}
	});
	// Ejecutamos la función
	$b(window).resize();
 
});

function A(e,t){
	var k=null;
	(e.keyCode) ? k=e.keyCode : k=e.which;
	if(k==13)(!t) ? B() : t.focus();
}
function B(){
	document.forms[0].submit();
	return true;
}
function cargar(){
	document.form1.usuario.focus();
}
</script>
</head>
<body onLoad="cargar();" style="background-color:#fff;">
<div id="contenedor" style="text-align:center; vertical-align:middle;">
	<div id="div_login" style="width:400px;">
	   <form id="form1" name="form1" method="post" action="./">
         <table border="0" cellpadding="3" cellspacing="1" style="background-color:#FFF; text-align:left;" align="center">
            <tr>
               <td></td>
               <td><img src="http://www.lovelocal.mx/images/logo.png" width="162"/></td>
            </tr>
            <tr>
            	<td></td>
					<td class="alerta" id="td_respuesta">
						<?
						if($respuesta=="inexistente"):
							?>
							El usuario capturado no existe.
							<?
						elseif($respuesta=="error_code"):
							?>
                     El código que introdujo no es correcto.
                     <?
						else:
							?>
							Capture su Usuario y Contraseña.
                     <?
                  endif;
                  ?>
					</td>
            </tr>
            <tr>
              <td width="20%">Usuario</td>
              <td width="80%"><label for="usuario"></label>
                <input type="text" name="usuario" id="usuario" <? if($respuesta=="inexistente"): ?> value="<?=$p_usuario;?>" <? endif;?> onKeyDown="A(event,this.form.password);" required="required"/></td>
            </tr>
            <tr>
              <td>Contraseña</td>
              <td><label for="password"></label>
                <input type="password" name="password" id="password" <? if($respuesta=="inexistente"): ?> value="<?=$p_password;?>" <? endif;?> onKeyDown="A(event,this.form.code);" required="required"/></td>
            </tr>
            <tr>
            	<td></td>
               <td>
                  <img src="../php/captcha/securimage_show.php?sid=<?php echo md5(uniqid(time())); ?>" id="image" style="float:left;"/>
                  <a href="#" onClick="document.getElementById('image').src = '../php/captcha/securimage_show.php?sid=' + Math.random(); return false" style="float:left; padding-top:7px; padding-left:7px;">
                     <img src="../php/captcha/images/refresh.gif" border="0" alt="Actualizar Imagen"/>
                  </a>
               </td>
            </tr>
            <tr>
            <td></td>
            <td>Capture los caracteres que aparecen en la imagen</td>
            </tr>
            <tr>
            	<td></td>
               <td> <input type="text" class="input-block-level form-control" name="code" id="code" style="width:100px;" onKeyDown="A(event,this.form.entrar);" value="" required/></td>
            </tr>
            <tr>
              <td><input type="hidden" name="action" value="send"/></td>
              <td><input name="entrar" type="submit" class="link_5" id="entrar" value="Entrar"/></td>
            </tr>
          </table>
          <!--
	     	</fieldset>
         -->
      </form>
	</div>
</div>
</body>
</html>