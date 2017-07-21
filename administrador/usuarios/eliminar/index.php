<?php
$p_registros= $_GET['registros'];
if(!empty($p_registros)):
	include("../../php/config.php");
	include("../../php/func.php");
	include("../../php/func_bd.php");
	
	//Separar los registros que se eliminarán
	$arreglo = explode("|",$p_registros);
	$cuantos = count($arreglo);
	
	$registros_eliminados= array();
	$registros_error     = array();
	
	$contador= 0;
	for($i=$contador; $i< $cuantos; $i++):
		$registro= $arreglo[$i];

		$c_se1=buscar("nombre_completo,imagen","adm_usuarios","WHERE id_usuario=".$registro." and tipo_usuario<>'Cliente' AND tipo_usuario<>'Dueño'");
		while($f_se1=$c_se1->fetch_assoc()):
			$nombre_completo=cadena($f_se1['nombre_completo']);
			$imagen=$f_se1["imagen"];
		endwhile;
		
		//Eliminar registros
		$eliminar_registro= eliminar("adm_usuarios","WHERE id_usuario=".$registro." and (tipo_usuario<>'Cliente'  AND tipo_usuario<>'Dueño')");
		
		if($eliminar_registro):
			if(!empty($imagen) and file_exists("../images/".$imagen)):
				unlink("../images/".$imagen);
			endif;
			$total_eliminados= count($registros_eliminados);
			$registros_eliminados[$total_eliminados]=$nombre_completo;
		else:
			$total_error= count($registros_error);
			$registros_error[$total_error]= $nombre_completo;
		endif;
		unset($nombre_completo,$imagen);
	endfor;
	$c_cl2=autonumerico("id_usuario","adm_usuarios");
	
	$cuantos_registros_error     = count($registros_error);
	$cuantos_registros_eliminados= count($registros_eliminados);
	
	if($cuantos_registros_error > 0):
		$respuesta_error="No se han eliminado los siguientes registros: ";
		
		for($l=0; $l< $cuantos_registros_error; $l++):
			$re_error= $re_error.",".$registros_error[$l];
		endfor;
		
		$re_error = substr($re_error,1);
		$respuesta_error= $respuesta_error.$re_error;
	endif;
	
	if($cuantos_registros_eliminados > 0):
		$respuesta_eliminados="Se han eliminado los siguientes registros: ";
		for($m=0; $m< $cuantos_registros_eliminados; $m++):
			$re_eliminados=$re_eliminados.",".$registros_eliminados[$m];
		endfor;
		$re_eliminados=substr($re_eliminados,1);
		$respuesta_eliminados=$respuesta_eliminados.$re_eliminados;
	endif;
	
	if($cuantos_registros_error>0 && $cuantos_registros_eliminados>0):
		$respuesta= $respuesta_error." y ".$respuesta_eliminados;
	else:
		if($cuantos_registros_error>0):
			$respuesta= $respuesta_error;
		endif;
		if($cuantos_registros_eliminados>0):
			$respuesta= $respuesta_eliminados;
		endif;
	endif;
	die($respuesta);
endif;
?>