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
$p_id_cupon=$_POST["id_cupon"]*1;
if(!empty($se_id_perfil) and !empty($p_id_cupon) and empty($errors)):
	//Buscar detalle del cupon
	$c_rec=buscar("cli.usuario
					,reg_cli.cupon
					,reg_cli.regalo
					,reg_cli.estatus"
					,"regalos_clientes reg_cli
					LEFT OUTER JOIN
					clientes cli ON cli.id_cliente=reg_cli.id_cliente
					LEFT OUTER JOIN
					regalos_perfiles reg
					ON reg.id_regalo=reg_cli.id_regalo"
					,"WHERE reg_cli.id_registro='".$p_id_cupon."' 
					AND reg.id_perfil='".$se_id_perfil."'");
	while($f_rec=$c_rec->fetch_assoc()):
		$cliente=cadena($f_rec["usuario"]);
		$evaluacion=cadena($f_rec["evaluacion"]);
		$comentario=cadena($f_rec["comentario"]);
		$cupon=cadena($f_rec["cupon"]);		
		$regalo=cadena($f_rec["regalo"]);
		$estatus=$f_rec["estatus"];
	endwhile;
	?>
   <link rel="stylesheet" href="../css/main.css" id="color-switcher-link">
	<style>
   #form_cupones{display: block; margin:10px auto; /*background:rgba(0, 0, 0, 0.1);*/ border-radius: 10px; padding: 15px }
   .progress_cupones{position:relative; width:100%; border: 1px solid #ddd; padding: 1px; border-radius: 3px; }
   .bar_cupones{background-color:#03538E;width:0%; height:33px; border-radius: 3px; margin:0 !important;}
   .percent_cupones{position:absolute;color:#FFFFFF !important;display:inline-block; top:3px; left:48%; }
   </style>   
   <form id="form_cupones" action="../inc/ajax_cupones_actualizar.php" method="post" enctype="multipart/form-data">
	<h3>Actualizar cupón</h3>
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
			Regalo:
		</div>
		<div class="col-sm-10 col-md-10 col-lg-10" class="stars">
			<?=$regalo?>
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
      	<input type="hidden" name="id_cupon" value="<?=$p_id_cupon?>">
			<input type="hidden" name="action_cupones" value="send">
		</div>
		<div class="col-sm-10 col-md-10 col-lg-10">
			<button type="submit" id="form_cupones_submit" name="form_cupones_submit" class="theme_button">Actualizar cupón</button>
		</div>
	</div>
	<div class="row">
      <div class="col-sm-2 col-md-2 col-lg-2">
      </div>
      <div class="col-sm-10 col-md-10 col-lg-10">
         <div class="progress_cupones">
            <div class="bar_cupones"></div>
            <div class="percent_cupones">0%</div>
         </div>
         <div id="status_cupones"></div>
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
