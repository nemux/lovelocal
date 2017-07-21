<?php
function cadena($cadena,$salto=false){
	$cadena=utf8_encode($cadena);
	$cadena=stripslashes($cadena);
	if($salto==true):
		$cadena=nl2br($cadena);
	endif;
	return trim($cadena);
}
function cadenabd($cadena){
	$cadena=addslashes($cadena);
	$cadena=utf8_decode($cadena);
	return trim($cadena);
}
/*
function moneda($cadena,$decimales=2){
	if(!empty($cadena)):
		$cadena=number_format($cadena,$decimales);
	else:
		$cadena="";
	endif;
	return $cadena;
}
*/
function moneda($cadena,$decimales=2,$signo="",$moneda=""){
	if(!empty($cadena)):
		$cadena=number_format($cadena,$decimales);
		if(!empty($signo)):
			$cadena=$signo.$cadena;
		endif;
		if(!empty($moneda)):
			$cadena.=" ".$moneda;
		endif;
	else:
		$cadena="";
	endif;
	return $cadena;
}

function creaUrlLink($url){
	// Tranformamos todo a minusculas
	$url = strtolower($url);
	//Rememplazamos caracteres especiales latinos
	$find = array('á', 'é', 'í', 'ó', 'ú', 'ñ');
	$repl = array('a', 'e', 'i', 'o', 'u', 'n');
	$url = str_replace ($find, $repl, $url);
	// Añaadimos los guiones
	$find = array(' ', '&', '\r\n', '\n', '+');
	$url = str_replace ($find, '-', $url);
	// Eliminamos y Reemplazamos demás caracteres especiales
	$find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');
	$repl = array('', '-', '');
	$url = preg_replace ($find, $repl, $url);
	return $url;
}


function fecha($fecha){ //2015-04-20 - 20/04/2015
	if($fecha!="0000-00-00" and !empty($fecha)):
		$anio=substr($fecha,0,4);				
		$mes=substr($fecha,5,2);
		$dia=substr($fecha,8,2);
		$fecha=$dia."/".$mes."/".$anio;
	else:
		$fecha="";
	endif;
	return $fecha;
}

function fechabd($fecha){
	if($fecha!="00/00/0000" and !empty($fecha)):
		$anio=substr($fecha,6,4);
		$mes=substr($fecha,3,2);
		$dia=substr($fecha,0,2);
		$fecha=$anio."-".$mes."-".$dia;
	else:
		$fecha="0000-00-00";
	endif;
	return $fecha;
}

function dia_letra($fecha,$abreviado=false){	//formato 0000-00-00
	$timestamp=strtotime($fecha);
	$dia=date("D",$timestamp);
	switch($dia):
		case"Sun":
			$dia="Domingo";
			if($abreviado==true):
				$dia="Dom";
			endif;
		break;
		case"Mon":
			$dia="Lunes";
			if($abreviado==true):
				$dia="Lun";
			endif;
		break;
		case"Tue":
			$dia="Martes";
			if($abreviado==true):
				$dia="Mar";
			endif;
		break;
		case"Wed":
			$dia="Miércoles";
			if($abreviado==true):
				$dia="Mié";
			endif;
		break;
		case"Thu":
			$dia="Jueves";
			if($abreviado==true):
				$dia="Jue";
			endif;
		break;
		case"Fri":
			$dia="Viernes";
			if($abreviado==true):
				$dia="Vie";
			endif;
		break;
		case"Sat":
			$dia="Sábado";
			if($abreviado==true):
				$dia="Sáb";
			endif;
		break;
	endswitch;
	return $dia;
}

function mes_letra($mes){
	switch($mes):
		case "01": 
			$mes="Enero"; 
		break;
		case "02": 
			$mes="Febrero"; 
		break; 
		case "03": 
			$mes="Marzo"; 
		break; 
		case "04": 
			$mes="Abril"; 
		break; 
		case "05": 
			$mes="Mayo"; 
		break; 
		case "06": 
			$mes="Junio"; 
		break; 
		case "07": 
			$mes="Julio"; 
		break; 
		case "08": 
			$mes="Agosto"; 
		break; 
		case "09": 
			$mes="Septiembre"; 
		break; 
		case "10": 
			$mes="Octubre"; 
		break; 
		case "11": 
			$mes="Noviembre"; 
		break; 
		case "12": 
			$mes="Diciembre"; 
		break; 
	endswitch;
	return $mes;
}

function eliminar_coma($cadena){
	$cadena=str_replace("$","",$cadena);
	$cadena=str_replace(",","",$cadena);
	$cadena=$cadena*1;
	return $cadena;
}

function obtener_extension($ruta){
	$tamano=strlen($ruta);		//Tamaño de la cadena
	for($i=$tamano;$i>0;$i--):	//Recorrer del final al principio
		$caracter=$ruta[$i];		//Obtener el caracter de cada posicion archivo.jpg
		if($caracter=="."):
			//Cortar la cadena desde esa posicion
			$cadena=substr($ruta,$i);
			return $cadena;
			exit();
		endif;
	endfor;
}// fin extension_archivo

function cambiar_tamano($src,$dst,$dstx,$dsty){	//origen,destino,ancho,alto
	if(!empty($src) && !empty($dst) && !empty($dstx) && !empty($dsty) ):
	
		if(!file_exists($src)):
			$resultado= "ERROR1";
			return $resultado;
		endif;

		$posicion= strrpos($dst, ".");
		if(!$posicion):
			$resultado= "ERROR2";
			return $resultado;
		endif;
		
		$pos= strrpos($dst, "/");
		if($pos):
			$nombre= substr($dst, 0, $pos+1);
			if(!is_dir($nombre)):
				$resultado= "ERROR3";
				return $resultado;
			endif;
		endif;
	
		$allowedExtensions= 'JPG jpg JPEG jpeg GIF gif PNG png';
		$name					= explode(".", $src);
		$currentExtensions= $name[count($name)-1];
		$extensions			= explode(" ", $allowedExtensions);
			
		for($i= 0; count($extensions)> $i; $i= $i+1):
			if($extensions[$i]== $currentExtensions):
				$extensionOK  = 1;
				$fileExtension= $extensions[$i];
				break;
			endif;
		endfor;
				
		if($extensionOK):
			$size  = getImageSize($src);
			$width = $size[0];
			$height= $size[1];
			$creado= false;
			
			if($width>= $dstx AND $height>= $dsty):
				$proportion_X= $width / $dstx;
				$proportion_Y= $height / $dsty;
		
				if($proportion_X > $proportion_Y ):
					$proportion = $proportion_Y;
				else:
					$proportion = $proportion_X ;
				endif;

				$target['width'] = $dstx * $proportion;
				$target['height']= $dsty * $proportion;
				$original['diagonal_center']= round(sqrt(($width * $width) + ($height * $height)) / 2);
				$target['diagonal_center']  = round(sqrt(($target['width'] * $target['width']) + ($target['height'] * $target['height'])) / 2);
				$crop= round($original['diagonal_center'] - $target['diagonal_center']);
		
				if($proportion_X < $proportion_Y ):
					$target['x']= 0;
					$target['y']= round((($height / 2) * $crop) / $target['diagonal_center']);
				else:
					$target['x']=  round((($width / 2) * $crop) / $target['diagonal_center']);
					$target['y']= 0;
				endif;

				if($fileExtension== "jpg" OR $fileExtension== 'jpeg' or $fileExtension== "JPG" OR $fileExtension== 'JPEG'):
					$from= ImageCreateFromJpeg($src);
				elseif($fileExtension== "gif" or $fileExtension== "GIF"):
					$from= ImageCreateFromGIF($src);
				elseif($fileExtension== 'png' or $fileExtension== 'PNG'):
					 $from= imageCreateFromPNG($src);
				endif;
				
				$new= ImageCreateTrueColor($dstx,$dsty);
		
				imagecopyresampled($new,$from,0,0,$target['x'],$target['y'],$dstx,$dsty,$target['width'],$target['height']);
		
				if($fileExtension== "jpg" OR $fileExtension== 'jpeg' or $fileExtension== "JPG" OR $fileExtension== 'JPEG'):
					imagejpeg($new,$dst,90);
					$creado= true;
				elseif($fileExtension== "gif" or $fileExtension== "GIF"):
					imagegif($new,$dst);
					$creado= true;					
				elseif($fileExtension== 'png' or $fileExtension== 'PNG'):
					imagepng($new,$dst);
					$creado= true;
				endif;
			endif;
			if($creado):
				$resultado= "EXITO";
				return $resultado;
			else:
				$resultado= "ERROR4";
				return $resultado;
			endif;
		else:
			$resultado="ERROR5";
			return $resultado;			
		endif;
	else:
		$resultado="ERROR6";
		return $resultado;
	endif;
}
function horario($horario){
	//echo "horario: ".$horario."<br>";
	$hora=substr($horario,0,2);
	$minutos=substr($horario,3,2);
	//echo "hora: ".$hora." y minutos: ".$minutos."<br>";
	$meridiano="";
	if($hora>=12):
		//$meridiano="p.m.";
		$meridiano="pm";
	else:
		//$meridiano="a.m.";
		$meridiano="am";
	endif;
	$formato_hora=formato_hora($hora);
	return $formato_hora.":".$minutos.$meridiano;
}

function formato_hora($hora){
	//echo "hora orig ".$hora;
	switch($hora):
		case "00":
			$hora_formato="12";
		break;
		case "13":
			$hora_formato="01";
		break;
		case "14":
			$hora_formato="02";
		break;
		case "15":
			$hora_formato="03";				
		break;
		case "16":
			$hora_formato="04";
		break;
		case "17":
			$hora_formato="05";
		break;
		case "18":
			$hora_formato="06";
		break;
		case "19":
			$hora_formato="07";
		break;
		case "20":
			$hora_formato="08";
		break;
		case "21":
			$hora_formato="09";			
		break;
		case "22":
			$hora_formato="10";		
		break;
		case "23":
			$hora_formato="11";
		break;
		case "24":
			$hora_formato="12";
		break;
		default:
			$hora_formato=$hora;
		break;
	endswitch;
	//echo "hora_formato ".$hora_formato;	
	return $hora_formato;
}
function id_youtube($url){
	$patron = '%^ (?:https?://)? (?:www\.)? (?: youtu\.be/ | youtube\.com (?: /embed/ | /v/ | /watch\?v= ) ) ([\w-]{10,12}) $%x';
   $array=preg_match($patron, $url, $parte);
   if (false !== $array) {
   	return $parte[1];
   }
   return false;
}

function generate_password($longitud=10){
	//Characters to use for the password
	$str = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789.-+=_,!@$#*%<>[]{}";

	// Desired length of the password
	$pwlen=$longitud;
	 
	// Length of the string to take characters from
	$len = strlen($str);
	 
	// RANDOM.ORG - We are pulling our list of random numbers as a 
	// single request, instead of iterating over each character individually
	/*
	$uri="http://www.random.org/integers/?";
	$random=file_get_contents(
		 $uri."num=$pwlen&min=0&max=".($len-1)."&col=1&base=10&format=plain&rnd=new"
	);
	$indexes=explode("\n",$random);
	//array_pop(&$indexes);
	array_pop($indexes);
	*/
	 
	// We now have an array of random indexes which we will use to build our password
	$pw='';
	for($i=0;$i<$pwlen;$i++):
	  $pw.=substr($str,rand(0,$len-1),1);
	endfor;
	// the finished password
	//$pw = str_shuffle($pw);
	
	/*
	foreach($indexes as $int){
		$pw.=substr($str,$int,1);
	}
	*/
	// Password is stored in `$pw`
	return $pw;
}
function test_input($data) {
	//$data=stripslashes(strip_tags(trim($data)));
	$data=htmlspecialchars(stripslashes(strip_tags(trim($data))));
	/*
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	*/
	return $data;
}
function array_random($arr){
	$c1=sizeof($arr)-1;
	$valor=$arr[rand(0,$c1)];
   return $valor;
}
function generar_cupon($longitud=10){
	//Characters to use for the password
	$str = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	$pwlen=$longitud;
	$len = strlen($str);
	$pw='';
	for($i=0;$i<$pwlen;$i++):
	  $pw.=substr($str,rand(0,$len-1),1);
	endfor;
	return $pw;
}
?>