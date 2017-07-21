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
					,pro_cli.cupon
					,pro_cli.promocion
					,pro_per.imagen
					,pro_per.descripcion_corta
					,pro_cli.estatus"
					,"promociones_clientes pro_cli
					LEFT OUTER JOIN
						clientes cli ON cli.id_cliente=pro_cli.id_cliente
					LEFT OUTER JOIN
						promociones_perfiles pro_per
					ON pro_per.id_promocion=pro_cli.id_promocion"
					,"WHERE pro_cli.id_registro='".$p_id_cupon."' 
					AND pro_cli.id_perfil='".$se_id_perfil."'");
	while($f_rec=$c_rec->fetch_assoc()):
		$cliente=cadena($f_rec["usuario"]);
		$cupon=cadena($f_rec["cupon"]);		
		$promocion=cadena($f_rec["promocion"]);
		$imagen_promocion=$f_rec["imagen"];
		$descripcion_corta_promocion=cadena($f_rec["descripcion_corta"]);
		$estatus=$f_rec["estatus"];
	endwhile;
	?>
   <link rel="stylesheet" href="../css/main.css" id="color-switcher-link">
	<style>
   #form_cupones_promocion{display: block; margin:10px auto; /*background:rgba(0, 0, 0, 0.1);*/ border-radius: 10px; padding: 15px }
   .progress_cupones_promocion{position:relative; width:100%; border: 1px solid #ddd; padding: 1px; border-radius: 3px; }
   .bar_cupones_promocion{background-color:#03538E;width:0%; height:33px; border-radius: 3px; margin:0 !important;}
   .percent_cupones_promocion{position:absolute;color:#FFFFFF !important;display:inline-block; top:3px; left:48%; }
   </style>   
   <form id="form_cupones_promocion" action="../inc/ajax_promociones_asignadas_actualizar.php" method="post" enctype="multipart/form-data">
	<h3>Actualizar cupón de promoción</h3>
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
			Promoción:
		</div>
		<div class="col-sm-10 col-md-10 col-lg-10" class="stars">
			<? echo $promocion;
			if(!empty($imagen_promocion) and file_exists("../administrador/promociones/images/".$imagen_promocion)):
				?>
            <br>
				<img src="../administrador/promociones/images/<?=$imagen_promocion?>" style="max-width:300px;">
				<?
			endif;
			if(!empty($descripcion_corta_promocion)):
				?>
            <br>
            <?
				echo $descripcion_corta_promocion;
			endif;
			?>
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
			<input type="hidden" name="action_cupones_promocion" value="send">
		</div>
		<div class="col-sm-10 col-md-10 col-lg-10">
			<button type="submit" id="form_cupones_promocion_submit" name="form_cupones_promocion_submit" class="theme_button">Actualizar cupón de promoción</button>
		</div>
	</div>
	<div class="row">
      <div class="col-sm-2 col-md-2 col-lg-2">
      </div>
      <div class="col-sm-10 col-md-10 col-lg-10">
         <div class="progress_cupones_promocion">
            <div class="bar_cupones_promocion"></div>
            <div class="percent_cupones_promocion">0%</div>
         </div>
         <div id="status_cupones_promocion"></div>
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
