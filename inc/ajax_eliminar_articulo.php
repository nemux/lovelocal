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
$p_id_articulo=$_POST["id_articulo"]*1;
if(empty($p_id_articulo)
	):
	$errors[]='<div class="error">No se recibió el parámetro del artículo.</div>';
endif;
if(!empty($se_id_perfil) and  !empty($p_id_articulo) and empty($errors)):
	date_default_timezone_set('Mexico/General');
	$fechahora_actual=date("YmdHis");
	$fecha_hora_registro=date("Y-m-d H:i:s");

	$arreglo_respuestas=array();

	$c_se=buscar("imagen","articulos_perfiles","where id_articulo='".$p_id_articulo."' AND id_perfil=".$se_id_perfil);
	while($f_se=$c_se->fetch_assoc()):
		$imagen_actual=$f_se['imagen'];
	endwhile; unset($f_se,$c_se);

	$c_id=eliminar("articulos_perfiles","WHERE id_articulo='".$p_id_articulo."' AND id_perfil='".$se_id_perfil."'");
	if(!$c_id):
		$arreglo_respuestas[count($arreglo_respuestas)]='<div class="error">No fue posible eliminar tu artículo.</span>';
	else:
		if(!empty($imagen_actual) and file_exists("../administrador/articulos/images/".$imagen_actual)):
			unlink("../administrador/articulos/images/".$imagen_actual);
		endif;
		
		$arreglo_respuestas[count($arreglo_respuestas)]='<div class="exito">Tu artículo ha sido eliminado exitosamente.</span>';
		$c_art=autonumerico("id_articulo","articulos_perfiles"); unset($c_art);
	endif;
	unset($p_id_articulo,$imagen_actual);
	unset($c_id);
endif;
if(!empty($errors)):
	foreach($errors as $error):
		echo $error."<br>";
	endforeach;
else:
	if(!empty($arreglo_respuestas)):
		foreach($arreglo_respuestas as $respuesta):
			echo $respuesta."<br>";
		endforeach;
	endif;
endif;
?>