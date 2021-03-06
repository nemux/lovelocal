<?
//ini_set("display_errors","On");
include_once("../administrador/php/config.php");
include_once("../administrador/php/func.php");
include_once("../administrador/php/func_bd.php");
$p_per=isset($_GET["per"]) ? $_GET["per"]*1 : "";
if(!empty($p_per)):
	$c_per=buscar("per.id_perfil
						,per.local
						,per.imagen
						,per.calle
						,per.no_exterior
						,per.no_interior
						,per.colonia
						,per.municipio
						,est.estado
						,doc.codigo_postal
						,per.descripcion_corta
						,per.descripcion_completa"
						,"perfiles per
						LEFT OUTER JOIN
						estados est
						ON est.id_estado=per.id_estado"
						,"WHERE per.id_perfil='".$p_per."'",false);
	while($f_per=$c_per->fetch_assoc()):
		$id_perfil=$f_per["id_perfil"];
		$local=cadena($f_per["local"]);
		$imagen_perfil=$f_per["imagen"];
		$calle=cadena($f_per["calle"]);
		$no_exterior=cadena($f_per["no_exterior"]);
		$no_interior=cadena($f_per["no_interior"]);
		$colonia=cadena($f_per["colonia"]);
		$municipio=cadena($f_per["municipio"]);
		$estado=cadena($f_per["estado"]);
		$codigo_postal=cadena($f_doc["codigo_postal"]);
		$descripcion_corta_perfil=cadena($f_per["descripcion_corta"],true);
		$descripcion_completa_perfil=cadena($f_per["descripcion_completa"],true);
	endwhile;
endif;
?>
<!DOCTYPE html> <html class="no-js">
<head>
<title><? if(!empty($local)): echo $local." - ";endif;?>ZiiKFOR</title> 
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
      
      <section id="content" class="ls section_padding_top_15 section_padding_bottom_75">
          <div class="container">
              <div class="row">
                  <div class="col-sm-12 col-md-12 col-lg-12">
                      <div itemscope="" itemtype="http://schema.org/Product" class="product type-product row">
      
                          <div class="images col-sm-4">
                          		<?
										if(!empty($imagen_perfil) and file_exists("../administrador/perfiles/images/".$imagen_perfil)):
											?>
                                 <a href="../administrador/perfiles/images/<?=$imagen_perfil?>" itemprop="image" class="main-image zoom" title="" data-gal="prettyPhoto[product-gallery]">
         									<? /*
                                     <span class="onsale">Sale</span>
         
                                     <span class="newproduct">New</span>
                                   	*/ ?>
                                     <img src="../administrador/perfiles/images/<?=$imagen_perfil?>"  class="attachment-shop_single wp-post-image" alt="<?=$local?>" title="<?=$local?>">
                                 </a>
                                 <?
										endif;
										
										//Buscar galeria de perfil
										$c_gal=buscar("foto,titulo","fotos_perfiles","WHERE id_perfil='".$p_per."'");
										if($c_gal->num_rows>0):
											?>
                                 <div id="product-thumbnails" class="owl-carousel thumbnails product-thumbnails" 
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
												$foto=$f_gal["foto"];
												$titulo_foto=cadena($f_gal["titulo"]);
												if(!empty($foto) and file_exists("../administrador/galeria_fotos/images/".$foto)):
													?>
                                        <a href="../administrador/galeria_fotos/images/<?=$foto?>" class="zoom first" title="<?=$titulo_foto?>" data-gal="prettyPhoto[product-gallery]">
                                           <img src="../administrador/galeria_fotos/images/<?=$foto?>" class="attachment-shop_thumbnail" alt="<?=$titulo_foto?>">
                                        </a>
                                       <?
												endif;
												unset($foto,$titulo_foto);
											endwhile;
											?>
                                 </div>
                                 <?
										endif;
									  ?>
                             <div class="product_meta">
                               <span class="posted_in">
                                   <span class="grey">Dirección:</span>
                                   <? 
											  $direccion="";
											  if(!empty($calle)):
													echo $calle;
													$direccion.=$calle." ";
											  endif;
											  if(!empty($no_exterior)):
													echo " #".$no_exterior.", ";
													$direccion.=" ".$no_exterior.", ";
											  endif;
											  if(!empty($no_interior)):
												 	echo " ".$no_interior.", ";
												 	//$direccion.=" ".$no_interior.", ";
											  endif;
											  if(!empty($colonia)):
													echo $colonia.", ";
												 	$direccion.=$colonia.", ";
											  endif;
											  if(!empty($municipio)):
													echo $municipio.", ";
												 	$direccion.=$municipio." ";
											  endif;
											  if(!empty($estado)):
													echo $estado.", ";
												 	$direccion.=$estado.", ";
											  endif;
											  if(!empty($codigo_postal)):
													echo "C.P. ".$codigo_postal;
												 	//$direccion.="C.P. ".$codigo_postal;
											  endif;
											  ?>
                               </span>
                              </div>
                             <?
									  if(!empty($direccion)):
										  	$direccion.="México";
											?>
                                 <h3>Ubicación</h3>
					                  <section id="map" class="ls ms"></section>
                                 <?
									  endif;
										/*
                              <div class="product-icons row">
                                  <div class="col-xs-4">
                                      <div class="teaser text-center">
                                          <div class="teaser_icon main_bg_color size_small">
                                              <i class="rt-icon2-heart2"></i>
                                          </div>
                                          <h5>
                                              <a href="#">Whishlist</a>
                                          </h5>
                                      </div>
                                  </div>
      
                                  <div class="col-xs-4">
                                      <div class="teaser text-center">
                                          <div class="teaser_icon main_bg_color size_small">
                                              <i class="rt-icon2-gallery"></i>
                                          </div>
                                          <h5>
                                              <a href="#">Compare</a>
                                          </h5>
                                      </div>
                                  </div>
      
                                  <div class="col-xs-4">
                                      <div class="teaser text-center">
                                          <div class="teaser_icon main_bg_color size_small">
                                              <i class="rt-icon2-globe-outline"></i>
                                          </div>
                                          <h5>
                                              <a href="#">Share</a>
                                          </h5>
                                      </div>
                                  </div>
                              </div>
                              */
										?>
                          </div> <!-- eof .images -->
      
                          <div class="summary entry-summary col-sm-8">
      								<?
										if(!empty($local)):
											?>
	                              <h1 itemprop="name" class="product_title entry-title"><?=$local?></h1>                                 
                                 <?
										endif;
										?>
      
                              <div class="product-rating" itemprop="aggregateRating" itemscope="" itemtype="http://schema.org/AggregateRating">
      
                                  <div class="star-rating" title="Rated 4.50 out of 5">
                                      <span style="width:90%">
                                          <strong class="rating">4.50</strong> out of 5
                                      </span>
                                  </div>
      
                                  <span class="review-links pull-right">
                                      <a href="#comments" class="review-link" rel="nofollow">
                                          <span itemprop="reviewCount" class="count">3</span> evaluacion(es)
                                      </a> 
      
                                      <span class="grey"> | </span>
      
                                      <a href="#respond" class="review-link" rel="nofollow">
                                          Realizar evaluación
                                      </a> 
                                  </span>
      
                              </div>
      
                              <div itemprop="offers" itemscope="" itemtype="http://schema.org/Offer">
      									<?
											if(!empty($descripcion_completa_perfil) and $descripcion_completa_perfil!="<br>"):
												?>
                                     <div itemprop="description">
                                         <p><?=$descripcion_completa_perfil?></p>
                                     </div>
                                    <?
											elseif(!empty($descripcion_corta_perfil)):
												?>
                                    <div itemprop="description">
                                    	<p><?=$descripcion_corta_perfil?></p>
                                     </div>
                                    <?
											endif;
											/*
											?>
      
                                  <ul class="list1 no-bullets">
                                      <li>
                                          <p class="price">
                                              <del>
                                                  <span class="amount">$3.00</span>
                                              </del> 
                                              <ins>
                                                  <span class="amount">$2.00</span>
                                              </ins>
                                          </p>
      
                                          <meta itemprop="price" content="2">
      
                                          <meta itemprop="priceCurrency" content="USD">
      
                                          <link itemprop="availability" href="http://schema.org/InStock">
      
                                          <p class="stock"><span class="grey">Availability:</span> In Stock</p>
                                          <!-- <p class="stock out-of-stock"><span class="grey">Availability:</span> <span class="highlight">Out Of Stock</span></p> -->
      
                                          <div class="email-to">
                                              <a href="#" class="email-to-link" rel="nofollow">
                                                  Email to a Friend
                                              </a> 
                                          </div>
                                      </li>
                                  </ul>
      
                                  <form class="cart" method="post" enctype="multipart/form-data">
                                      <div class="form-group">
                                          <label for="product_size" class="grey bold">Size</label> <span class="red">*</span>
                                          <select class="form-control" id="product_size">
                                              <option>1</option>
                                              <option>2</option>
                                              <option>3</option>
                                              <option>4</option>
                                              <option>5</option>
                                          </select>
                                      </div>
      
                                      <strong class="product-option-name grey">Color</strong> <span class="red">*</span>
      
                                      <div class="radio">
                                          <label>
                                              <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
                                              Grey
                                          </label>
                                      </div>
                                      <div class="radio">
                                          <label>
                                              <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                                              Magenta
                                          </label>
                                      </div>
      
                                      <strong class="product-option-name grey">Other Options</strong>
      
                                      <div class="checkbox">
                                          <label>
                                              <input type="checkbox" value="">
                                              Option one
                                          </label>
                                      </div>
                                      <div class="checkbox">
                                          <label>
                                              <input type="checkbox" value="">
                                              Option two
                                          </label>
                                      </div>
      
      
                                      <strong class="product-option-name grey">Select Delivery Date</strong>
      
                                      <div class="form-inline">
                                          <div class="form-group">
                                              <select class="form-control">
                                                  <option value="" selected="">-</option>
                                                  <option value="">1</option>
                                                  <option value="">2</option>
                                                  <option value="">3</option>
                                                  <option value="">4</option>
                                                  <option value="">5</option>
                                                  <option value="">6</option>
                                              </select>
                                          </div>
      
                                          <div class="form-group">
                                              <select class="form-control">
                                                  <option value="" selected="">-</option>
                                                  <option value="">1</option>
                                                  <option value="">2</option>
                                                  <option value="">3</option>
                                                  <option value="">4</option>
                                                  <option value="">5</option>
                                                  <option value="">6</option>
                                              </select>
                                          </div>
      
                                          <div class="form-group">
                                              <select class="form-control">
                                                  <option value="" selected="">-</option>
                                                  <option value="">1</option>
                                                  <option value="">2</option>
                                                  <option value="">3</option>
                                                  <option value="">4</option>
                                                  <option value="">5</option>
                                                  <option value="">6</option>
                                              </select>
                                          </div>
                                      </div>
      
                                      <strong class="product-option-name grey">Additional Comment</strong>
      
                                      <textarea class="form-control" rows="3"></textarea>
                                      <p>Maximum number of characters: <span id="char_left">500</span></p>
      
                                      <div class="pull-right">
                                          <label class="grey" for="product_quantity">Qty:</label>
      
                                          <span class="quantity form-group">
                                              <input type="button" value="-" class="minus">
                                              <input type="number" step="1" min="0" name="" value="1" title="Qty" id="product_quantity" class="form-control ">
                                              <input type="button" value="+" class="plus">
                                          </span>
                                      </div>
      
                                      <a href="#" rel="nofollow" class="theme_button add_to_cart_button">
                                          <i class="rt-icon2-cart"></i>
                                          Add to cart
                                      </a>
                                  </form>
                                  */
											 ?>
                                  
                              </div>
      								<?
										$c_pro=buscar("producto"
															,"productos_perfiles"
															,"WHERE id_perfil='".$p_per."'");
										if($c_pro->num_rows>0):
											?>
                                <strong class="product-option-name grey">Productos / Servicios</strong>
                                <?
										  while($f_pro=$c_pro->fetch_assoc()):
												$producto=cadena($f_pro["producto"]);
												?>
                                   <div class="checkbox">
                                       <label>
                                       <?=$producto?>
                                       </label>
                                   </div>
                                    <?
												unset($producto);
											endwhile;
										endif;
										
										$c_cat=buscar("cat.categoria"
															,"categorias_perfiles cat_per 
																LEFT OUTER JOIN categorias cat 
																ON cat.id_categoria=cat_per.id_categoria"
															,"WHERE cat_per.id_perfil='".$p_per."'");
										$lista_categorias="";
										while($f_cat=$c_cat->fetch_assoc()):
											$lista_categorias.=', <a href="#" rel="tag">'.cadena($f_cat["categoria"]).'</a>';
										endwhile;
										if(!empty($lista_categorias)):
											?>
                                 <div class="product_meta">
                                  <span class="posted_in">
                                      <span class="grey">Categorías:</span> 
                                      <? echo substr($lista_categorias,2);?>
                                  </span>
                                 </div>
                                 <?
										endif;
										
                              //Buscar videos recientes
                              $c_vid=buscar("vid.id_video,vid.titulo,vid.video","videos_perfiles vid","WHERE vid.id_perfil='".$p_per."' ORDER BY vid.id_video DESC",false);
                              if($c_vid->num_rows>0):
                                 ?>
                                 <h4 class="topmargin_30 bottommargin_10">Videos recientes</h4>
                                 <div id="isotope_container" class="isotope masonry-layout row ls_fondo4">
                                    <?
                                    while($f_vid=$c_vid->fetch_assoc()):
                                       $id_video=$f_vid["id_video"];
                                       $titulo_video=cadena($f_vid["titulo"]);
                                       $video=cadena($f_vid["video"]);
                                       $id_youtube=id_youtube($video);
                                       if(!empty($id_youtube)):
                                          ?>
                                          <article class="isotope-item col-lg-6 col-md-6 col-sm-6 col-xs-12 post format-standard">
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
                                 <?
                              endif;
										
										//Buscar artículos recientes
                              $c_art=buscar("art.id_articulo,art.articulo,art.imagen,art.descripcion_corta","articulos_perfiles art","WHERE art.id_perfil='".$p_per."' ORDER BY art.id_articulo DESC",false);
                              if($c_art->num_rows>0):
                                 ?>
                                 <h4 class="topmargin_20 bottommargin_10">Últimos artículos publicados</h4>
                                 <div id="isotope_container" class="isotope masonry-layout row ls_fondo4">
                                    <?
                                    while($f_art=$c_art->fetch_assoc()):
                                       $id_articulo=$f_art["id_articulo"];
                                       $articulo=cadena($f_art["articulo"]);
                                       $imagen_articulo=$f_art["imagen"];
                                       $descripcion_corta_articulo=cadena($f_art["descripcion_corta"]);
													?>
													<article class="isotope-item col-lg-4 col-md-6 col-sm-6 col-xs-12 post format-standard">
                                       	<?
														if(!empty($imagen_articulo) and file_exists("../administrador/articulos/images/".$imagen_articulo)):
															?>
                                             <div class="entry-thumbnail">
                                                 <a href="../administrador/articulos/images/<?=$imagen_articulo?>" class="zoom first" title="<?=$articulo?>" data-gal="prettyPhoto[article-gallery]">
                                                    <img src="../administrador/articulos/images/<?=$imagen_articulo?>" class="attachment-shop_thumbnail" alt="<?=$articulo?>">
                                                 </a>
															</div>
         												<?
														endif;
														?>
														<div class="post-content">
															 <div class="entry-content">
																  <header class="entry-header">
																		<? /*
																		<h3 class="entry-title">
																			 <a href="../detalle_articulo/" rel="bookmark">Duis autem vel eum iriure</a>
																		</h3> */
																		if(!empty($articulo)):
																			?>
																			<div class="entry-meta">
																				 <span class="author">
																					  <?=$articulo?>
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
                                                  <?
																  /*
																  if(!empty($descripcion_corta_articulo) and $descripcion_corta_articulo!="<br>"):
																  	?>
																	<p><?=$descripcion_corta_articulo?></p>
                                                   <?
																  endif;
																  */
																  ?>
																  <!-- .entry-header -->
															 </div><!-- .entry-content -->
														</div><!-- .post-content -->
													</article>
													<!-- .post -->                         
													<?
                                       unset($id_articulo,$articulo,$imagen_articulo,$descripcion_corta_articulo);
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
                                 <?
                              endif;          
										?>                    
                          </div><!-- .summary.col- -->
                      </div><!-- .product.row -->
                     <? /*
                      <!-- Nav tabs -->
                      <ul class="nav nav-tabs" role="tablist">
                          <li class="active"><a href="#details_tab" role="tab" data-toggle="tab">Details</a></li>
                          <li><a href="#additional_tab" role="tab" data-toggle="tab">Additional</a></li>
                          <li><a href="#reviews_tab" role="tab" data-toggle="tab">Reviews</a></li>
                          <li><a href="#custom_tab" role="tab" data-toggle="tab">Custom</a></li>
                      </ul>
      
                      <!-- Tab panes -->
                      <div class="tab-content top-color-border bottommargin_30">
      
                          <div class="tab-pane fade in active" id="details_tab">
      
                              <p>Duis autem veiudolorn hendrerit vulputate velit esse molestie. consequat, vel illum dolore eu feugiat nulla facilisis at vereros accumsan etiusto dignissim:</p>
      
                              <ul class="list1">
                                  <li>
                                      <a href="services.html">Lorem ipsum dolor sit amet</a>
                                  </li>
                                  <li>
                                      <a href="services.html">Sint animi non ut sed</a>
                                  </li>
                                  <li>
                                      <a href="services.html">Eaque blanditiis nemo</a>
                                  </li>
                                  <li>
                                      <a href="services.html">Amet, consectetur adipisicing</a>
                                  </li>
                                  <li>
                                      <a href="services.html">Blanditiis nemo quaerat</a>
                                  </li>
                              </ul>
      
                              <div class="well">
                                  <strong class="highlight2">Warning!</strong> Better check yourself, you're not looking too good.
                              </div>
      
                              <p>
                                  Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                  tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                  quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                  consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                  cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                  proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                              </p>
      
                          </div>
      
                          <div class="tab-pane fade" id="additional_tab">
      
                              <table class="table table-striped topmargin_30">
      
                                  <tr>
                                      <th class="grey">Product title:</th>
                                      <td>Product Name</td>
                                  </tr>
      
                                  <tr>
                                      <th class="grey">Item SKU:</th>
                                      <td>5552281538</td>
                                  </tr>
      
                                  <tr>
                                      <th class="grey">Brand:</th>
                                      <td><a href="#">Brand Name</a></td>
                                  </tr>
      
                                  <tr>
                                      <th class="grey">Style:</th>
                                      <td>SuperStyle</td>
                                  </tr>
      
                                  <tr>
                                      <th class="grey">Size:</th>
                                      <td>Middle</td>
                                  </tr>
      
                                  <tr>
                                      <th class="grey">Color:</th>
                                      <td>Black</td>
                                  </tr>
      
                                  <tr>
                                      <th class="grey">Targeted Group:</th>
                                      <td>All</td>
                                  </tr>
      
                              </table>
      
                          </div>
      
                          <div class="tab-pane fade" id="reviews_tab">
      
                                              <div class="comments-area" id="comments">
                          <ol class="comment-list">
                              <li class="comment">
                                  <article class="comment-body media">
                                      <a class="media-left" href="#">
                                          <img class="media-object" alt="" src="images/team/05.jpg">
                                      </a>
                                      <div class="media-body">
                                          <h4 class="media-heading">
                                              Nam liber tempor cum soluta nobis eleifend optionct volutpat
                                          </h4>
                                          <div class="comment-meta entry-meta">
                                              <span class="author">
                                                  <i class="rt-icon2-user2 highlight2"></i>
                                                  by 
                                                  <a href="blog-full.html">Admin</a>
                                              </span>
      
                                              <span class="date">
                                                  <time datetime="2015-03-09T15:05:23+00:00" class="entry-date">
                                                      <i class="rt-icon2-calendar5 highlight2"></i>
                                                      09.03.2015
                                                  </time>
                                              </span>
      
                                              <span class="reply">
                                                  <i class="rt-icon2-chat highlight2"></i>
                                                  <a href="#respond">Reply</a>
                                              </span>
                                          </div>
                                          <div class="comment-rating">
                                              <span class="grey">Customer Rating: </span>
                                              <div class="star-rating" title="Rated 4.50 out of 5">
                                                  <span style="width:90%">
                                                      <strong class="rating">4.50</strong> out of 5
                                                  </span>
                                              </div>
                                          </div>
                                          <p>First Level Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis.</p>
                                      </div>
                                  </article>
                                  <!-- .comment-body -->
                              </li>
                              <!-- #comment-## -->
      
                              <li class="comment">
                                  <article class="comment-body media">
                                      <a class="media-left" href="#">
                                          <img class="media-object" alt="" src="images/team/03.jpg">
                                      </a>
                                      <div class="media-body">
                                          <h4 class="media-heading">
                                              Cum soluta nobis eleifend optionct
                                          </h4>
                                          <div class="comment-meta entry-meta">
                                              <span class="author">
                                                  <i class="rt-icon2-user2 highlight2"></i>
                                                  by 
                                                  <a href="blog-full.html">Admin</a>
                                              </span>
      
                                              <span class="date">
                                                  <time datetime="2015-03-09T15:05:23+00:00" class="entry-date">
                                                      <i class="rt-icon2-calendar5 highlight2"></i>
                                                      09.03.2015
                                                  </time>
                                              </span>
      
                                              <span class="reply">
                                                  <i class="rt-icon2-chat highlight2"></i>
                                                  <a href="#respond">Reply</a>
                                              </span>
                                          </div>                              
                                          <div class="comment-rating">
                                              <span class="grey">Customer Rating: </span>
                                              <div class="star-rating" title="Rated 4.50 out of 5">
                                                  <span style="width:90%">
                                                      <strong class="rating">4.50</strong> out of 5
                                                  </span>
                                              </div>
                                          </div>
                                          <p>First Level Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis.</p>
                                      </div>
                                  </article>
                                  <!-- .comment-body -->
                              </li>
                              <!-- #comment-## -->
      
                              <li class="comment">
                                  <article class="comment-body media">
                                      <a class="media-left" href="#">
                                          <img class="media-object" alt="" src="images/team/01.jpg">
                                      </a>
                                      <div class="media-body">
                                          <h4 class="media-heading">
                                              Eleifend optionct volutpat
                                          </h4>
                                          <div class="comment-meta entry-meta">
                                              <span class="author">
                                                  <i class="rt-icon2-user2 highlight2"></i>
                                                  by 
                                                  <a href="blog-full.html">Admin</a>
                                              </span>
      
                                              <span class="date">
                                                  <time datetime="2015-03-09T15:05:23+00:00" class="entry-date">
                                                      <i class="rt-icon2-calendar5 highlight2"></i>
                                                      09.03.2015
                                                  </time>
                                              </span>
      
                                              <span class="reply">
                                                  <i class="rt-icon2-chat highlight2"></i>
                                                  <a href="#respond">Reply</a>
                                              </span>
                                          </div>                         
                                          <div class="comment-rating">
                                              <span class="grey">Customer Rating: </span>
                                              <div class="star-rating" title="Rated 4.50 out of 5">
                                                  <span style="width:90%">
                                                      <strong class="rating">4.50</strong> out of 5
                                                  </span>
                                              </div>
                                          </div>
                                          <p>First Level Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis.</p>
                                      </div>
                                  </article>
                                  <!-- .comment-body -->
                              </li>
                              <!-- #comment-## -->
      
      
                          </ol>
                          <!-- .comment-list -->
                      </div>
                      <!-- #comments --> 
      
                      <div class="comment-respond" id="respond">
                          <h3>Write Your Own Review</h3>
      
                          <div class="table-responsive">
                              <table class="table table-striped table-bordered text-center topmargin_30 stars">
                                  <tr>
                                      <td>1 Star</td>
                                      <td>2 Stars</td>
                                      <td>3 Stars</td>
                                      <td>4 Stars</td>
                                      <td>5 Stars</td>
                                  </tr>
      
                                  <tr>
                                      <td>
                                          <a class="star-1" href="#">1</a>
                                      </td>
                                      <td>
                                          <a class="star-2" href="#">2</a>
                                      </td>
                                      <td>
                                          <a class="star-3" href="#">3</a>
                                      </td>
                                      <td>
                                          <a class="star-4" href="#">4</a>
                                      </td>
                                      <td>
                                          <a class="star-5" href="#">5</a>
                                      </td>
                                  </tr>
                              </table>
                          </div>
      
                          <form class="comment-form" id="commentform" method="post" action="/">
                              <p class="comment-form-author">
                                  <label for="author">Name <span class="required">*</span></label>
                                  <input type="text" aria-required="true" size="30" value="" name="author" id="author" class="form-control" placeholder="Nickname">
                              </p>
                              <p class="comment-form-email">
                                  <label for="review_email">Email <span class="required">*</span></label>
                                  <input type="email" aria-required="true" size="30" value="" name="review_email" id="review_email" class="form-control" placeholder="Email">
                              </p>
                              <p class="comment-form-chat">
                                  <label for="comment">Review</label>
                                  <textarea aria-required="true" rows="8" cols="45" name="comment" id="comment" class="form-control" placeholder="Review"></textarea>
                              </p>
                              <p class="form-submit topmargin_40">
                                  <button type="submit" id="submit" name="submit" class="theme_button">Submit Review</button>
                              </p>
                          </form>
                      </div>
                      <!-- #respond -->
      
                          </div>
      
                          <div class="tab-pane fade" id="custom_tab">
      
                              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                  tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                  quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                  consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                  cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                  proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                              </p>
      
                          </div>
      
                      </div><!-- eof .tab-content -->
                      */
                      ?>
      
      
                  </div> <!--eof .col-sm-8 (main content)-->
                  
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
if(!empty($direccion)):
	?>
	<!-- Map Scripts -->
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
   <script type="text/javascript">
      var lat;
      var lng;
      var map;
      var styles = [{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#46bcec"},{"visibility":"on"}]}];
      
      //type your address after "address="
      jQuery.getJSON('http://maps.googleapis.com/maps/api/geocode/json?address=<?=$direccion?>&sensor=false', function(data) {
          lat = data.results[0].geometry.location.lat;
          lng = data.results[0].geometry.location.lng;
      }).complete(function(){
          dxmapLoadMap();
      });
   
      function attachSecretMessage(marker, message)
      {
          var infowindow = new google.maps.InfoWindow(
              { content: message
              });
          google.maps.event.addListener(marker, 'click', function() {
              infowindow.open(map,marker);
          });
      }
   
      window.dxmapLoadMap = function()
      {
          var center = new google.maps.LatLng(lat, lng);
          var settings = {
              mapTypeId: google.maps.MapTypeId.ROADMAP,
              zoom: 16,
              draggable: false,
              scrollwheel: false,
              center: center,
              styles: styles 
          };
          map = new google.maps.Map(document.getElementById('map'), settings);
          
         var image = {
             url: 'http://www.ziikfor.com/images/favicon.png.png',
             // This marker is 20 pixels wide by 32 pixels high.
             size: new google.maps.Size(20, 32),
             // The origin for this image is (0, 0).
             origin: new google.maps.Point(0, 0),
             // The anchor for this image is the base of the flagpole at (0, 32).
             anchor: new google.maps.Point(0, 32)
           };						 
   
          var marker = new google.maps.Marker({
              position: center,
              icon: image,
              <?
              if(!empty($local)):
               ?>
               title:'<?=$local?>',
               <?
              endif;
              ?>
              /*
              title: 'Map title',
              */
              map: map
          });
         <?
        if(!empty($local)):
         ?>
          marker.setTitle('<?=$local?>'.toString());
         <?
        endif;						 
        ?>
      //type your map title and description here
      attachSecretMessage(marker,'<? if(!empty($local)):?><h3><?=$local?></h3><? endif;?><p><?=$direccion?></p>');
      }
   </script>    
   <?
endif;
?>
<script src="../js/compressed.js"></script><script src="../js/main.js"></script>
</body></html>