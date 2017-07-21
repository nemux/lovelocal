<?
include_once("../administrador/php/config.php");
include_once("../administrador/php/func.php");
include_once("../administrador/php/func_bd.php");
$p_buscar=isset($_GET["buscar"]) ? cadenabd($_GET["buscar"]) : "";
$p_lugar=isset($_GET["lugar"]) ? cadenabd($_GET["lugar"]) : "";
$p_buscar2=isset($_GET["buscar2"]) ? cadenabd($_GET["buscar2"]) : "";
$p_categoria=isset($_GET["categoria"]) ? cadenabd($_GET["categoria"]) : "";
$p_ubicacion=isset($_GET["ubicacion"]) ? cadenabd($_GET["ubicacion"]) : "";
$p_orden=isset($_GET["orden"]) ? cadenabd($_GET["orden"]) : "";
$p_pag=isset($_GET["pag"]) ? $_GET["pag"]*1 : 0;
?>
<!doctype html>
<html>
<head>
<title>Resultado de búsqueda - ZiiKFOR</title>
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
		include_once("../inc/form_busqueda_horizontal.php");
		?>
      <section id="content" class="ls section_padding_top_20 section_padding_bottom_75">
          <div class="container">
              <div class="row">
                  <div class="col-sm-8 col-md-8 col-lg-8 col-sm-push-4 col-md-push-4 col-lg-push-4">
      					<? 
							/*
                      <div class="category-banner">
                      <img src="images/shop/category_banner.jpg" alt="">
                      </div>
							 */
							 ?>
                      <div class="storefront-sorting divider_40">
                          
                          <form class="form-inline">
                              <div class="form-group">
                                  <label class="grey" for="orderby">Ordenar por:</label>
                                  <select class="form-control orderby" name="orderby" id="orderby">
                                      <option value="menu_order" selected>Default</option>
                                      <option value="Evaluacion">Evaluación</option>
                                      <option value="price">Menor a mayor precio</option>
                                      <option value="price-desc">Mayor a menor precio</option>
                                  </select>
                              </div>
      
                              <a href="#" id="sort_view">
											<i class="arrow-icon-up-small"></i>
                              </a>
                              
                              <a href="#" id="toggle_shop_view" class=""></a>
      
                              <div class="form-group pull-right">
                                  <label class="grey" for="showcount">Mostrar:</label>
                                  <select class="form-control showcount" name="showcount" id="showcount">
                                      <option value="menu_order" selected>8</option>
                                      <option value="popularity">12</option>
                                      <option value="rating">16</option>
                                      <option value="date">20</option>
                                      <option value="price">24</option>
                                      <option value="price-desc">28</option>
                                  </select>
                              </div>
      
                          </form>
      
                      </div>
                      <div class="columns-3">
                          <?
								  	//Buscar perfiles
								  	$con_per="WHERE estatus='activo'";
								  	if(!empty($p_buscar)):
							  			$con_per.=" AND per.local LIKE '%".$p_buscar."%'";
								  	endif;
									if(!empty($p_lugar)):
										$con_per.=" AND est.estado LIKE '%".$p_lugar."%'";
									endif;
								  $c_per=buscar("per.id_perfil,per.local,per.imagen,per.descripcion_corta,per.precio_de,per.precio_a","perfiles per LEFT OUTER JOIN estados est ON est.id_estado=per.id_estado","WHERE per.estatus='activo'");
								  if($c_per->num_rows>0):
										?>
                              <ul id="products" class="products list-unstyled list-view">
											<?
                                 while($f_per=$c_per->fetch_assoc()):
												$id_perfil=$f_per["id_perfil"];
												$local_perfil=cadena($f_per["local"]);
												$imagen_perfil=$f_per["imagen"];
												$descripcion_corta_perfil=cadena($f_per["descripcion_corta"]);
												$precio_de_perfil=$f_per["precio_de"];
												$precio_a_perfil=$f_per["precio_a"];
												?>
                                    <li class="product type-product">
	                                    <div class="side-item">
                                            <div class="row">
                                                <div class="col-md-5">
                                                	<?
																	if(!empty($imagen_perfil) and file_exists("../administrador/perfiles/images/".$imagen_perfil)):
																		?>
                                                       <div>
                                                           <a href="../perfil/?per=<?=$id_perfil?>&perfil=<?=$local_perfil?>">
                                                               <img  src="../administrador/perfiles/images/<?=$imagen_perfil?>" alt="<?=$local_perfil?>">
                                                               <!--
                                                               <span class="newproduct">New</span>
                                                               -->
                                                           </a>
                                                       </div>
                                                      <?
																	endif;
																	?>
                                                </div>
                                                <div class="col-md-7">
                                                    <h3>
                                                        <a href="../perfil/?per=<?=$id_perfil?>&perfil=<?=$local_perfil?>"><?=$local_perfil?></a>
                                                    </h3>
            
                                                    <div class="star-rating" title="Rated 4.50 out of 5">
                                                        <span style="width:40%">
                                                            <strong class="rating">4.50</strong> out of 5
                                                        </span>
                                                    </div>
                                                    
                                                    <?
																	 /*
																	 if(!empty($precio_de_perfil) and !empty($precio_a_perfil)):
																	 	?>
                                                       <span class="price clearfix">
	                                                       <span class="amount">
																				 <?
                                                             if(!empty($precio_de_perfil)):
                                                               echo "$".number_format($precio_de_perfil,2);
                                                               if(!empty($precio_a_perfil)):
                                                                  echo " a $".number_format($precio_a_perfil,2);
                                                               endif;
                                                            elseif(!empty($precio_a_perfil)):
                                                               echo "$".number_format($precio_a_perfil,2);
                                                             endif;
                                                             ?>
                                                          </span>
                                                       </span>
                                                      <?
																	 endif;
																	 */
																	 if(!empty($descripcion_corta_perfil)):
																	 	?>
                                                       <p class="product-description">
                                                           <?=$descripcion_corta_perfil?>
                                                       </p>
                                                      <?
																	 endif;
																	 ?>
                                                    <a href="../perfil/?per=<?=$id_perfil?>&perfil=<?=$local_perfil?>" rel="nofollow" class="theme_button inverse add_to_cart_button">
                                                    Más información
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <?
												unset($id_perfil,$local_perfil,$imagen_perfil,$descripcion_corta_perfil);
                                 endwhile;
                                 ?>
	                          </ul>
										<?
								  endif;
								  ?>
                          
                      
                      </div> <!-- eof .columns-* -->
      
      
                      <div class="row">
                          <div class="col-sm-12">
                              <ul class="pagination">
                                  <li><a href="#"><i class="arrow-icon-left-open-3"></i></a></li>
                                  <li class="active"><a href="#">1</a></li>
                                  <li><a href="#">2</a></li>
                                  <li><a href="#">3</a></li>
                                  <li><a href="#">4</a></li>
                                  <li><a href="#">5</a></li>
                                  <li><a href="#"><i class="arrow-icon-right-open-3"></i></a></li>
                              </ul>
                          </div>
                      </div>
                  </div> <!--eof .col-sm-8 (main content)-->
      
                  <!-- sidebar -->
                  <aside class="col-sm-4 col-md-4 col-lg-3 col-sm-pull-8 col-md-pull-8 col-lg-pull-8 text-right">
                  
                     <div class="widget widget_search">
                         <!-- <h3 class="widget-title">Site Search</h3> -->
                         <form role="search" class="searchform form-inline">
                             <div class="form-group">
                                 <label class="screen-reader-text" for="buscar2">Buscar:</label>
                                 <input type="text" value="<? if(!empty($p_buscar2)): echo cadena($p_buscar2); endif;?>" name="buscar2" id="buscar2" class="form-control" placeholder="ZiiKIT!">
                             </div>
                             <button type="button" class="theme_button filtrar">Filtrar</button>
                         </form>
							</div>
                      
                      <div class="widget widget_price_filter">
          
              <h3 class="widget-title">Precio</h3>
          
          <!-- price slider -->
          <form method="get" action="/" class="form-inline">
               
              <div class="slider-range-price"></div>
      
              <div class="form-group">
                  <label class="grey" for="slider_price_min">Desde:</label>
                  <input type="text" class="slider_price_min form-control text-center" id="slider_price_min" readonly>
              </div>
      
              <div class="form-group">
                  <label class="grey" for="slider_price_max"> a:</label>
                  <input type="text" class="slider_price_max form-control text-center" id="slider_price_max" readonly>
              </div>
      
              <div class="text-right">
                  <button type="button" class="theme_button inverse filtrar">Filtrar</button>
              </div>
          </form>
      </div>
      
		<div class="widget widget_layered_nav widget_categories">
			<h3 class="widget-title">Servicios</h3>
         <?
			$c_cat=buscar("DISTINCT cat_per.id_categoria,cat.categoria,(SELECT COUNT(cat_per2.id_perfil) FROM categorias_perfiles cat_per2 WHERE cat_per2.id_categoria=cat_per.id_categoria) AS total_perfiles","categorias_perfiles cat_per LEFT OUTER JOIN categorias cat ON cat.id_categoria=cat_per.id_categoria","ORDER BY cat.categoria ASC");
			if($c_cat->num_rows>0):
				?>
            <ul class="list-unstyled">
            	<?
					while($f_cat=$c_cat->fetch_assoc()):
						$id_categoria=$f_cat["id_categoria"];
						$categoria=cadena($f_cat["categoria"]);
						$total_perfiles=$f_cat["total_perfiles"];
						?>
                  <li>
                     <a href="./?cat=<?=$id_categoria?>"><?=$categoria?></a>
                     <span class="count black">(<?=$total_perfiles?>)</span>
                  </li>
                  <?
						unset($id_categoria,$categoria,$total_perfiles);
					endwhile;
					?>
            </ul>            
            <?
			endif;
			?>
      </div>
                      
      <div class="widget widget_categories">
			<h3 class="widget-title">Ubicación</h3>
			<?
         $c_ubi=buscar("DISTINCT per.municipio
								,(SELECT COUNT(per2.id_perfil) 
									FROM perfiles per2 
									WHERE per2.municipio=per.municipio) AS total_perfiles"
								,"perfiles per"
								,"ORDER BY per.municipio ASC");
			if($c_ubi->num_rows>0):
				?>
             <ul>
             	<?
					while($f_ubi=$c_ubi->fetch_assoc()):
						$municipio=cadena($f_ubi["municipio"]);
						$total_perfiles=$f_ubi["total_perfiles"];
						?>
                  <li>
                     <a href="#"><?=$municipio?></a>
                     <span>(<?=$total_perfiles?>)</span>
                  </li>
                  <?
						unset($municipio,$total_perfiles);
					endwhile;
					?>
             </ul>
            <?
			endif;
         ?> 
      </div>
                  </aside> <!-- eof aside sidebar -->
      
              </div>
          </div>
      </section>      
   <?
	include_once("../inc/publicidad.php");
	include_once("../inc/copyright.php");
	?>
	</div><!-- eof #box_wrapper -->
</div>
<?
$c_pre=buscar("MIN(precio_de) AS precio_de,MAX(precio_a) AS precio_a","perfiles","WHERE estatus='activo'");
while($f_pre=$c_pre->fetch_assoc()):
	$precio_de=$f_pre["precio_de"];
	$precio_a=$f_pre["precio_a"];
endwhile;
?>
<script src="../js/compressed.js"></script><script src="../js/main.js"></script>
<script>
jQuery(document).ready(function(){
   jQuery('.filtrar').on('click', function(e){
		e.preventDefault();
		var buscar=jQuery("#buscar").val();
		var lugar=jQuery("#lugar").val();
		var buscar2=jQuery("#buscar2").val();
		var precio_de=jQuery("#slider_price_min").val();
		var precio_a=jQuery("#slider_price_max").val();
		jQuery(location).attr('href','../resultado_busqueda/?buscar='+buscar+"&lugar="+lugar+"&buscar2="+buscar2+"&precio_de="+precio_de+"&precio_a="+precio_a);
	});
}); //end of "document ready" event		

//price filter
if (jQuery().slider) {
	jQuery( ".slider-range-price" ).slider({
		range: true,
		min:<?=$precio_de?>,
		max:<?=$precio_a?>,
		values: [<?=$precio_de?>,<?=$precio_a?>],
		slide: function( event, ui ) {
			jQuery( ".slider_price_min" ).val( ui.values[ 0 ] );
			jQuery( ".slider_price_max" ).val( ui.values[ 1 ] );
		}
	 });
	 jQuery( ".slider_price_min" ).val( jQuery( ".slider-range-price" ).slider( "values", 0 ) );
	 jQuery( ".slider_price_max" ).val( jQuery( ".slider-range-price" ).slider( "values", 1 ) );
}
</script>
</body></html>