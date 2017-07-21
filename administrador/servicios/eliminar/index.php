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

		$c_se1=buscar("servicio,imagen","servicios","WHERE id_servicio=".$registro."");
		while($f_se1=mysql_fetch_assoc($c_se1)):
			$servicio=cadena($f_se1['servicio']);
			$imagen=$f_se1['imagen'];
			//$imagen_original=$f_se1['imagen_original'];
		endwhile;
		
		if(empty($servicio)):
			$servicio=$registro;
		endif;

		if(!empty($imagen) and file_exists("../images/".$imagen)):
			unlink("../images/".$imagen);
		endif;
		/*
		if(!empty($imagen_original) and file_exists("../images/".$imagen_original)):
			unlink("../images/".$imagen_original);
		endif;
		*/
		
		//Eliminar registros
		$eliminar_registro= eliminar("servicios","WHERE id_servicio=".$registro."");
		
		if($eliminar_registro):
			$total_eliminados= count($registros_eliminados);
			$registros_eliminados[$total_eliminados]=$servicio;
		else:
			$total_error= count($registros_error);
			$registros_error[$total_error]= $servicio;
		endif;
		unset($servicio);
		unset($imagen);
		//unset($imagen_original);
	endfor;
	$c_cl2=autonumerico("id_servicio","servicios");
	
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