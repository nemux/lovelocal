<?
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
<!--[if lt IE 9]> <script src="js/vendor/html5shiv.min.js"></script> <script src="js/vendor/respond.min.js"></script><![endif]-->
</head>
<body><!--[if lt IE 9]> <div class="bg-danger text-center">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/" class="highlight">upgrade your browser</a> to improve your 
experience.</div><![endif]-->
<div class="boxed pattern8" id="canvas">
	<div class="container" id="box_wrapper">
   <?
	include_once("../inc/header.php");
	?>
	<section id="mainteasers" class="cs section_padding_0 columns_padding_0 table_section table_section_lg">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 bg_teaser after_cover color_bg_1">
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
            <div class="col-lg-6 bg_teaser after_cover color_bg_2">
            	<img src="../images/teaser02.jpg" alt="">
               <div class="teaser_content media">
                	<? /*
                    <div class="media-left">
                        <h4 class="grey media-heading">Patient</h4>
                        <h3>Review</h3>
                        <!-- testimonials indicators -->
                        <div class="topmargin_30">
                            <a class="testimonials-control" href="#carousel-media" role="button" data-slide="prev">
                                <i class="arrow-icon-left-open-big"></i>
                            </a>
                            <a class="testimonials-control" href="#carousel-media" role="button" data-slide="next">
                                <i class="arrow-icon-right-open-big"></i>
                            </a>
                        </div>
                    </div>
                    <div class="media-body">
                        <div id="carousel-media" class="carousel slide testimonials-carousel" data-ride="carousel">
                            <!-- Indicators -->
                            <ol class="carousel-indicators">
                                <li data-target="#carousel-media" data-slide-to="0" class="active"></li>
                                <li data-target="#carousel-media" data-slide-to="1"></li>
                                <li data-target="#carousel-media" data-slide-to="2"></li>
                            </ol>

                            
                            <!-- Wrapper for slides -->
                            <div class="carousel-inner">
                                <div class="item active">
                                    <p>
                                        Ullamco laboris nialiquid exea commodi consat. Ut enim minim veniam norud exotation.
                                    </p>
                                    <div class="media">
                                    	
                                        <a class="media-left" href="#">
                                            <img class="media-object" src="images/team/01.jpg" alt="">
                                        </a>
                                        <div class="media-body">
                                            <h4>Jhon Smith</h4>
                                            <p>
                                                Google Inc.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="item">
                                    <p>
                                        Ullamco laboris nialiquid exea commodi consat. Ut enim minim veniam norud exotation.
                                    </p>
                                    <div class="media">
                                        <a class="media-left" href="#">
                                            <img class="media-object" src="images/team/02.jpg" alt="">
                                        </a>
                                        <div class="media-body">
                                            <h4>Michael Anderson</h4>
                                            <p>
                                                Google Inc.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="item">
                                    <p>
                                        Ullamco laboris nialiquid exea commodi consat. Ut enim minim veniam norud exotation.
                                    </p>
                                    <div class="media">
                                        <a class="media-left" href="#">
                                            <img class="media-object" src="images/team/03.jpg" alt="">
                                        </a>
                                        <div class="media-body">
                                            <h4>Michael Anderson</h4>
                                            <p>
                                                Google Inc.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- eof #carousel-media -->
                    </div>
                </div>
                */?>
            </div>
        </div>
    </div>
</section>
<?
$c_not=buscar("nota.id_nota,nota.id_seccion,sec.seccion,nota.nota,nota.imagen,nota.descripcion_corta","notas_editoriales nota LEFT OUTER JOIN secciones sec ON sec.id_seccion=nota.id_seccion","WHERE nota.estatus='activo' ORDER BY nota.orden DESC LIMIT 6");
$finot=$c_not->num_rows;
if($finot>0):
	?>
   <section class="ls section_padding_10">
      <div class="container">
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
                  <?
						if(!empty($id_seccion_nota) and !empty($seccion_nota)):
							?>
                     <div class="text-center topmargin_10">
                     <a class="theme_button button2" href="../seccion/?sec=<?=$id_seccion_nota?>&seccion=<?=$seccion_nota?>"><?=$seccion_nota?></a>
                     </div>
                     <?
						endif;
						?>
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