<?
session_start();
ini_set("display_errors","On");
$se_id_usuario=$_SESSION["s_id_usuario"];
$se_seccion=$_SESSION['s_seccion'];

if(empty($se_id_usuario)):
	?>
	<script type="text/javascript" language="javascript">
   location.href="../../login/";
   </script>
   <?
else:
include("../../php/config.php");
include("../../php/func.php");			
include("../../php/func_bd.php");

		$p_action=$_POST['action'];
		if($p_action=="send"):

			date_default_timezone_set('Mexico/General');
			$fechahora=date("YmdHis");
			
			$arreglo_respuestas=array();
			
			$p_numero=$_POST['numero']*1;
			
			if($p_numero>0):
				for($con=1;$con<=$p_numero;$con++):
					$servicio='servicio'.$con;
					$imagen='imagen'.$con;
					$enlace='enlace'.$con;
					//$imagen_original='imagen_original'.$con;
					$orden='orden'.$con;
					$estatus='estatus'.$con;
					
					$p_servicio=cadenabd($_POST[$servicio]);
					$varname=$_FILES[$imagen]['name'];
					$p_enlace=cadenabd($_POST[$enlace]);
					//$varname2=$_FILES[$imagen_original]['name'];
					$p_orden=$_POST[$orden]*1;
					$p_estatus=$_POST[$estatus];
					
					//Buscar el ultimo id de la imagen
					$c_gr=buscar("id_servicio","servicios","order by id_servicio desc limit 1");
					while($f_gr=mysql_fetch_assoc($c_gr)):
						$id_servicio=$f_gr["id_servicio"];
						$id_servicio=$id_servicio+1;
					endwhile;
					if(empty($id_servicio)):
						$id_servicio=1;
					endif;

					if(!empty($varname)):
						$vartemp=$_FILES[$imagen]['tmp_name'];
						$extension=obtener_extension($varname);
						$p_imagen="i".$id_servicio."_".$fechahora.$extension;
						$nombre_archivo="../images/".$p_imagen;
						move_uploaded_file($vartemp,$nombre_archivo);
						unset($varname);
						unset($extension);
						unset($nombre_archivo);
					endif;
					
					/*
					if(!empty($varname2)):
						$vartemp2=$_FILES[$imagen_original]['tmp_name'];
						$extension2=obtener_extension($varname2);
						$p_imagen_original="io".$id_servicio.$extension2;
						$nombre_archivo2="../images/".$p_imagen_original;
						move_uploaded_file($vartemp2,$nombre_archivo2);
					endif;
					unset($varname2);
					unset($extension2);
					unset($nombre_archivo2);
					*/
					
					//Registrar imagenes en servicio
					$i_c=insertar("servicio
										,imagen
										,enlace
										,orden
										,estatus"
										,"servicios"
										,"'".$p_servicio."'
										,'".$p_imagen."'
										,'".$p_enlace."'
										,".$p_orden."
										,'".$p_estatus."'");
					if(!$i_c):
						$arreglo_respuestas[count($arreglo_respuestas)]="No fue posible registrar el servicio ".$con;
					else:
						$arreglo_respuestas[count($arreglo_respuestas)]="Servicio ".$con." registrada exitosamente.";
					endif;
					
					unset($p_servicio);
					unset($p_imagen);
					unset($p_enlace);
					//unset($p_imagen_original);
					unset($p_orden);
					unset($p_estatus);
					unset($id_servicio);					
				endfor;
			endif;
		endif;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>servicio - NUEVO</title>
<link href="../../css/etiquetas.css" rel="stylesheet" type="text/css" />
<link href="../../css/form.css" rel="stylesheet" type="text/css" />
<link href="../../css/administrador.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js"></script>
<? 
include("../../includes/ajuste.php");
?>
<script type="text/javascript" src="../../js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>

<script type="text/javascript" language="javascript" src="../../js/funciones.js"></script>
<script type="text/javascript" language="javascript" src="../../js/fmt-money.js"></script>
<script type="text/javascript" language="javascript" src="../ajax.js"></script>

<!--CALENDARIO-->
<link href="../../js/addons/jscalendar-1.0/calendar-tas.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../js/formatdate.js"></script>
<script type="text/javascript" src="../../js/addons/jscalendar-1.0/calendar.js"></script>
<script type="text/javascript" src="../../js/addons/jscalendar-1.0/lang/calendar-es.js"></script>
<script type="text/javascript" src="../../js/addons/jscalendar-1.0/calendar-setup.js"></script>
<!--CALENDARIO-->

<script type="text/javascript" language="javascript">
function validar(form){
	var contenedor=document.getElementById("td_respuesta");
	var numero=new Number(form.numero.value)*1;
	if(numero==0){
		contenedor.innerHTML="Capture un numero mayor a cero.";
		form.numero.focus();
		return false;
	}
	else{
		for(var con=1;con<=numero;con++){
			if (eval("form.servicio"+con+".value")== "") { 
				contenedor.innerHTML="Capture el servicio del servicio "+con;
				eval("form.servicio"+con+".focus()");
				return false;
			}
			if (eval("form.imagen"+con+".value")== "") { 
				contenedor.innerHTML="Adjunte el servicio "+con;
				eval("form.imagen"+con+".focus()");
				return false;
			}
		}
	}
	form.submit();
}
</script>
</head>
<body>
<div id="contenedor">
	<div id="cabecera">
   	<?
		include("../../includes/encabezado.php");
		?>
  	</div>
    <div id="separador">&nbsp;</div>
      <div class="div_separador">&nbsp;</div>
  	<div id="menu">
   	<?
		include("../../includes/menu.php");
		?>
  	</div>
  	<div id="contenido">
      <div id="#menu_interno">
         <?
         include("../../includes/menu_interno.php");
         ?>
      </div>
      <div>
      <?
      if(count($arreglo_respuestas)>0):
         ?>
<table cellpadding="3" cellspacing="1" width="100%">
                            <?
                  foreach($arreglo_respuestas as $respuesta):
                     ?>
                            <tr>
                              <td class="respuesta"><?=$respuesta;?></td>
                            </tr>
                            <?
                  endforeach;
                  ?>
                          </table>
                        <?
      endif;
		?>
		<form action="./" method="post" enctype="multipart/form-data" name="form1" id="form1">
      <fieldset>
      <legend>Nueva Imagen</legend>
                      <table border="0" cellpadding="3" cellspacing="1" width="80%" align="left" class="text_gral">
                        <?
		?>
                        <tr>
                        	<td></td>
                          <td colspan="2" class="alerta" id="td_respuesta">
                          </td>
                        </tr>
                        <tr>
                          <td width="20%">Número de servicio que desea subir:
                          </td>
                          <td valign="middle" width="10%">
                            <input name="numero" type="text" size="2" maxlength="2" style="float:left;">
                            &nbsp;<span class="info">*</span>
                          </td>
                          <td valign="middle" width="70%"><input name="button2" type="button" class="link_5" onClick="crear_campos(document.form1.numero.value);"  value="Agregar" style="float:left;" /></td>
                        </tr>
                        <tr>
                        	<td colspan="3" id="td_contenedor"></td>
                        </tr>
                        <tr>
                        	<td width="20%">&nbsp;</td>
                           <td width="80%" colspan="2" class="info">* Requerido</td>
                        </tr>
                        <tr>
                           <td><input type="hidden" name="action" value="send"></td>
                           <td colspan="2"><input type="button" 
                                       name="button" 
                                       id="button" 
                                       value="Registro"
                                       onClick="validar(document.form1);"></td>
                        </tr>
                      </table>
                      </fieldset>
                    </form>
   	</div>
  	</div>
	<div id="pie">
   	<?
		include("../../includes/pie.php");
		?>
  	</div>
</div>
</body>
</html>
<?
endif;
?>