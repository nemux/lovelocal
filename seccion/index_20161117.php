<?
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
$p_sec=isset($_GET["sec"]) ? $_GET["sec"]*1 : "";
if(!empty($p_sec)):
	$c_sec=buscar("id_seccion,seccion,imagen,descripcion_completa","secciones","WHERE id_seccion='".$p_sec."'");	
	while($f_sec=$c_sec->fetch_assoc()):
		$id_seccion=$f_sec["id_seccion"];
		$seccion=cadena($f_sec["seccion"]);
		$imagen_seccion=$f_sec["imagen"];
		$descripcion_completa_seccion=cadena($f_sec["descripcion_completa"],true);
	endwhile;
endif;
?>
<!DOCTYPE html> <html class="no-js"> 
<head> 
<title><? if(!empty($seccion)): echo $seccion." - ";endif;?>ZiiKFOR</title> 
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
<!--[if lt IE 9]> <script src="js/vendor/html5shiv.min.js"></script> <script src="js/vendor/respond.min.js"></script><![endif]-->
</head>
<body><!--[if lt IE 9]> <div class="bg-danger text-center">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/" class="highlight">upgrade your browser</a> to improve your 
experience.</div><![endif]-->
<div class="boxed pattern8" id="canvas">
	<div class="container" id="box_wrapper">
   <?
	include_once("../inc/header.php");
	
	include_once("../inc/form_busqueda_horizontal2.php");
	
	if(!empty($id_seccion) and !empty($seccion)):
		?>
      <section class="ls ms section_padding_10 section_padding_top_15 table_section">
      	<div class="container">
         	<div class="row">
         		<div class="col-sm-6 selected">
               	<?
						if(!empty($seccion)):
							?>
                     <h3 class="topmargin_0"><?=$seccion?></h3>
                     <?
						endif;
						if(!empty($descripcion_completa_seccion)):
							?>
                     <p class=""><?=$descripcion_completa_seccion?></p>
                     <?
						endif;
						?>
               </div>
               <div class="col-sm-6 text-center">
               	<?
						if(!empty($imagen_seccion) and file_exists("../administrador/secciones/images/".$imagen_seccion)):
							?>
		               <img class="" src="../administrador/secciones/images/<?=$imagen_seccion?>" alt="<?=$seccion?>">
                     <?
						endif;
						?>
               </div>
         	</div>
      	</div>
		</section>   
      <?
	endif;
	
	//Buscar galería de fotos
	$c_gal=buscar("imagen,titulo","fotos_secciones","WHERE id_seccion='".$p_sec."' AND estatus='activo' ORDER BY orden ASC",false);
	if($c_gal->num_rows>0):
		?>
      <section class="ls section_padding_10 section_padding_top_15">
			<div class="container">
         	<div class="row">
               <div class="col-sm-12 selected">
						<h3 class="topmargin_0 bottommargin_0">Galería de fotos</h3>               
               </div>
            </div>
            <div class="row">
            	<div class="col-sm-12">
                  <div id="product-thumbnails" class="owl-carousel thumbnails product-thumbnails topmargin_0" 
                   data-loop="false"
                   data-margin="10"
                   data-nav="true"
                   data-dots="false"
                   data-items=" 3"
                   data-responsive-lg="3"
                   data-responsive-md="3"
                   data-responsive-sm="2"
                   data-responsive-xs="2"
                   data-themeClass="product-gallery-thumbnails"
                  >
                  <?
                  while($f_gal=$c_gal->fetch_assoc()):
                     $imagen_galeria=$f_gal["imagen"];
                     $titulo_foto=cadena($f_gal["titulo"]);
                     if(!empty($imagen_galeria) and file_exists("../administrador/galeria_secciones/images/".$imagen_galeria)):
                        ?>
                         <a href="../administrador/galeria_secciones/images/<?=$imagen_galeria?>" class="zoom first" title="<?=$titulo_foto?>" data-gal="prettyPhoto[seccion-gallery]">
                            <img src="../administrador/galeria_secciones/images/<?=$imagen_galeria?>" class="attachment-shop_thumbnail" alt="<?=$titulo_foto?>">
                         </a>
                        <?
                     endif;
                     unset($imagen_galeria,$titulo_foto);
                  endwhile;
                  ?>
                  </div>               	
               </div>
            </div>
         </div>
      </section>
		<?
	endif;	
	
	//Buscar galería de videos
	$c_vid=buscar("vid.id_video,vid.titulo,vid.enlace","videos_secciones vid","WHERE vid.id_seccion='".$p_sec."' AND vid.estatus='activo' ORDER BY vid.orden ASC",false);
	if($c_vid->num_rows>0):
		?>
      <section class="ls section_padding_10 section_padding_top_15">
			<div class="container">
         	<div class="row">
               <div class="col-sm-12 selected">
						<h3 class="topmargin_0 bottommargin_0">Galería de videos</h3>               
               </div>
            </div>
            <div class="row">
            	<div class="col-sm-12">
                  <div id="isotope_container" class="isotope masonry-layout row ls_fondo4">
                     <?
                     while($f_vid=$c_vid->fetch_assoc()):
                        $id_video=$f_vid["id_video"];
                        $titulo_video=cadena($f_vid["titulo"]);
                        $video=str_replace("<br>","",cadena($f_vid["enlace"]));
                        $id_youtube=id_youtube($video);
                        if(!empty($id_youtube)):
                           ?>
                           <article class="isotope-item col-lg-4 col-md-4 col-sm-6 col-xs-12 post format-standard">
                              <div class="entry-thumbnail">
                                  <iframe width="360" height="201" src="https://www.youtube.com/embed/<?=$id_youtube?>" frameborder="0" allowfullscreen></iframe>
                              </div>
                              <div class="post-content">
                                  <div class="entry-content">
                                      <header class="entry-header">
                                          <? /*
                                          <h3 class="entry-title">
                                              <a href="../detalle_articulo/" rel="bookmark">Duis autem vel eum iriure</a>
                                          </h3> */
                                          if(!empty($titulo_video)):
                                             ?>
                                             <div class="entry-meta">
                                                 <span class="author">
                                                     <?=$titulo_video?>
                                                 </span>
                                                 <? /*
                                                 <span class="categories-links">
                                                     <i class="rt-icon2-tag5 highlight2"></i>
                                                     In
                                                     <a rel="category" href="#">Pediatrics</a>
                                                 </span> */ ?>
                                             </div>
                                             <!-- .entry-meta -->
                                             <?
                                          endif;
                                          ?>												
                                      </header>
                                      <!-- .entry-header -->
                                       <!--
                                      <p>Duis autem eumre dolor hendrerit vulputate veliesse molestie consequat.</p>
                                      -->
                                  </div><!-- .entry-content -->
                              </div><!-- .post-content -->
                           </article>
                           <!-- .post -->                         
                           <?
                        endif;
                        unset($id_video,$titulo_video,$video,$id_youtube);
                     endwhile;
                     ?>
                  </div> <!-- eof #isotope_container -->
                  <!--
                  <ul class="pagination">
                       <li><a href="#"><i class="arrow-icon-left-open-3"></i></a></li>
                       <li class="active"><a href="#">1</a></li>
                       <li><a href="#">2</a></li>
                       <li><a href="#">3</a></li>
                       <li><a href="#">4</a></li>
                       <li><a href="#">5</a></li>
                       <li><a href="#"><i class="arrow-icon-right-open-3"></i></a></li>
                  </ul>
                  -->
               </div>
            </div>
         </div>
      </section>
		<?
	endif;
	
	
	$c_not=buscar("nota.id_nota,nota.id_seccion,sec.seccion,nota.nota,nota.imagen,nota.descripcion_corta","notas_editoriales nota LEFT OUTER JOIN secciones sec ON sec.id_seccion=nota.id_seccion","WHERE nota.id_seccion='".$p_sec."' AND nota.estatus='activo' ORDER BY nota.orden DESC");
	$finot=$c_not->num_rows;
	if($finot>0):
		?>
		<section class="ls section_padding_10 section_padding_top_15">
			<div class="container">
               <div class="row">
               <div class="col-sm-12 selected">
                  <h3 class="topmargin_0 bottommargin_0">Notas editoriales</h3>
               </div>
            </div>
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
					$descripcion_corta_nota=cadena($f_not["descripcion_corta"]);
					if($col_not==1):
						?>
						<div class="row">
						<?
					endif;
					?>
						<div class="col-sm-4">
							<?
							if(!empty($imagen_nota) and file_exists("../administrador/notas_editoriales/images/".$imagen_nota)):
								?>
                        <a class="enlace" href="../nota_editorial/?not=<?=$id_nota?>&nota=<?=$nota?>">
								<img src="../administrador/notas_editoriales/images/<?=$imagen_nota?>" alt="<?=$nota?>">
                        </a>
								<?
							endif;
							if(!empty($nota)):
								?>
								<h4 class="topmargin_10"><?=$nota?></h4>
								<?
							endif;
							if(!empty($descripcion_corta_nota)):
								?>
								<p class=""><?=$descripcion_corta_nota?></p>
								<?
							endif;
							?>
							<div class="text-right">
								<a class="enlace" href="../nota_editorial/?not=<?=$id_nota?>&nota=<?=$nota?>">Ver más...</a>                  
							</div>
						</div>
					<?
					if($col_not==3 or $con_not==$finot):
						?>
						</div>
						<?
						$col_not=0;
					endif;
					unset($id_nota,$id_seccion_nota,$seccion_nota,$nota,$imagen_nota,$descripcion_corta_nota);
				endwhile
				?>
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