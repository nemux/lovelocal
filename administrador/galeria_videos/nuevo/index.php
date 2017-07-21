<?
session_start();
//ini_set("display_errors","On");
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
	$arreglo_respuestas=array();
	$p_action=isset($_POST['action']) ? $_POST['action'] : "";
	if($p_action=="send"):
		date_default_timezone_set('Mexico/General');
		$fechahora=date("YmdHis");
		$fecha_hora_registro=date("Y-m-d H:i:s");		
		$p_numero=$_POST['numero']*1;
		if($p_numero>0):
			for($con=1;$con<=$p_numero;$con++):
				$titulo='titulo'.$con;
				$orden='orden'.$con;
				$estatus='estatus'.$con;
				
				$p_id_seccion=$_POST["id_seccion"];
				$p_titulo=cadenabd($_POST[$titulo]);
				$p_enlace=cadenabd($_POST["enlace".$con]);
				$p_orden=$_POST[$orden]*1;
				$p_estatus=$_POST[$estatus];
				
				if(!empty($p_titulo) and
					!empty($p_estatus)
					):
					//Registrar
					$i_c=insertar("id_seccion
										,titulo
										,enlace
										,orden
										,estatus
										,fecha_hora_registro"
										,"videos_secciones"
										,"'".$p_id_seccion."'
										,'".$p_titulo."'
										,'".$p_enlace."'
										,".$p_orden."
										,'".$p_estatus."'
										,'".$fecha_hora_registro."'");
					if(!$i_c):
						$arreglo_respuestas[]='<div class="error">No fue posible registrar el video '.$con.'</div>';
					else:
						$arreglo_respuestas[count($arreglo_respuestas)]='<div class="exito">Video '.$con.' registrado exitosamente.</div>';
					endif;				
				else:
					$arreglo_respuestas[]='<div class="error">No se recibieron todos los datos requeridos.</div>';
				endif;
				unset($p_id_seccion,$p_titulo);
				unset($p_enlace,$p_orden);
				unset($p_estatus);
				unset($id_video);					
			endfor;
		endif;
	endif;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GALERÍA DE VIDEOSs - NUEVO</title>
<!-- Favicon -->
<link rel="shortcut icon" href="http://www.lovelocal.mx/images/favicon.png">

<link href="../../css/etiquetas.css" rel="stylesheet" type="text/css" />
<link href="../../css/form.css" rel="stylesheet" type="text/css" />
<link href="../../css/administrador.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../js/jquery.min.js"></script>
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
      <div>
      <?
		if(count($arreglo_respuestas)>0):
			foreach($arreglo_respuestas as $respuesta):
				?>
            <div class="alerta"><?=$respuesta?></div>
            <?
			endforeach;
		endif;
		?>
		<style>
      #form1{display: block; position:relative}
      #form1 .nicEdit-main{
         background-color:#FFFFFF;
      }
      </style>   
		<form action="./" method="post" enctype="multipart/form-data" name="form1" id="form1">
      <fieldset>
      <legend>Nuevo Video</legend>
                      <table border="0" cellpadding="3" cellspacing="1" width="80%" align="left" class="text_gral">
                        <tr>
                        	<td></td>
                           <td>
                              <input id="agregar_video" name="agregar_video" type="button" class="link_5" value="Agregar video" style="clear:both;" />
                           </td>
                        </tr>
                        <tr>
                        	<td colspan="2" align="left">
                              <div id="div_videos" style="position:relative;">
                              	<fieldset>
                                 <legend>Video 1</legend>
                                 <table border="0" cellpadding="3" cellspacing="1" width="100%" align="left" class="text_gral">
                                    <tr>
                                          <td>Sección</td>
                                          <td>
                                             <?
                                             $c_sec=buscar("id_seccion,seccion","secciones","WHERE estatus='activo' ORDER BY seccion");
                                             ?>
                                             <select name="id_seccion">
                                                <?
                                                if($c_sec->num_rows>0):
                                                   while($f_sec=$c_sec->fetch_assoc()):
                                                      $id_seccion=$f_sec["id_seccion"];
                                                      $seccion=cadena($f_sec["seccion"]);
                                                      ?>
                                                      <option value="<?=$id_seccion?>"><?=$seccion?></option>
                                                      <?
                                                      unset($id_seccion,$seccion);
                                                   endwhile;
                                                endif;
                                                ?>
                                                <option value="">Todas</option>
                                             </select>
                                             </td>
                                    </tr>
                                    <tr>
                                       <td>Video</td>
                                       <td><input type="text" name="titulo1" style="width:300px;" maxlength="255" required>*</td>
                                    </tr>
                                    <tr>
                                       <td>Enlace</td>
                                       <td>
                                       	<textarea name="enlace1" id="enlace1" style="width:600px;height:100px;"></textarea> Ej. https://www.youtube.com/watch?v=t8IO9Izi5xo
                                       </td>
                                    </tr>
                                    <tr>
                                       <td>Orden</td>
                                       <td>
                                          <input type="number" min="0" name="orden1" step="1" style="width:50px;"/>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td>Estatus</td>
                                       <td><select name="estatus1">
                                          <option value="activo">Activo</option>
                                          <option value="inactivo">Inactivo</option>
                                       </select>
                                       </td>
                                    </tr>
                                 </table>   
                                 </fieldset>
                              </div>
                           </td>
                        </tr>
                        <tr>
                        	<td width="20%"><input name="numero" id="numero" type="hidden" value="1"></td>
                           <td width="80%" colspan="2" class="info">* Requerido</td>
                        </tr>
                        <tr>
                           <td><input type="hidden" name="action" value="send"></td>
                           <td colspan="2"><input type="submit" 
                                       name="button" 
                                       id="button" 
                                       value="Registro">
                           </td>
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
   <script src="../../../assets/nicEdit/nicEdit.js" type="text/javascript"></script>
   <script>
		jQuery(document).ready(function(){
			new nicEditor({buttonList:['bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','image','link','unlink']}).panelInstance("enlace1");
			jQuery("#agregar_video").click(function(event){
				var numero=(new Number(jQuery("#numero").val())*1)+1;
				if(numero>0 && (jQuery("#tbl_video"+numero).length)==0){
					url ="../agregar_video.php";
					var posting = jQuery.post(url,{numero:numero});
					posting.done(function(data){
						jQuery("#div_videos").append(data);
						jQuery("#numero").val(numero);
						new nicEditor({buttonList:['bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','image','link','unlink']}).panelInstance("enlace"+numero);
					});
				}
			});
			jQuery("#form1").submit(function(event){
				//event.preventDefault();
				var numero=new Number(jQuery("#numero").val())*1;
				if(numero>0){
					for(var con=1;con<=numero;con++){
						nicEditors.findEditor("enlace"+con).saveContent();
					}
				}
				jQuery("#form1").submit();
			});
		});	
      </script>
   </body>
   </html>
   <?
endif;
?>