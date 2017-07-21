<?
session_start();
$se_id_usuario=$_SESSION["s_id_usuario"];
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>RED SOCIAL - NUEVA</title>
<link rel="shortcut icon" href="http://www.lovelocal.mx/images/favicon.png" />
<link href="../../css/etiquetas.css" rel="stylesheet" type="text/css" />
<link href="../../css/form.css" rel="stylesheet" type="text/css" />
<link href="../../css/administrador.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js"></script>
<? 
include("../../includes/ajuste.php");
include("../../includes/tiny_mce.php");
?>
<script type="text/javascript" language="javascript" src="../../js/funciones.js"></script>
<script type="text/javascript" language="javascript" src="../ajax.js"></script>
<script type="text/javascript" language="javascript">
function goToPage(page){
   	top.location.href= page;
}

function validar(form){
	var contenedor=document.getElementById("td_respuesta");

	if(form.titulo.value==""){
		contenedor.innerHTML="Capture el nombre de la red social";
		return false;
	}
	/*
	if(form.imagen.value==""){
		contenedor.innerHTML="Adjunte el icono de la red social";
		return false;
	}
	*/
	if(form.enlace.value==""){
		contenedor.innerHTML="Capture el enlace de la red social";
		return false;
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
      <div id="menu_paginacion">
         <?
         include("../../includes/menu_interno.php");
         ?>
      </div>
      <div class="div_separador">&nbsp;</div>
      <div id="div_contenido">
		<form action="./" method="post" enctype="multipart/form-data" name="form1" id="form1">
   	<p>Los campos con <strong>*</strong> son requeridos.</p>
      <fieldset>
      <legend>Nueva red social</legend>
      <table border="0" cellpadding="3" cellspacing="1" align="left">
	      <?
			$p_action=isset($_POST['action'])?$_POST['action']:"";
			if($p_action=="send"):
				date_default_timezone_set('Mexico/General');
				$fechahora=date("YmdHis");
				
				$p_titulo=cadenabd($_POST["titulo"]);
				$p_enlace=cadenabd($_POST["enlace"]);
				$varname3=cadenabd($_FILES['imagen']['name']);
				$p_orden=$_POST['orden']*1;
				$p_estatus=$_POST["estatus"];
				
				$c_p=buscar("id_red","redes_sociales","ORDER BY id_red DESC LIMIT 1");
				while($f_p=$c_p->fetch_assoc()):
					$id_red=$f_p['id_red'];
				endwhile;
				$id_red=$id_red+1;
				
				if(!empty($varname3)):
					$vartemp3=$_FILES['imagen']['tmp_name'];
					$extension3=obtener_extension($varname3);
					$p_imagen="i".$id_red."_".$fechahora.$extension3;
					$nombre_archivo3="../images/".$p_imagen;
					move_uploaded_file($vartemp3,$nombre_archivo3);
				endif;

				//Registrar
				$c_id=insertar("titulo,enlace,imagen,orden,estatus","redes_sociales","'".$p_titulo."','".$p_enlace."','".$p_imagen."',".$p_orden.",'".$p_estatus."'");
				
				if($c_id):
					//die("Sección registrada exitosamente");			
					?>
					<script type="text/javascript" language="JavaScript">
						alert("Red social registrada exitosamente");
						location.href="../";
					 </script>
					<?
				else:
					//die("No fue posible registrar la seccion. Intente de nuevo");
					?>
					<script type="text/javascript" language="JavaScript">
						alert("No fue posible registrar la red social. Intente de nuevo");
						location.href="./";
					 </script>
					<?
				endif;
			endif;
				?>
            
                        <tr>
                        	<td></td>
                          <td class="alerta" id="td_respuesta"></td>
                        </tr>
                        <tr>
                          <td class="text_gral">Red social</td>
                          <td class="text_gral"><? /*<input type="text" name="titulo" style="width:200px;" maxlength="100" />*/ ?>
                          <select name="titulo" required>
                             <option value="">Seleccione ...</option>
                             <option value="twitter">Twitter</option>
                             <option value="facebook">Facebook</option>
                             <option value="linkedin">Linkedin</option>
                             <option value="google">Google</option>
                             <option value="youtube">Youtube</option>
                             <option value="instagram">Instagram</option>
                             <option value="flickr">Flickr</option>
                             <option value="skype">Skype</option>
                             <option value="yahoo">Yahoo</option>
                             <option value="pinterest">Pinterest</option>
	                         </select>
                            <span class="requerido">*</span></td>
                        </tr>
								<? /*<tr>
								   <td class="text_gral">Imagen</td>
								   <td class="text_gral">
								      <input type="file" name="imagen"/>
                              <br />
								      <span>Le sugerimos una imagen de 60 x 60 pixeles</span></td>
								</tr>*/ ?>
                        <tr>
                        	<td>Enlace</td>
                           <td><input name="enlace" type="text" style="width:300px;" maxlength="255"/></td>
                        </tr>
                        <tr>
                           <td class="text_gral">Orden</td>
                           <td class="text_gral"><input type="text" name="orden" style="width:50px;" onKeyUp="this.value=validarEntero(this.value);"/></td>
                        </tr>
                        <tr>
                        	<td>Estatus</td>
                           <td>
                           	<select name="estatus">
                              	<option value="activo">Activo</option>
                              	<option value="inactivo">Inactivo</option>                                 
                              </select>
                           </td>
                        </tr>
                        <tr>
                          <td><input type="hidden" name="action" value="send"/></td>
                          <td><input type="submit" class="link_5" value="Registro"/></td>
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