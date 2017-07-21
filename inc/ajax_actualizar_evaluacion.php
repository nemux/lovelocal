<?php
session_start();
$se_id_perfil=$_SESSION["s_id_perfil"];
$se_usuario_perfil=$_SESSION["s_usuario_perfil"];
$se_password_perfil=$_SESSION["s_password_perfil"];
//ini_set("display_errors","On");
include("../administrador/php/config.php");
include("../administrador/php/func.php");
include("../administrador/php/func_bd.php");
$errors=array();
if(empty($se_id_perfil) and empty($se_usuario_perfil) and empty($se_password_perfil)):
	$errors[]='<div class="error">Tu sesión ha finalizado. Es necesario que vuelvas a acceder</div>';
endif;
$p_id_evaluacion=$_POST["id_evaluacion"]*1;
if(!empty($se_id_perfil) and !empty($p_id_evaluacion) and empty($errors)):
	//Buscar detalle de la evaluacion
	$c_rec=buscar("cli.usuario
					,eva_per.evaluacion
					,eva_per.comentario
					,eva_per.cupon
					,eva_per.recompensa
					,eva_per.estatus"
					,"evaluaciones_perfiles eva_per
					LEFT OUTER JOIN
					clientes cli ON cli.id_cliente=eva_per.id_cliente"
					,"WHERE eva_per.id_evaluacion='".$p_id_evaluacion."' 
					AND eva_per.id_perfil='".$se_id_perfil."'");
	while($f_rec=$c_rec->fetch_assoc()):
		$cliente=cadena($f_rec["usuario"]);
		$evaluacion=cadena($f_rec["evaluacion"]);
		$comentario=cadena($f_rec["comentario"]);
		$cupon=cadena($f_rec["cupon"]);		
		$recompensa=cadena($f_rec["recompensa"]);
		$estatus=$f_rec["estatus"];
	endwhile;
	?>
   <link rel="stylesheet" href="../css/main.css" id="color-switcher-link">
	<style>
   #form_evaluaciones{display: block; margin:10px auto; /*background:rgba(0, 0, 0, 0.1);*/ border-radius: 10px; padding: 15px }
   .progress_evaluaciones{position:relative; width:100%; border: 1px solid #ddd; padding: 1px; border-radius: 3px; }
   .bar_evaluaciones{background-color:#03538E;width:0%; height:33px; border-radius: 3px; margin:0 !important;}
   .percent_evaluaciones{position:absolute;color:#FFFFFF !important;display:inline-block; top:3px; left:48%; }
   </style>   
   <form id="form_evaluaciones" action="../inc/ajax_evaluaciones_actualizar.php" method="post" enctype="multipart/form-data">
	<h3>Actualizar evaluación</h3>
	<div class="row">
		<div class="col-sm-2 col-md-2 col-lg-2">
			Cliente:
		</div>
		<div class="col-sm-10 col-md-10 col-lg-10">
			<?=$cliente?>
		</div>
	</div>
   <? /*
	<div class="row">
		<div class="col-sm-2 col-md-2 col-lg-2">
			Evaluación:
		</div>
		<div class="col-sm-10 col-md-10 col-lg-10" class="stars">
      	<a class="star-<?=$evaluacion?>" href="#"><?=$evaluacion?></a>
		</div>
	</div>
	*/
	?>   
	<div class="row">
		<div class="col-sm-2 col-md-2 col-lg-2">
			Cupón:
		</div>
		<div class="col-sm-10 col-md-10 col-lg-10" class="stars">
			<?=$cupon?>
		</div>
	</div>
   <div class="row">
		<div class="col-sm-2 col-md-2 col-lg-2">
			Recompensa:
		</div>
		<div class="col-sm-10 col-md-10 col-lg-10" class="stars">
			<?=$recompensa?>
		</div>
	</div>      
   <div class="row">
		<div class="col-sm-2 col-md-2 col-lg-2">
			Estatus
		</div>
		<div class="col-sm-10 col-md-10 col-lg-10">
         <select name="estatus">
         	<option value="En proceso" <? if($estatus=="En proceso"): ?> selected <? endif;?>>En proceso</option>
         	<option value="Cerrado" <? if($estatus=="Cerrado"): ?> selected <? endif;?>>Cerrado</option>
         </select>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-2 col-md-2 col-lg-2">
      	<input type="hidden" name="id_evaluacion" value="<?=$p_id_evaluacion?>">
			<input type="hidden" name="action_evaluaciones" value="send">
		</div>
		<div class="col-sm-10 col-md-10 col-lg-10">
			<button type="submit" id="form_evaluaciones_submit" name="form_evaluaciones_submit" class="theme_button">Actualizar evaluación</button>
		</div>
	</div>
	<div class="row">
      <div class="col-sm-2 col-md-2 col-lg-2">
      </div>
      <div class="col-sm-10 col-md-10 col-lg-10">
         <div class="progress_evaluaciones">
            <div class="bar_evaluaciones"></div>
            <div class="percent_evaluaciones">0%</div>
         </div>
         <div id="status_evaluaciones"></div>
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
