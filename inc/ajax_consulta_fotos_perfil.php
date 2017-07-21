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
	//Buscar fotos de perfil
	$c_art=buscar("id_foto
						,titulo
						,foto
						,fecha_hora_registro"
						,"fotos_perfiles"
						,"WHERE 	id_perfil=".$se_id_perfil."
						ORDER BY fecha_hora_registro DESC");
	if($c_art->num_rows>0):
		?>
	   <h3>Mis fotos</h3>
      <div id="isotope_container" class="isotope masonry-layout row ls_fondo4">
      <?
		while($f_art=$c_art->fetch_assoc()):
			$id_foto=$f_art["id_foto"];
			$titulo=cadena($f_art["titulo"]);
			$foto=$f_art["foto"];
			$fecha_registro=substr($f_art["fecha_hora_registro"],0,10);
			$hora_registro=substr($f_art["fecha_hora_registro"],11);
			?>
			<article class="isotope-item col-lg-3 col-md-4 col-sm-6 col-xs-12 post format-standard">
				<?
            if(!empty($foto) and file_exists("../administrador/galeria_fotos/images/".$foto)):
               ?>
               <div class="entry-thumbnail">                  
               	<? /*
                  <div class="entry-meta-corner">
                    <span class="date">
                        <time datetime="<?=$fecha_registro?>T<?=$hora_registro?>+00:00" class="entry-date">
                            <strong>03</strong>
                            March
                        </time>
                    </span>

                    <span class="comments-link">
                        <a href="../detalle_foto/#comments">
                            <strong>
                                <i class="rt-icon2-chat"></i> 5
                            </strong>
                        </a>
                    </span>
                   </div>                  
						 */ ?>
                  <img src="../administrador/galeria_fotos/images/<?=$foto?>" alt="<?=$titulo?>">
               </div>                  
               <?
            endif;
            ?>
            <div class="post-content">
                <div class="entry-content">
                    <header class="entry-header">
                        <div class="entry-meta">
                            <span class="categories-links">
                                <a class="accion_foto" accion="editar" id_foto="<?=$id_foto?>" style="cursor:pointer"><i class="rt-icon2-edit highlight2"></i>Editar</a>
                                <a class="accion_foto" accion="eliminar" id_foto="<?=$id_foto?>" style="cursor:pointer"><i class="rt-icon2-delete-outline highlight2"></i>Eliminar</a>
                            </span>
                        </div>
                        <!-- .entry-meta --> 
                    </header>
                    <!-- .entry-header -->
                </div><!-- .entry-content -->
            </div><!-- .post-content -->
        </article>
        <!-- .post -->          
         <?
			unset($id_foto,$titulo,$foto,$fecha_registro,$hora_registro);
		endwhile;
		?>
      </div>
      <?
	endif;
endif;
?>