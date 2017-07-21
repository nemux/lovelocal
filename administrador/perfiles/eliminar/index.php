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

		$c_se1=buscar("per.nombres,per.imagen","perfiles per","WHERE per.id_perfil=".$registro."");
		while($f_se1=$c_se1->fetch_assoc()):
			$nombre_completo=cadena($f_se1['nombres']);
			$imagen=$f_se1["imagen"];
		endwhile;
		//Eliminar registros
		$eliminar_registro= eliminar("perfiles","WHERE id_perfil=".$registro."");
		
		if($eliminar_registro):
			if(!empty($imagen) and file_exists("../images/".$imagen)):
				unlink("../images/".$imagen);
			endif;
			
			//Buscar los regalos de los perfiles
			$c_reg=buscar("id_regalo","regalos_perfiles","WHERE id_perfil='".$registro."'");
			if($c_reg->num_rows>0):
				while($f_reg=$c_reg->fetch_assoc()):
					$id_regalo=$f_reg["id_regalo"];
					
					//Eliminar las asignaciones de este regalo a los clientes 
					$c_reg_cli=eliminar("regalos_clientes","WHERE id_regalo='".$id_regalo."'");
					
					unset($id_regalo);
				endwhile;
			endif;
			$c_reg->free();
			//Eliminar regalos
			$c_reg=eliminar("regalos_perfiles","WHERE id_perfil='".$registro."'");
			
			//Eliminar recompensas
			$c_rec=eliminar("recompensas_perfiles","WHERE id_perfil='".$registro."'");
			
			//Eliminar evaluaciones
			$c_eva=eliminar("evaluaciones_perfiles","WHERE id_perfil='".$registro."'");
			
			//Buscar promociones
			$c_pro=buscar("id_promocion,imagen","promociones_perfiles","WHERE id_perfil='".$registro."'");
			while($f_pro=$c_pro->fetch_assoc()):
				$id_promocion=$f_pro["id_promocion"];
				$imagen_promocion=$f_pro["imagen"];
				if(!empty($imagen_promocion) and file_exists("../../promociones/images/".$imagen_promocion)):
					unlink("../../promociones/images/".$imagen_promocion);
				endif;
				//Eliminar asignaciones de promocion a los clientes
				$c_pro_cli=eliminar("promociones_clientes","WHERE id_perfil='".$registro."' AND id_promocion='".$id_promocion."'");
				
				unset($id_promocion,$imagen_promocion);
			endwhile;
			$c_pro->free();
			$c_pro=eliminar("promociones_perfiles","WHERE id_perfil='".$registro."'");
			
			//Buscar fotos
			$c_fot=buscar("foto","fotos_perfiles","WHERE id_perfil='".$registro."'");
			while($f_fot=$c_fot->fetch_assoc()):
				$foto=$f_fot["foto"];
				if(!empty($foto) and file_exists("../../galeria_fotos/images/".$foto)):
					unlink("../../galeria_fotos/images/".$foto);
				endif;
				unset($foto);
			endwhile;
			$c_fot=eliminar("fotos_perfiles","WHERE id_perfil='".$registro."'");
			
			//Eliminar productos
			$c_pro=eliminar("productos_perfiles","WHERE id_perfil='".$registro."'");

			//Eliminar videos
			$c_vid=eliminar("videos_perfiles","WHERE id_perfil='".$registro."'");
			
			//Buscar artitulos
			$c_art=buscar("imagen","articulos_perfiles","WHERE id_perfil='".$registro."'");
			while($f_art=$c_art->fetch_assoc()):
				$imagen_articulo=$f_art["imagen"];
				if(!empty($imagen_articulo) and file_exists("../../articulos/images/".$imagen_articulo)):
					unlink("../../articulos/images/".$imagen_articulo);
				endif;
				unset($imagen_articulo);
			endwhile;
			$c_art=eliminar("articulos_perfiles","WHERE id_perfil='".$registro."'");
			
			//Eliminar categorias
			$c_cat=eliminar("categorias_perfiles","WHERE id_perfil='".$registro."'");
			
			//Eliminar dependencias
			$total_eliminados= count($registros_eliminados);
			$registros_eliminados[$total_eliminados]=$nombre_completo;
		else:
			$total_error= count($registros_error);
			$registros_error[$total_error]= $nombre_completo;
		endif;
		unset($nombre_completo,$imagen);
	endfor;
	$c_cl2=autonumerico("id_perfil","perfiles");
	$c_reg=autonumerico("id_regalo","regalos_perfiles");
	$c_reg_cli=autonumerico("id_registro","regalos_clientes");
	$c_rec=autonumerico("id_recompensa","recompensas_perfiles");
	$c_eva=autonumerico("id_evaluacion","evaluaciones_perfiles");
	$c_pro=autonumerico("id_promocion","promociones_perfiles");
	$c_pro_cli=autonumerico("id_registro","promociones_clientes");
	$c_fot=autonumerico("id_foto","fotos_perfiles");
	$c_pro=autonumerico("id_producto","productos_perfiles");
	$c_vid=autonumerico("id_video","videos_perfiles");
	$c_art=autonumerico("id_articulo","articulos_perfiles");
	
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