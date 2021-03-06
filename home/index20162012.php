<?php
error_reporting(0);
session_start();
$se_id_cliente=$_SESSION["s_id_cliente"];
$se_id_facebook=isset($_SESSION["s_id_facebook"]) ? $_SESSION["s_id_facebook"] : "";
$se_email_cliente=isset($_SESSION["s_email_cliente"]) ? $_SESSION["s_email_cliente"] : "";
$se_usuario_cliente=$_SESSION["s_usuario_cliente"];
$se_password_cliente=$_SESSION["s_password_cliente"];
$se_id_perfil=isset($_SESSION["s_id_perfil"]) ? $_SESSION["s_id_perfil"] : "";
$se_usuario_perfil=isset($_SESSION["s_usuario_perfil"]) ? $_SESSION["s_usuario_perfil"] : "";
$se_password_perfil=isset($_SESSION["s_password_perfil"]) ? $_SESSION["s_password_perfil"] : "";
include_once("../administrador/php/config.php");
include_once("../administrador/php/func.php");
include_once("../administrador/php/func_bd.php");
?>
<!DOCTYPE html> <html class="no-js"> 
<head> 
<title>Home - ZiiKFOR</title> 
<!-- Favicon -->
<link rel="shortcut icon" href="http://www.ziikfor.com/images/favicon.png">
<meta charset="utf-8"><!--[if IE]> <meta http-equiv="X-UA-Compatible" content="IE=edge"><![endif]--> 
<meta name="description" content=""> 
<meta name="viewport" content="width=device-width, initial-scale=1"> 
<link rel="stylesheet" href="../css/bootstrap.min.css">
<link rel="stylesheet" href="../css/main.css" id="color-switcher-link">
<link rel="stylesheet" href="../css/animations.css">
<link rel="stylesheet" href="../css/fonts.css">
<script src="../js/vendor/modernizr-2.6.2.min.js"></script>
<!--[if lt IE 9]> <script src="js/vendor/html5shiv.min.js"></script> <script src="js/vendor/respond.min.js"></script><![endif]
<script type='text/javascript' data-cfasync='false' src='//dsms0mj1bbhn4.cloudfront.net/assets/pub/shareaholic.js' data-shr-siteid='33ffcebf88ef9cd321e5784d56f7e74f' async='async'></script>-->
<script type='text/javascript' data-cfasync='false' src='//dsms0mj1bbhn4.cloudfront.net/assets/pub/shareaholic.js' data-shr-siteid='b62717da79586728048c38b77c540a91' async='async'></script>

</head>
<body><!--[if lt IE 9]> <div class="bg-danger text-center">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/" class="highlight">upgrade your browser</a> to improve your 
experience.</div><![endif]-->
<div class="boxed pattern8" id="canvas">
	<div class="container" id="box_wrapper">
   <?php
	include_once("../inc/header.php");
	?>
	<section id="mainteasers" class="section_padding_0 columns_padding_0 table_section table_section_lg">
    <div class="container-fluid">
        <div class="row">
            
            <div class="col-lg-8 bg_teaser after_cover color_bg_2" style="background:none;">
            	<?php
					$c_per=buscar("per.id_perfil
										,per.local
										,per.imagen
										,(SELECT(
											SUM(eva_per.evaluacion) / COUNT(eva_per.id_evaluacion)
											)
										FROM evaluaciones_perfiles eva_per
										WHERE eva_per.id_perfil=per.id_perfil) AS promedio_evaluacion"
										,"perfiles per"
										,"WHERE per.estatus='activo' AND mostrar_home='si' ORDER BY per.id_perfil DESC");
					if($c_per->num_rows>0):
						?>
                  <section class="mainslider ls">
                  	<div class="flexslider">
								<ul class="slides">
                       		<?
									while($f_per=$c_per->fetch_assoc()):
										$id_perfil=$f_per["id_perfil"];
										$local_perfil=cadena($f_per["local"]);
										$imagen_perfil=$f_per["imagen"];
										$promedio_evaluacion_perfil=$f_per["promedio_evaluacion"];
										?>
                              <li>
                              	<?
											if(!empty($imagen_perfil) and file_exists("../administrador/perfiles/images/".$imagen_perfil)):
												?>
												<img src="../administrador/perfiles/images/<?=$imagen_perfil?>" alt="<?=$perfil?>">
                                    <?
											endif;
											?>
                                  <div class="container">
                                       <div class="col-sm-12">
                                        <div class="slide_description_wrapper">
                                          <? /*
                                            <div class="slide_description">
                                                <div class="azul"> 
                                                    <div data-animation="fadeInRight">
                                                      <a href="#">EL GLOTÓN</a>
                                                     </div>
                                                </div>
                                            </div>
                                            */
                                            ?>
                                            <div class="slide_description">
                                                <div class="negro"> 
                                                   <div data-animation="fadeInRight">
                                                   	<?=$local_perfil?><br>
                                                      <?
																		if(!empty($promedio_evaluacion_perfil)):
																			?>
                                                         <span>Calificación <?=$promedio_evaluacion_perfil?> de 5 estrellas</span>
                                                         <?
																		endif;
																		?>
                                                      <a id="linkslide" href="../perfil/?per=<?=$id_perfil?>&perfil=<?=$local_perfil?>">
                                                         Ir al perfil
                                                      </a> 
                                                   </div>
                                                </div>
                                            </div>
                                        </div>
												</div>
		                           </div>
                              </li>
                              <?
										unset($id_perfil,$local_perfil,$imagen_nota,$promedio_evaluacion_perfil);
									endwhile;
									$c_per->free();
									?>
                          </ul>
                      </div> <!-- eof flexslider -->
                  </section>
                  <?
					endif;
					?>
            </div>
            <!--Buscador-->
            <div class="col-lg-4 searchhome bckziikfor">
                <div class="teaser_content media">
                    <div class="media-body">
                        <form class="order-form text-center" id="order_form" action="../resultado_busqueda" method="get">
                            <div class="form-group">
                                <label for="buscar">Nombre</label>
                                <input type="text" class="form-control" id="buscar" name="buscar" placeholder="¿Qué estás buscando?" required>
                            </div>
                            <div class="form-group">
                                <label for="lugar">Lugar</label>
                                <input type="text" class="form-control" id="lugar" name="lugar" placeholder="¿En dónde?">
                                <!--
                                <select class="form-control" name="department" id="department" placeholder="¿En dónde?">
                                    <option></option>
                                </select>
                                -->
                            </div>
                            <button type="submit" class="theme_button">ZiiKIT!</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?
/*$c_not=buscar("nota.id_nota,nota.id_seccion,sec.seccion,nota.nota,nota.imagen,nota.descripcion_corta","notas_editoriales nota LEFT OUTER JOIN secciones sec ON sec.id_seccion=nota.id_seccion","WHERE nota.estatus='activo' ORDER BY nota.orden DESC LIMIT 6");*/
$c_not=buscar("nota.fecha_hora_registro, nota.id_nota,nota.id_seccion,sec.seccion,nota.nota,nota.imagen,nota.descripcion_corta","notas_editoriales nota LEFT OUTER JOIN secciones sec ON sec.id_seccion=nota.id_seccion","WHERE nota.estatus='activo' ORDER BY nota.id_nota DESC LIMIT 6");
$finot=$c_not->num_rows;
if($finot>0):
	?>
   <section class="ls section_padding_10 topmargin_20">
      <div class="container">
      <div class="col-sm-10 homepage">
      	<?
			$col_not=0;
			$con_not=0;
			while($f_not=$c_not->fetch_assoc()):
				$col_not++;
				$con_not++;
				$id_nota=$f_not["id_nota"];
				$id_seccion_nota=$f_not["id_seccion"];
				$seccion_nota=cadena($f_not["seccion"]);
				$nota=cadena($f_not["nota"]);
				$imagen_nota=$f_not["imagen"];
        $fecha=$f_not["fecha_hora_registro"];
        $date=date_create($fecha);
        $date = date_format($date,"j M, Y");

				$descripcion_corta_nota=cadena($f_not["descripcion_corta"]);
				if($col_not==1):
					?>
               <div class="row">
               <?
				endif;
				?>
               <div class="col-sm-6">
               	<?
						if(!empty($imagen_nota) and file_exists("../administrador/notas_editoriales/images/".$imagen_nota)):
							?>
                     <a class="enlace imghome" href="../nota_editorial/?not=<?=$id_nota?>&nota=<?=$nota?>">
	                  <img src="../administrador/notas_editoriales/images/<?=$imagen_nota?>" alt="<?=$nota?>">
                     </a>
                     <?
						endif;
            ?>
            <div class="contenthome">
            <?php
						if(!empty($nota)):
							?>
	                  <h4 class="topmargin_10"><?=$nota?></h4>
                     <?
						endif;
            if(!empty($date)):
              ?>
                    <p class="datehome"><?=$date?></p>
                     <?
            endif;
						if(!empty($descripcion_corta_nota)):
							?>
                     <p class="deschome"><?=$descripcion_corta_nota?> ...</p>
                     <?
						endif;
						?>
                  <!--<div class="text-right">
	                  <a class="enlace" href="../nota_editorial/?not=<?=$id_nota?>&nota=<?=$nota?>">Ver más...</a>                  
                  </div>-->
                  <?
						if(!empty($id_seccion_nota) and !empty($seccion_nota)):
							?>
                     <!--<div class="text-center topmargin_10">
                     <a class="theme_button button2" href="../seccion/?sec=<?=$id_seccion_nota?>&seccion=<?=$seccion_nota?>"><?=$seccion_nota?></a>
                     </div>-->
                     <?
						endif;
						?>
               </div>
               </div>
            <?
				if($col_not==2 or $con_not==$finot):
					?>
	            </div>
               <?
					$col_not=0;
				endif;
				unset($id_nota,$id_seccion_nota,$seccion_nota,$nota,$imagen_nota,$descripcion_corta_nota);
			endwhile
			?>
      </div>
      <div class="col-sm-2">
      <a href="https://www.facebook.com/ziikfor/?fref=ts" target="_blank"><img src="../img/facebook.png"></a>
      <br /><br />
      <!--Promociones-->
      <?php
                    
                //Buscar promociones
                              $c_pro=buscar("pro.id_perfil,pro.id_promocion,pro.promocion,pro.imagen,pro.descripcion_corta","promociones_perfiles pro","WHERE estatus='Activo' ORDER BY RAND() limit 7",false);
                              if($c_pro->num_rows>0):
                                 ?>
                                 <!--<h3 class="bottommargin_10 topmargin_10 blue">PROMOCIONES</h3>
                                 <p class="notedesc">Nuestra especialidad es consentirte, además de nuestros descuentos te ofrecemos estas promociones:</p>-->
                                 
                                 <?
                      //$promociones_pendientes=0;
                      /*if(empty($se_id_cliente) and empty($se_usuario_cliente) and empty($se_password_cliente)):
                        ?>
                        <p><a href="../registro-clientes/?per=<?=$id_perfil?>">Regístrate en ziikfor.com y descarga tu promoción.</a></p>
                        <div class="clearfix"></div>
                        
                        <?
                        
                      endif;*/                      
                      ?>
                                 <div id="message_promocion"></div>
                                 <div id="div_promociones" class="isotope masonry-layout row ls_fondo4">
                                    <?
                                    while($f_pro=$c_pro->fetch_assoc()):
                                       $id_promocion=$f_pro["id_promocion"];
                                       $promocion=cadena($f_pro["promocion"]);
                                       $imagen_promocion=$f_pro["imagen"];
                                       $id_perfil=$f_pro["id_perfil"];
                                       $descripcion_corta_promocion=cadena($f_pro["descripcion_corta"]);
                          ?>
                          <article class="isotope-item col-lg-12 col-md-12 col-sm-12 col-xs-12 post format-standard">
                                        <?
                            if(!empty($imagen_promocion) and file_exists("../administrador/promociones/images/".$imagen_promocion)):
                              ?>
                                             <div class="entry-thumbnail imgpromocion" style="height:160px">

                                                 <a href="../perfil/?per=<?=$id_perfil?>&perfil=<?=$local_perfil?>" class="zoom first" title="<?=$promocion?>" >
                                                    <img src="../administrador/promociones/images/<?=$imagen_promocion?>" class="attachment-shop_thumbnail" alt="<?=$promocion?>">
                                                 </a>

                                 <header class="promociontexto entry-header" style=" background:#0b5896;">
                  <?
                  if(!empty($promocion)):
                  ?>
                                         <h4 class="white" style="font-size:14px !important; font-weight:normal;">
                                             <?=$promocion?>
                                         </h4>
                  <?
                    endif;
                  ?>                        
                </header>
                  <!-- .entry-header -->

                              </div>
                                <?
                            endif;
                            ?>
                            <!--<div class="promociondetalle post-content">
                              <div class="entry-content">
                                                                                
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
                                                   $c_pro_cli=buscar("COUNT(id_registro) AS total_promociones","promociones_clientes","WHERE id_perfil='".$p_per."' AND id_cliente='".$se_id_cliente."' AND id_promocion='".$id_promocion."'");
                                                   while($f_pro_cli=$c_pro_cli->fetch_assoc()):
                                                      $total_promociones=$f_pro_cli["total_promociones"];
                                                   endwhile;
                                                   if(empty($total_promociones)):                                 
                                  */
                                    ?>
                                                      <!--<a class="theme_button divider_20 descarga_promocion" id_perfil="<?=$id_perfil?>" id_promocion="<?=$id_promocion?>" href="#">Descargar promoción</a>-->

                                                      <?
                                    /*
                                                   endif;
                                  $c_pro_cli->free();
                                  unset($total_promociones);
                                  */
                                               endif;
                                               ?>
                               <!--</div><!-- .entry-content -->
                            <!--</div><!-- .post-content -->
                          </article>
                          <!-- .post -->                         
                          <?
                                       unset($id_promocion,$promocion,$imagen_promocion,$descripcion_corta_promocion);
                                    endwhile;
                                    ?>
                                 </div>
                                 <?
                      //unset($promociones_pendientes);
                              endif; 
                    $c_pro->free();
                    ?>
      <!--end promociones-->
      </div>
      </div>
   </section>
   <?
endif;
	include_once("../inc/publicidad.php");
	include_once("../inc/copyright.php");
?>
</div><!-- eof #box_wrapper -->
</div>
<script src="../js/compressed.js"></script><script src="../js/main.js"></script></body></html>