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
		$c_se1=buscar("tipo_seccion,seccion,icono,imagen,adjunto","secciones","WHERE id_seccion=".$registro);
		while($f_se1=$c_se1->fetch_assoc()):
			$tipo_seccion=cadena($f_se1['tipo_seccion']);
			$seccion=cadena($f_se1['seccion']);
			$boton=$f_se1['icono'];
			/*
			$boton_rollover=$f_se1['boton_rollover'];
			$banner=$f_se1['banner'];
			$imagen_descripcion=$f_se1['imagen_descripcion'];
			*/
			$imagen=$f_se1['imagen'];
			$adjunto=$f_se1['adjunto'];
		endwhile;
		
		//Consultar todas las secciones que dependen de esta seccion
		$c_se=buscar("COUNT(id_seccion) AS total_secciones","secciones","WHERE id_seccion_anterior=".$registro);
		while($f_se=$c_se->fetch_assoc()):
			$total_secciones=$f_se['total_secciones'];
		endwhile;
		if($total_secciones>0):
			$total_error= count($registros_error);
			$registros_error[$total_error]=$seccion." (Esta seccion tiene secciones dependientes)";
		else:
			switch($tipo_seccion):
				case "galeria":
					//Consultar imagenes de la galeria
					$c_im=buscar("count(id_imagen) as total_imagenes","galeria_secciones","where id_seccion=".$registro);
					while($f_im=$c_im->fetch_assoc()):
						$total_imagenes=$f_im["total_imagenes"];
					endwhile;
				break;
			endswitch;
			if($total_imagenes>0):
				$total_error= count($registros_error);
				$registros_error[$total_error]= $seccion." Esta seccion tiene una galeria dependiente";
			else:
				//Eliminar imagenes
				if(!empty($boton) and file_exists("../botones/".$boton)):
					unlink("../botones/".$boton);
				endif;
				/*
				if(!empty($boton_rollover) and file_exists("../botones/".$boton_rollover)):
					unlink("../botones/".$boton_rollover);
				endif;
	
				if(!empty($banner) and file_exists("../banners/".$banner)):
					unlink("../banners/".$banner);
				endif;
				
				if(!empty($imagen_descripcion) and file_exists("../images/".$imagen_descripcion)):
					unlink("../images/".$imagen_descripcion);
				endif;
				*/
	
				if(!empty($imagen) and file_exists("../images/".$imagen)):
					unlink("../images/".$imagen);
				endif;

				if(!empty($adjunto) and file_exists("../adjuntos/".$adjunto)):
					unlink("../adjuntos/".$adjunto);
				endif;
	
				//Eliminar registros
				$eliminar_registro= eliminar("secciones","WHERE id_seccion=".$registro);
			
				if($eliminar_registro):
					$registros_eliminados[]=$seccion;
				else:
					$registros_error[]= $seccion;
				endif;
			endif;
			unset($total_imagenes);
		endif;
		unset($tipo_seccion);
		unset($seccion);
		unset($boton);
		/*
		unset($boton_rollover);
		unset($banner);
		unset($imagen_descripcion);		
		*/
		unset($imagen);
		unset($adjunto);
		unset($total_secciones);
	endfor;
	$c_cl2=autonumerico("id_seccion","secciones");
	
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