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
$p_not=isset($_GET["not"]) ? $_GET["not"]*1 : "";
if(!empty($p_not)):
	$c_not=buscar("id_nota,nota,imagen,descripcion_corta,descripcion_completa","notas_editoriales","WHERE id_nota='".$p_not."'");	
	while($f_not=$c_not->fetch_assoc()):
		$id_nota=$f_not["id_nota"];
		$nota=cadena($f_not["nota"]);
		$imagen_nota=$f_not["imagen"];
		$descripcion_corta_nota=cadena($f_not["descripcion_corta"],true);
		$descripcion_completa_nota=cadena($f_not["descripcion_completa"],true);
	endwhile;
	$ruta="http://ziikfor.com/nota_editorial/?not=".$id_nota."&nota=".$nota;
	$ruta_imagen="";
	$ancho_imagen="";
	$alto_imagen="";
	if(!empty($imagen_nota) and file_exists("/administrador/notas_editoriales/images/".$imagen_nota)):
		//$ruta_imagen=urlencode("http://ziikfor.com/administrador/perfiles/images/".$imagen_perfil);	
		$ruta_imagen="/administrador/notas_editoriales/images/".$imagen_nota;	
		$tamano_imagen = getimagesize("/administrador/notas_editoriales/images/".$imagen_nota);
		$ancho=$tamano_imagen[0];              //Ancho
		$alto=$tamano_imagen[1];               //Alto
	endif;
endif;


?>
<!DOCTYPE html> <html class="no-js"> 
<head> 
<title><? if(!empty($nota)): echo $nota." - ";endif;?>ZiiKFOR</title> 
<!-- Favicon -->
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />
<meta charset="utf-8">
<!--[if IE]> <meta http-equiv="X-UA-Compatible" content="IE=edge"><![endif]--> 
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1"> 
<?
if(!empty($ruta)):
	?>
	<meta property="og:url" content="<?=$ruta?>" />
   <?
endif;
?>
<meta property="og:type"          content="website" />
<meta property="og:title"         content="<?php echo $nota; ?>" />
<?php 
  $txtComparte = str_replace("<br>"," ",$descripcion_corta_nota);
?>
<meta property="og:description"   content="<?php echo strip_tags($txtComparte); ?>" />


<meta property="fb:app_id"   content="263928443976890" />
<?
//if(!empty($ruta_imagen)):
	?>
   <meta property="og:image" content="http://ziikfor.com/administrador/notas_editoriales/images/<?php echo $imagen_nota; ?>" />
   <?
	/*if(!empty($ancho_imagen)):
		?>
	   <meta property="og:image:width" content="<?=$ancho_imagen?>" />   
      <?		
	endif;
	if(!empty($alto_imagen)):
		?>
	   <meta property="og:image:height" content="<?=$alto_imagen?>" />   
      <?		
	endif;
	?>
   <link href="<?=$ruta_imagen?>" rel="image_src"/>
   <?
endif;*/
?>
<link rel="shortcut icon" href="http://ziikfor.com/images/favicon.png">
<link rel="stylesheet" href="../css/bootstrap.min.css">
<link rel="stylesheet" href="../css/main.css" id="color-switcher-link">
<link rel="stylesheet" href="../css/animations.css">
<link rel="stylesheet" href="../css/fonts.css">
<script src="../js/vendor/modernizr-2.6.2.min.js"></script>
<!--[if lt IE 9]> <script src="js/vendor/html5shiv.min.js"></script> <script src="js/vendor/respond.min.js"></script><![endif]-->

<script type='text/javascript' data-cfasync='false' src='//dsms0mj1bbhn4.cloudfront.net/assets/pub/shareaholic.js' data-shr-siteid='b62717da79586728048c38b77c540a91' async='async'></script>

</head>
<body><!--[if lt IE 9]> <div class="bg-danger text-center">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/" class="highlight">upgrade your browser</a> to improve your 
experience.</div><![endif]-->
<!-- Load Facebook SDK for JavaScript -->

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v2.5";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>


<div class="boxed pattern8" id="canvas">
	<div class="container" id="box_wrapper">
   <?
	include_once("../inc/header.php");
	
	include_once("../inc/form_busqueda_horizontal2.php");
	
	if(!empty($id_nota) and !empty($nota)):
		?>
      <section id="content" class="ls section_padding_top_15 section_padding_bottom_75">
          <div class="container">
              <div class="row">
      
                  <div class="col-sm-8 col-md-8 col-lg-8">
      
                                      <article class="post type-post with-share-buttons">
                          <header class="entry-header">
      
                              <h1 class="entry-title">
                                  <a href="../nota_editorial/?not=<?=$id_nota?>&nota=<?=$nota?>" rel="bookmark"><?=$nota?></a>
                              </h1>
      								<? /*
                              <div class="entry-meta">
      
                                  <span class="author">
                                      <i class="rt-icon2-user2 highlight2"></i>
                                      by 
                                      <a href="blog-right.html">Admin</a>
                                  </span>
      
                                  <span class="categories-links">
                                      <i class="rt-icon2-tag5 highlight2"></i>
                                      In
                                      <a rel="category" href="#">Dental</a>, 
                                      <a rel="category" href="#">Pediatrics</a>
                                  </span>
      
                                  <span class="date">
                                      <time datetime="2015-03-09T15:05:23+00:00" class="entry-date">
                                          <i class="rt-icon2-calendar5 highlight2"></i>
                                          09.03.2015
                                      </time>
                                  </span>
      
                                  <span class="comments-link">
                                      <i class="rt-icon2-chat"></i>
                                      <a href="#comments">
                                          5 Comments
                                      </a>
                                  </span>
      
                                  <span class="item-likes pull-right">
                                      <i class="rt-icon2-heart2 highlight2"></i>
                                      5
                                  </span>
                              </div>
                              <!-- .entry-meta --> 
										*/
										?>
                          </header>
                          <!-- .entry-header -->
                          <?
								  if(!empty($imagen_nota) and file_exists("../administrador/notas_editoriales/images/".$imagen_nota)):
										?>
									  <div class="entry-thumbnail divider_40">
										<img class="" src="http://ziikfor.com/administrador/notas_editoriales/images/<?=$imagen_nota?>" alt="<?=$nota?>" rel="image_src">
										</div>
										<?
									endif;
									if(!empty($descripcion_corta_nota) and $descripcion_corta_nota!="<br>"):
										?>
                             <div class="entry-excerpt">
                                 <p><?=$descripcion_corta_nota?></p>
                             </div>
                              <?
									endif;
									?>
                           <h5 class="topmargin_20">Comparte:</h5>
<div class='shareaholic-canvas' data-app='share_buttons' data-app-id='25891808'></div>

                           <!--<div class="product-icons row">
                               <div class="col-xs-1">
                                   <div class="teaser text-center">
                                    <a class="color-icon bg-icon soc-facebook" href="http://www.facebook.com/sharer.php?u=<?=$ruta?>" target="_blank">#</a>    
                                   </div>
                               </div>
                               <div class="col-xs-1">
                                   <div class="teaser text-center">
                                       <a class="color-icon bg-icon soc-twitter" href="http://twitter.com/share?url=<?=$ruta?>&text=<?=urlencode($nota)?>" target="_blank">#</a>                                      	
                                   </div>
                               </div>
                               <div class="col-xs-1">
                                   <div class="teaser text-center">
                                       <a class="color-icon bg-icon soc-linkedin" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?=$ruta?>&title=<?=urlencode($nota)?>&summary=&source=" target="_blank">#
                                       </a>                                      	
                                   </div>
                               </div>          
                               <div class="col-xs-1">
                                   <div class="teaser text-center">
                                       <a class="color-icon bg-icon soc-google" href="https://plus.google.com/share?url=<?=$ruta?>" target="_blank">#
                                       </a>                                      	
                                   </div>
                               </div>                  
                              <?
                              if(!empty($ruta_imagen)):
                                 ?>
                                  <div class="col-xs-1">
                                      <div class="teaser text-center">
                                       <a class="color-icon bg-icon soc-pinterest" href="https://pinterest.com/pin/create/button/?url=<?=$ruta?>&media=<?=$ruta_imagen?>&description=<?=urlencode($nota)?>" target="_blank">#
                                       </a>
                                      </div>
                                  </div>
                                 <?
                              endif;
                               ?>
                           </div> -->                       
                           <?
									if(!empty($descripcion_completa_nota) and $descripcion_completa_nota!="<br>"):
										?>
                              <div class="entry-content">
                                 <p><?=$descripcion_completa_nota?></p>
                             </div>
                             <!-- .entry-content -->
                              <?
									endif;
								  ?>
                          <!-- <footer class="bottom-entry-meta">
                              <div class="table_section entry-tags">
                                  <div class="row">
                                      <div class="col-sm-6">
                                          <span class="tags-links">
                                              <a rel="tag" href="#">Graphic Design</a>, 
                                              <a rel="tag" href="#">Photography</a>
                                          </span>
                                      </div>
                                      <div class="col-sm-6">  
                                          <span class='st_facebook_hcount'></span>
                                          <span class='st_twitter_hcount'></span>
                                          <span class='st_googleplus_hcount'></span>
                                      </div>
                                  </div>
                              </div>
                          </footer>   -->
                      </article>
                  </div> <!--eof .col-sm-8 (main content)-->
                  
                  <!-- sidebar -->
                  <aside class="col-sm-4 col-md-4 col-lg-3 col-lg-push-1">
                  	<?
							//Secciones
							$c_seci=buscar("DISTINCT nota.id_seccion,sec.seccion","notas_editoriales nota LEFT OUTER JOIN secciones sec ON sec.id_seccion=nota.id_seccion","WHERE nota.estatus='activo' ORDER BY sec.seccion ASC");
							$fiseci=$c_seci->num_rows;
							if($fiseci>0):
								?>
								<div class="widget widget_tag_cloud">
                         <h3 class="widget-title">Secciones</h3>
                         <div class="tagcloud">
									<?
                           while($f_seci=$c_seci->fetch_assoc()):
                              $id_seccioni=$f_seci["id_seccion"];
                              $seccioni=cadena($f_seci["seccion"]);
                              ?>
                              <a href="../seccion/?sec=<?=$id_seccioni?>&seccion=<?=$seccioni?>" title="<?=$seccioni?>"><?=$seccioni?></a>
                              <?
                              unset($id_seccioni,$seccioni);
                           endwhile;
                           ?>	
                         </div>
	                     </div>
								<?
							endif;
							$c_seci->free();
							
							//Categorias
							//Secciones
							$c_seci=buscar("DISTINCT cat_not.id_categoria,cat.categoria,(SELECT COUNT(cat_not2.id_nota) FROM categorias_notas cat_not2 WHERE cat_not2.id_categoria=cat_not.id_categoria) AS total_notas","categorias_notas cat_not LEFT OUTER JOIN categorias cat ON cat.id_categoria=cat_not.id_categoria","ORDER BY cat.categoria ASC");
							$fiseci=$c_seci->num_rows;
							if($fiseci>0):
								?>
                        <div class="widget widget_categories">
                            <h3 class="widget-title">Categorías</h3>
                            <ul>
                            	<?
										while($f_seci=$c_seci->fetch_assoc()):
											$id_categoria=$f_seci["id_categoria"];
											$categoria=cadena($f_seci["categoria"]);
											$total_notas=$f_seci["total_notas"];
											?>
                                 <li>
											<a href="#" title="<?=$categoria?>"><?=$categoria?></a> <span>(<?=$total_notas?>)</span>
                                 </li>
											<?
											unset($id_categoria,$categoria,$total_notas);
										endwhile;
										?>
                            </ul>
                        </div>
								<?
							endif;
							?>
                  </aside> <!-- eof aside sidebar -->
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