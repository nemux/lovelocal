<?
session_start();
ini_set("display_errors","On");
$se_id_cliente=$_SESSION["s_id_cliente"];
$se_id_facebook=isset($_SESSION["s_id_facebook"]) ? $_SESSION["s_id_facebook"] : "";
$se_email_cliente=isset($_SESSION["s_email_cliente"]) ? $_SESSION["s_email_cliente"] : "";
$se_usuario_cliente=$_SESSION["s_usuario_cliente"];
$se_password_cliente=$_SESSION["s_password_cliente"];
include("../administrador/php/config.php");
include("../administrador/php/func.php");
include("../administrador/php/func_bd.php");
$p_id_perfil=$_POST["id_perfil"]*1;
if(!empty($p_id_perfil)
	):
	/*
	$promociones_pendientes=0;
	//Consultar promociones pendientes de este perfil
	$c_pro_pen=buscar("COUNT(id_registro) AS promociones_pendientes","promociones_clientes","WHERE id_perfil='".$p_id_perfil."' AND id_cliente='".$se_id_cliente."' AND estatus='En proceso'");
	while($f_pro_pen=$c_pro_pen->fetch_assoc()):
		$promociones_pendientes=$f_pro_pen["promociones_pendientes"];
	endwhile;
	$c_pro_pen->free();
	*/
	//Consultar promociones
	$c_pro=buscar("pro.id_promocion,pro.promocion,pro.imagen,pro.descripcion_corta","promociones_perfiles pro","WHERE pro.id_perfil='".$p_id_perfil."' ORDER BY pro.id_promocion DESC",false);
	if($c_pro->num_rows>0):
		while($f_pro=$c_pro->fetch_assoc()):
			$id_promocion=$f_pro["id_promocion"];
			$promocion=cadena($f_pro["promocion"]);
			$imagen_promocion=$f_pro["imagen"];
			$descripcion_corta_promocion=cadena($f_pro["descripcion_corta"]);
			?>
			<article class="isotope-item col-lg-6 col-md-6 col-sm-6 col-xs-12 post format-standard">
				<?
				if(!empty($imagen_promocion) and file_exists("../administrador/promociones/images/".$imagen_promocion)):
					?>
					<div class="entry-thumbnail">
						 <a href="../administrador/promociones/images/<?=$imagen_promocion?>" class="zoom first" title="<?=$promocion?>" data-gal="prettyPhoto[promocion]">
							 <img src="../administrador/promociones/images/<?=$imagen_promocion?>" class="attachment-shop_thumbnail" alt="<?=$promocion?>">
						 </a>
					</div>
					<?
				endif;
				?>
				<div class="post-content">
					<div class="entry-content">
						<header class="entry-header">
								<?
								if(!empty($promocion)):
									?>
									<h4 class="entry-title">
										 <?=$promocion?>
									</h4>
									<?
								endif;
								?>												
						</header>
					  <!-- .entry-header -->                                                
						<?
						if(!empty($descripcion_corta_promocion) and $descripcion_corta_promocion!="<br>"):
							?>
							<p><?=$descripcion_corta_promocion?></p>
							<?
						endif;
						if((!empty($se_id_cliente) and !empty($se_usuario_cliente) and !empty($se_password_cliente) /*and empty($promociones_pendientes)*/) or
							(!empty($se_id_cliente) and !empty($se_id_facebook) and !empty($se_email_cliente) /*and empty($promociones_pendientes)*/)
							):
							/*
							$c_pro_cli=buscar("COUNT(id_registro) AS total_promociones","promociones_clientes","WHERE id_perfil='".$p_id_perfil."' AND id_cliente='".$se_id_cliente."' AND id_promocion='".$id_promocion."'");
							while($f_pro_cli=$c_pro_cli->fetch_assoc()):
								$total_promociones=$f_pro_cli["total_promociones"];
							endwhile;
							if(empty($total_promociones)):																  
							*/
								?>
								<a class="theme_button divider_20 descarga_promocion" id_perfil="<?=$p_id_perfil?>" id_promocion="<?=$id_promocion?>" href="#">Descarga esta promoción</a>
								<?
								/*
							endif;
							$c_pro_cli->free();
							unset($total_promociones);
							*/
					  endif;
					  ?>
					 </div><!-- .entry-content -->
				</div><!-- .post-content -->
			</article>
			<!-- .post -->                         
			<?
			unset($id_promocion,$promocion,$imagen_promocion,$descripcion_corta_promocion);
		endwhile;
		//unset($promociones_pendientes);
	endif; 
	$c_pro->free();
else:
	?>
   <div class="alert alert-warning">No se recibieron los parámetros completos.</div>
   <?
endif;