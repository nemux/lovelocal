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
	die("Tu sesión ha finalizado. Es necesario que vuelvas a acceder");
else:
	//Buscar promociones de perfil
	$c_pro=buscar("pro.id_promocion
						,pro.promocion
						,pro.imagen
						,pro.descripcion_corta
						,pro.descripcion_completa
						,pro.fecha_hora_registro
						,pro.estatus"
						,"promociones_perfiles art"
						,"WHERE 	pro.id_perfil=".$se_id_perfil."
						ORDER BY pro.fecha_hora_registro DESC");
	if($c_pro->num_rows>0):
		?>
	   <h3>Mis promociones</h3>
      <div id="isotope_container" class="isotope masonry-layout row ls_fondo4">
      <?
		while($f_pro=$c_pro->fetch_assoc()):
			$id_promocion=$f_pro["id_promocion"];
			$promocion=cadena($f_pro["promocion"]);
			$imagen=$f_pro["imagen"];
			$descripcion_corta=cadena($f_pro["descripcion_corta"]);
			$descripcion_completa=cadena($f_pro["descripcion_completa"]);
			$fecha_registro=substr($f_pro["fecha_hora_registro"],0,10);
			$hora_registro=substr($f_pro["fecha_hora_registro"],11);
			$estatus=$f_ar["estatus"];
			?>
			<article class="isotope-item col-lg-3 col-md-4 col-sm-6 col-xs-12 post format-standard">
				<?
            if(!empty($imagen) and file_exists("../administrador/promociones/images/".$imagen)):
               ?>
               <div class="entry-thumbnail">                  
                  <img src="../administrador/promociones/images/<?=$imagen?>" alt="<?=$promocion?>">
               </div>                  
               <?
            endif;
            ?>
            <div class="post-content">
                <div class="entry-content">
                    <header class="entry-header">
                        <h3 class="entry-title">
                            <a href="#" rel="bookmark"><?=$promocion?></a>
                        </h3>
                        <div class="entry-meta">
                        	<?
									/*
                            <span class="author">
                                <i class="rt-icon2-user2 highlight2"></i>
                                by 
                                <a href="blog-full.html">Admin</a>
                            </span>
									 */
									 ?>
                            <span class="categories-links">
                                <a class="accion_promocion" accion="editar" id_promocion="<?=$id_promocion?>" style="cursor:pointer"><i class="rt-icon2-edit highlight2"></i>Editar</a>
                                <a class="accion_promocion" accion="eliminar" id_promocion="<?=$id_promocion?>" style="cursor:pointer"><i class="rt-icon2-delete-outline highlight2"></i>Eliminar</a>
                            </span>
                        </div>
                        <!-- .entry-meta --> 
                    </header>
                    <!-- .entry-header -->
							<?
							if(!empty($descripcion_corta)):
								?>
                        <p><?=$descripcion_corta?></p>
                        <?
							endif;
							?>
                </div><!-- .entry-content -->
            </div><!-- .post-content -->
        </article>
        <!-- .post -->          
         <?
			unset($id_promocion,$promocion,$imagen,$descripcion_corta,$fecha_registro,$hora_registro,$estatus);
		endwhile;
		?>
      </div>
      <?
	endif;
endif;
?>