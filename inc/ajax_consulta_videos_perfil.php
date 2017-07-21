<?php
session_start();
$se_id_perfil=$_SESSION["s_id_perfil"];
$se_usuario_perfil=$_SESSION["s_usuario_perfil"];
$se_password_perfil=$_SESSION["s_password_perfil"];
ini_set("display_errors","On");
include("../administrador/php/config.php");
include("../administrador/php/func.php");
include("../administrador/php/func_bd.php");
include("../administrador/includes/phpmailer/class.phpmailer.php");
$errors=array();
if(empty($se_id_perfil) and empty($se_usuario_perfil) and empty($se_password_perfil)):
	die("Tu sesión ha finalizado. Es necesario que vuelvas a acceder");
else:
	//Buscar videos de perfil
	$c_vid=buscar("id_video
						,titulo
						,video
						,fecha_hora_registro"
						,"videos_perfiles"
						,"WHERE 	id_perfil=".$se_id_perfil."
						ORDER BY fecha_hora_registro DESC");
	if($c_vid->num_rows>0):
		?>
	   <h3>Mis videos</h3>
      <div id="videos" class="isotope masonry-layout row ls_fondo4">
      <?
		while($f_vid=$c_vid->fetch_assoc()):
			$id_video=$f_vid["id_video"];
			$titulo=cadena($f_vid["titulo"]);
			$video=cadena($f_vid["video"]);
			$fecha_registro=substr($f_vid["fecha_hora_registro"],0,10);
			$hora_registro=substr($f_vid["fecha_hora_registro"],11);
			$id_youtube=id_youtube($video);
			?>
         <article class="isotope-item col-lg-4 col-md-4 col-sm-6 col-xs-12 post format-standard">
				<?
            if(!empty($video) and !empty($id_youtube)):
               ?>
               <div class="entry-thumbnail">                  
	               <iframe width="360" height="201" src="https://www.youtube.com/embed/<?=$id_youtube?>" frameborder="0" allowfullscreen></iframe>
               </div>                  
               <?
            endif;
            ?>
            <div class="post-content">
                <div class="entry-content">
                    <header class="entry-header"><?
									/*
                        <h3 class="entry-title">
                            <a href="../detalle_video/?art=<?=$id_video?>" rel="bookmark"><?=$video?></a>
                        </h3>
                        <div class="entry-meta">
                        	
                            <span class="author">
                                <i class="rt-icon2-user2 highlight2"></i>
                                by 
                                <a href="blog-full.html">Admin</a>
                            </span>
									 */
									 ?>
                            <span class="categories-links">
                                <a class="accion_video" accion="editar" id_video="<?=$id_video?>" style="cursor:pointer"><i class="rt-icon2-edit highlight2"></i>Editar</a>
                                <a class="accion_video" accion="eliminar" id_video="<?=$id_video?>" style="cursor:pointer"><i class="rt-icon2-delete-outline highlight2"></i>Eliminar</a>
                            </span>
                            <? /*
                        </div>
                        <!-- .entry-meta -->  */ ?>
                    </header>
                    <!-- .entry-header -->
                </div><!-- .entry-content -->
            </div><!-- .post-content -->
        </article>
        <!-- .post -->          
         <?
			unset($id_video,$titulo,$video,$fecha_registro,$hora_registro);
		endwhile;
		?>
      </div>
      <?
	endif;
endif;
?>