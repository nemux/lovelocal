<?php
session_start();
$se_id_perfil=$_SESSION["s_id_perfil"];
$se_usuario_perfil=$_SESSION["s_usuario_perfil"];
$se_password_perfil=$_SESSION["s_password_perfil"];
ini_set("display_errors","On");
include("../administrador/php/config.php");
include("../administrador/php/func.php");
include("../administrador/php/func_bd.php");
$errors=array();
if(empty($se_id_perfil) and empty($se_usuario_perfil) and empty($se_password_perfil)):
	$errors[]='<div class="error">Tu sesión ha finalizado. Es necesario que vuelvas a acceder</div>';
endif;
$p_id_recompensa=$_POST["id_recompensa"]*1;
if(!empty($se_id_perfil) and !empty($p_id_recompensa) and empty($errors)):
	//Buscar detalle de la recompensa
	$c_rec=buscar("recompensa,estatus","recompensas_perfiles","WHERE id_recompensa='".$p_id_recompensa."' AND id_perfil='".$se_id_perfil."'");
	while($f_rec=$c_rec->fetch_assoc()):
		$recompensa=cadena($f_rec["recompensa"]);
		$estatus=$f_rec["estatus"];
	endwhile;
	?>
	<style>
   #form_recompensas{display: block; margin:10px auto; /*background:rgba(0, 0, 0, 0.1);*/ border-radius: 10px; padding: 15px }
   .progress_recompensas{position:relative; width:100%; border: 1px solid #ddd; padding: 1px; border-radius: 3px; }
   .bar_recompensas{background-color:#03538E;width:0%; height:33px; border-radius: 3px; margin:0 !important;}
   .percent_recompensas{position:absolute;color:#FFFFFF !important;display:inline-block; top:3px; left:48%; }
   </style>   
   <form id="form_recompensas" action="../inc/ajax_recompensas_actualizar.php" method="post" enctype="multipart/form-data">
	<h3>Actualizar recompensa</h3>
	<div class="row">
		<div class="col-sm-2 col-md-2 col-lg-2">
			Recompensa:
		</div>
		<div class="col-sm-10 col-md-10 col-lg-10">
			<input type="text" name="recompensa" value="<?=$recompensa?>" maxlength="255" required="required"> *
		</div>
	</div>
   <div class="row">
		<div class="col-sm-2 col-md-2 col-lg-2">
			Estatus
		</div>
		<div class="col-sm-10 col-md-10 col-lg-10">
         <select name="estatus">
         	<option value="activo" <? if($estatus=="activo"): ?> selected <? endif;?>>Activo</option>
         	<option value="inactivo" <? if($estatus=="inactivo"): ?> selected <? endif;?>>Inactivo</option>
         </select>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-2 col-md-2 col-lg-2">
      	<input type="hidden" name="id_recompensa" value="<?=$p_id_recompensa?>">
			<input type="hidden" name="action_recompensas" value="send">
		</div>
		<div class="col-sm-10 col-md-10 col-lg-10">
			<button type="submit" id="form_recompensas_submit" name="form_recompensas_submit" class="theme_button">Actualizar recompensa</button>
		</div>
	</div>
	<div class="row">
      <div class="col-sm-2 col-md-2 col-lg-2">
      </div>
      <div class="col-sm-10 col-md-10 col-lg-10">
         <div class="progress_recompensas">
            <div class="bar_recompensas"></div>
            <div class="percent_recompensas">0%</div>
         </div>
         <div id="status_recompensas"></div>
      </div>
   </div>   
   </form>
	<?
endif;
if(!empty($errors)):
	foreach($errors as $error):
		echo $error."<br>";
	endforeach;
endif;
