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

		$c_se1=buscar("cat.categoria
							,cat.imagen
							,(SELECT COUNT(cat_per.id_perfil) FROM categorias_perfiles cat_per WHERE cat_per.id_categoria=cat.id_categoria) AS total_perfiles
							,(SELECT COUNT(cat_not.id_nota) FROM categorias_notas cat_not WHERE cat_not.id_categoria=cat.id_categoria) AS total_notas
							"
							,"categorias cat"
							,"WHERE cat.id_categoria=".$registro."");
		while($f_se1=$c_se1->fetch_assoc()):
			$categoria=cadena($f_se1['categoria']);
			$imagen=$f_se1['imagen'];
			$total_perfiles=$f_se1["total_perfiles"];
			$total_notas=$f_se1["total_notas"];
		endwhile;
		
		if(empty($categoria)):
			$categoria=$registro;
		endif;
		if($total_perfiles>0):
			$total_error= count($registros_error);
			$registros_error[$total_error]= $categoria." (Esta categoria tiene perfiles dependientes)";
		elseif($total_notas>0):
			$total_error= count($registros_error);
			$registros_error[$total_error]= $categoria." (Esta categoria tiene notas dependientes)";
		else:
			//Eliminar registros
			$eliminar_registro= eliminar("categorias","WHERE id_categoria=".$registro."");
			
			if($eliminar_registro):
				if(!empty($imagen) and file_exists("../images/".$imagen)):
					unlink("../images/".$imagen);
				endif;
				/*
				if(!empty($imagen_original) and file_exists("../images/".$imagen_original)):
					unlink("../images/".$imagen_original);
				endif;
				*/
				$total_eliminados= count($registros_eliminados);
				$registros_eliminados[$total_eliminados]=$categoria;
			else:
				$total_error= count($registros_error);
				$registros_error[$total_error]= $categoria;
			endif;
		endif;

		unset($categoria);
		unset($imagen,$total_perfiles,$total_notas);
		//unset($imagen_original);
	endfor;
	$c_cl2=autonumerico("id_categoria","categorias");
	
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