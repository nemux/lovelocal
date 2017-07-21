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
//ini_set("display_errors","On");
include_once("../administrador/php/config.php");
include_once("../administrador/php/func.php");
include_once("../administrador/php/func_bd.php");
$p_art=isset($_GET["art"]) ? $_GET["art"]*1 : "";
if(!empty($p_art)):
	$c_art=buscar("id_articulo,articulo,imagen,descripcion_completa","articulos_perfiles","WHERE id_articulo='".$p_art."'");	
	while($f_art=$c_art->fetch_assoc()):
		$id_articulo=$f_art["id_articulo"];
		$articulo=cadena($f_art["articulo"]);
		$imagen_articulo=$f_art["imagen"];
		$descripcion_completa_articulo=cadena($f_art["descripcion_completa"],true);
	endwhile;
	$ruta="http://lovelocal.mx/detalle-articulo/?art=".$id_articulo."&articulo=".$articulo;
	$ruta_imagen="";
	if(!empty($imagen_articulo) and file_exists("../administrador/articulos/images/".$imagen_articulo)):
		//$ruta_imagen=urlencode("http://lovelocal.mx/administrador/perfiles/images/".$imagen_perfil);	
		$ruta_imagen="http://lovelocal.mx/administrador/articulos/images/".$imagen_articulo;	
	endif;
endif;
?>
<!DOCTYPE html> <html class="no-js"> 
<head> 
<title><? if(!empty($articulo)): echo $articulo." - ";endif;?>LoveLocal</title> 
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />
<meta charset="utf-8"><!--[if IE]> <meta http-equiv="X-UA-Compatible" content="IE=edge"><![endif]--> 
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
<meta property="og:title"         content="<?=$articulo?>" />
<? /*
<meta property="og:description"   content="<?=$articulo?>" />
*/
if(!empty($ruta_imagen)):
	?>
   <meta property="og:image" content="<?=$ruta_imagen?>" />
   <link href="<?=$ruta_imagen?>" rel="image_src"/>
   <?
endif;
?>
<!-- Favicon -->
<link rel="shortcut icon" href="http://lovelocal.mx/images/favicon.png">
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
	
	if(!empty($id_articulo) and !empty($articulo)):
		?>
      <section class="ls ms section_padding_10 section_padding_top_15 table_section">
      	<div class="container">
         	<div class="row">
         		<div class="col-sm-6 selected">
               	<?
						if(!empty($articulo)):
							?>
                     <h3 class="topmargin_0"><?=$articulo?></h3>
                     <?
						endif;
						if(!empty($descripcion_completa_articulo)):
							?>
                     <p class=""><?=$descripcion_completa_articulo?></p>
                     <?
						endif;
						?>
						<h5 class="topmargin_20">Comparte:</h5>
                  <div class="product-icons row">
                      <div class="col-xs-1">
                          <div class="teaser text-center">
                           <a class="color-icon bg-icon soc-facebook" href="http://www.facebook.com/sharer.php?u=<?=$ruta?>" target="_blank">#</a>    
                          </div>
                      </div>
                      <div class="col-xs-1">
                          <div class="teaser text-center">
                              <a class="color-icon bg-icon soc-twitter" href="http://twitter.com/share?url=<?=$ruta?>&text=<?=urlencode($articulo)?>" target="_blank">#</a>                                      	
                          </div>
                      </div>
                      <div class="col-xs-1">
                          <div class="teaser text-center">
                              <a class="color-icon bg-icon soc-linkedin" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?=$ruta?>&title=<?=urlencode($articulo)?>&summary=&source=" target="_blank">#
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
                              <a class="color-icon bg-icon soc-pinterest" href="https://pinterest.com/pin/create/button/?url=<?=$ruta?>&media=<?=$ruta_imagen?>&description=<?=urlencode($articulo)?>" target="_blank">#
                              </a>
                             </div>
                         </div>
                        <?
                     endif;
                      ?>
                  </div>                   
               </div>
               <div class="col-sm-6 text-center">
               	<?
						if(!empty($imagen_articulo) and file_exists("../administrador/articulos/images/".$imagen_articulo)):
							?>
		               <img class="" src="http://lovelocal.mx/administrador/articulos/images/<?=$imagen_articulo?>" alt="<?=$articulo?>" rel="image_src">
                     <?
						endif;
						?>
               </div>
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