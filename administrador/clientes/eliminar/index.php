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

		$c_se1=buscar("cli.usuario
							,cli.nombres
							,cli.apellidos
							,cli.imagen
							,(SELECT COUNT(eva.id_evaluacion) FROM evaluaciones_perfiles eva WHERE eva.id_cliente=cli.id_cliente) AS total_evaluaciones
							,(SELECT COUNT(pro_cli.id_registro) FROM promociones_clientes pro_cli WHERE pro_cli.id_cliente=cli.id_cliente) AS total_promociones
							,(SELECT COUNT(reg_cli.id_registro) FROM regalos_clientes reg_cli WHERE reg_cli.id_cliente=cli.id_cliente) AS total_regalos"
							,"clientes cli"
							,"WHERE cli.id_cliente=".$registro."");
		while($f_se1=$c_se1->fetch_assoc()):
			$usuario=cadena($f_se1["usuario"]);
			$nombre_completo=trim(cadena($f_se1['nombres'])." ".cadena($f_se1['apellidos']));
			$imagen=$f_se1["imagen"];
			$total_evaluaciones=$f_se1["total_evaluaciones"];
			$total_promociones=$f_se1["total_promociones"];
			$total_regalos=$f_se1["total_regalos"];
			$cliente="";
			if(empty($nombre_completo)):
				$cliente=$usuario;
			else:
				$cliente=$nombre_completo;
			endif;
		endwhile;
		
		if(!empty($total_evaluaciones)):
			$total_error= count($registros_error);
			$registros_error[$total_error]= $cliente." (Este cliente tiene evaluaciones dependientes)";
		elseif(!empty($total_promociones)):
			$total_error= count($registros_error);
			$registros_error[$total_error]= $cliente." (Este cliente tiene promociones dependientes)";
		elseif(!empty($total_regalos)):
			$total_error= count($registros_error);
			$registros_error[$total_error]= $cliente." (Este cliente tiene regalos dependientes)";
		else:
			//Eliminar registros
			$eliminar_registro= eliminar("clientes","WHERE id_cliente=".$registro."");
			
			if($eliminar_registro):
				if(!empty($imagen) and file_exists("../images/".$imagen)):
					unlink("../images/".$imagen);
				endif;
				
				//Eliminar dependencias
				$total_eliminados= count($registros_eliminados);
				$registros_eliminados[$total_eliminados]=$cliente;
			else:
				$total_error= count($registros_error);
				$registros_error[$total_error]= $cliente;
			endif;
		endif;
		unset($usuario,$nombre_completo,$imagen,$total_evaluaciones,$total_promociones,$total_regalos,$cliente,$eliminar_registro);
	endfor;
	$c_cl2=autonumerico("id_cliente","clientes");
	
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