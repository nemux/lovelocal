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
	//Buscar artículos de perfil
	$c_art=buscar("art.id_articulo
						,art.articulo
						,art.imagen
						,art.descripcion_corta
						,art.descripcion_completa
						,art.fecha_hora_registro"
						,"articulos_perfiles art"
						,"WHERE 	art.id_perfil=".$se_id_perfil."
						ORDER BY art.fecha_hora_registro DESC");
	if($c_art->num_rows>0):
		?>
	   <h3>Mis artículos</h3>
      <div id="isotope_container" class="isotope masonry-layout row ls_fondo4">
      <?
		while($f_art=$c_art->fetch_assoc()):
			$id_articulo=$f_art["id_articulo"];
			$articulo=cadena($f_art["articulo"]);
			$imagen=$f_art["imagen"];
			$descripcion_corta=cadena($f_art["descripcion_corta"]);
			$descripcion_completa=cadena($f_art["descripcion_completa"]);
			$fecha_registro=substr($f_art["fecha_hora_registro"],0,10);
			$hora_registro=substr($f_art["fecha_hora_registro"],11);
			?>
			<article class="isotope-item col-lg-3 col-md-4 col-sm-6 col-xs-12 post format-standard">
				<?
            if(!empty($imagen) and file_exists("../administrador/articulos/images/".$imagen)):
               ?>
               <div class="entry-thumbnail">                  
                  <img src="../administrador/articulos/images/<?=$imagen?>" alt="<?=$articulo?>">
               </div>                  
               <?
            endif;
            ?>
            <div class="post-content">
                <div class="entry-content">
                    <header class="entry-header">
                        <h3 class="entry-title">
                            <a href="../detalle-articulo/?art=<?=$id_articulo?>&articulo=<?=$articulo?>" rel="bookmark"><?=$articulo?></a>
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
                                <a class="accion_articulo" accion="editar" id_articulo="<?=$id_articulo?>" style="cursor:pointer"><i class="rt-icon2-edit highlight2"></i>Editar</a>
                                <a class="accion_articulo" accion="eliminar" id_articulo="<?=$id_articulo?>" style="cursor:pointer"><i class="rt-icon2-delete-outline highlight2"></i>Eliminar</a>
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
			unset($id_articulo,$articulo,$imagen,$descripcion_corta,$fecha_registro,$hora_registro);
		endwhile;
		?>
      </div>
      <?
	endif;
endif;
?>