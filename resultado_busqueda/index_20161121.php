<?
session_start();
//ini_set("display_errors","On");
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
$campos=array("perfil","evaluacion","precio");
$orders=array("DESC","ASC");
$p_buscar=isset($_GET["buscar"]) ? cadenabd($_GET["buscar"]) : "";
$p_lugar=isset($_GET["lugar"]) ? cadenabd($_GET["lugar"]) : "";
$p_buscar2=isset($_GET["buscar2"]) ? cadenabd($_GET["buscar2"]) : "";
$p_precio=isset($_GET["precio"]) ? cadenabd($_GET["precio"]) : "";
$p_categorias=isset($_GET["categorias"])? explode(",",$_GET["categorias"]) : "";
$p_ubicaciones=isset($_GET["ubicaciones"])? explode(",",$_GET["ubicaciones"]) : "";
$p_orderby=isset($_GET["orderby"]) ? cadenabd($_GET["orderby"]) : array_random($campos);
$p_orden=isset($_GET["orden"]) ? cadenabd($_GET["orden"]) : array_random($orders);
$p_pag=isset($_GET["pag"]) ? $_GET["pag"]*1 : 0;
/*
echo "<br>Ubicaciones: ";
print_r($p_ubicaciones);
*/
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
                                      <option value="perfil" <? if($p_orderby=="perfil"): ?> selected <? endif;?>>Perfil</option>
                                      <option value="evaluacion" <? if($p_orderby=="evaluacion"): ?> selected <? endif;?>>Evaluación</option>
                                      <option value="precio" <? if($p_orderby=="precio"): ?> selected <? endif;?>>Precio</option>
                                  </select>
                              </div>
      								
                              <a href="#" id="sort_view">
											<i class="<? if($p_orden=="ASC"): ?> arrow-icon-down-small <? else: ?> arrow-icon-up-small <? endif;?>"></i>
                              </a>
                              
                              <a href="#" id="toggle_shop_view" class=""></a>
                              <div class="form-group pull-right">
                              	 <input type="hidden" name="orden" id="orden" value="<?=$p_orden?>">
											<? /*
                                  <label class="grey" for="showcount">Mostrar:</label>
                                  <select class="form-control showcount" name="showcount" id="showcount">
                                      <option value="menu_order" selected>8</option>
                                      <option value="popularity">12</option>
                                      <option value="rating">16</option>
                                      <option value="date">20</option>
                                      <option value="price">24</option>
                                      <option value="price-desc">28</option>
                                  </select>
											*/
											?>
                              </div>
                          </form>
      
                      </div>
                      <div class="columns-3">
                          <?
								  	//Buscar perfiles
								  	$con_per="WHERE per.estatus='activo'";
								  	if(!empty($p_buscar)):
							  			$con_per.=" AND (per.local LIKE '%".$p_buscar."%'
														OR (SELECT COUNT(cat_per.id_categoria) 
																FROM categorias_perfiles cat_per 
																LEFT OUTER JOIN 
																	categorias cat 
																ON	cat.id_categoria=cat_per.id_categoria
																WHERE cat_per.id_perfil=per.id_perfil 
																AND cat.categoria LIKE '%".$p_buscar."%')>0
													";
										if(!empty($p_buscar2)):
											$con_per.=" OR per.local LIKE '%".$p_buscar2."%'
															OR (SELECT COUNT(cat_per.id_categoria) 
																FROM categorias_perfiles cat_per 
																LEFT OUTER JOIN 
																	categorias cat 
																ON	cat.id_categoria=cat_per.id_categoria
																WHERE cat_per.id_perfil=per.id_perfil 
																AND cat.categoria LIKE '%".$p_buscar2."%')>0
											";
										endif;
										$con_per.=")";
									elseif(!empty($p_buscar2)):
										$con_per.=" AND (per.local LIKE '%".$p_buscar2."%'
														OR (SELECT COUNT(cat_per.id_categoria) 
																FROM categorias_perfiles cat_per 
																LEFT OUTER JOIN 
																	categorias cat 
																ON	cat.id_categoria=cat_per.id_categoria
																WHERE cat_per.id_perfil=per.id_perfil 
																AND cat.categoria LIKE '%".$p_buscar2."%')>0
														)";
								  	endif;
									if(!empty($p_lugar)):
										$con_per.=" AND(per.calle LIKE '%".$p_lugar."%'
														OR per.colonia LIKE '%".$p_lugar."%'
														OR per.municipio LIKE '%".$p_lugar."%'
														OR	est.estado LIKE '%".$p_lugar."%'
														)";
									endif;
									if(!empty($p_precio) and $p_precio<>"Todos"):
										//Obtener rangos precios
										$rango=explode("-",$p_precio);
										if(count($rango)>0):
											$de=$rango[0];
											$a=$rango[1];
											if($a=="adelante"):
												$con_per.=" AND (per.precio_de>=0 AND per.precio_a>='".$de."')";
											else:
												$con_per.=" AND (per.precio_de<='".$a."' AND per.precio_a>='".$de."')";
											endif;
											unset($de,$a);
										endif;
										unset($rango);
									endif;
									if(!empty($p_categorias) and count($p_categorias)>0):
										$sel_cat="";
										foreach($p_categorias as $id_categoria):
											if(!empty($id_categoria)):
												$sel_cat.=" OR (SELECT COUNT(cat_per.id_perfil) FROM categorias_perfiles cat_per WHERE cat_per.id_categoria='".$id_categoria."' AND cat_per.id_perfil=per.id_perfil)>0";												
											endif;
										endforeach;
										if(!empty($sel_cat)):
											$con_per.=" AND (";
											$sel_cat=substr($sel_cat,4);
											$con_per.=$sel_cat;
											$con_per.=")";
										endif;
									endif;
									if(!empty($p_ubicaciones) and count($p_ubicaciones)>0):
										$sel_ubi="";
										foreach($p_ubicaciones as $ubicacion):
											if(!empty($ubicacion)):
												$sel_ubi.=" OR per.municipio='".cadenabd($ubicacion)."'";												
											endif;
										endforeach;
										if(!empty($sel_ubi)):
											$con_per.=" AND (";
											$sel_ubi=substr($sel_ubi,4);
											$con_per.=$sel_ubi;
											$con_per.=")";
										endif;
									endif;
									$c_reg=buscar("per.*","perfiles per LEFT OUTER JOIN estados est ON est.id_estado=per.id_estado",$con_per,false);
                          	$num_total_registros=$c_reg->num_rows;
								  if($num_total_registros>0):
										//Limito la busqueda
										$TAMANO_PAGINA=8;
										$pagina = false;
									
										//examino la pagina a mostrar y el inicio del registro a mostrar
										$pagina=isset($_GET["pagina"]) ? $_GET["pagina"] : false;
											  
										if(!$pagina):
											$inicio = 0;
											$pagina = 1;
										else:
											$inicio = ($pagina - 1) * $TAMANO_PAGINA;
										endif;
										
										//calculo el total de paginas
										$total_paginas = ceil($num_total_registros / $TAMANO_PAGINA);
										
										$ord_per="";
										switch($p_orderby):
											case "evaluacion":
												$ord_per.=" ORDER BY promedio_evaluacion ".$p_orden;
											break;
											case "precio":
												$ord_per.=" ORDER BY per.precio_de ".$p_orden.",per.precio_a ".$p_orden;
											break;
											case "perfil":
												$ord_per.=" ORDER BY per.local ".$p_orden;
											break;
										endswitch;
										$limit=" LIMIT ".$inicio.",".$TAMANO_PAGINA;
										
									  	$c_per=buscar("per.id_perfil
														,per.local
														,per.imagen
														,per.descripcion_corta
														,per.precio_de
														,per.precio_a
														,per.municipio
														,(SELECT(
																SUM(eva_per.evaluacion) / COUNT(eva_per.id_evaluacion)
																)
															FROM evaluaciones_perfiles eva_per
															WHERE eva_per.id_perfil=per.id_perfil) AS promedio_evaluacion"
														,"perfiles per LEFT OUTER JOIN estados est ON est.id_estado=per.id_estado"
														,$con_per.$ord_per.$limit,false);
										if($c_per->num_rows>0):
											?>
                                 <h2 class="topmargin_0"> RESULTADOS EN ZIIKFOR <?=$inicio+1?> a <?=$inicio+$c_per->num_rows?> de <?=$num_total_registros?></h2>
                                 <ul id="products" class="products list-unstyled list-view">
                                    <?
                                    while($f_per=$c_per->fetch_assoc()):
                                       $id_perfil=$f_per["id_perfil"];
                                       $local_perfil=cadena($f_per["local"]);
                                       $imagen_perfil=$f_per["imagen"];
                                       $descripcion_corta_perfil=cadena($f_per["descripcion_corta"]);
                                       $precio_de_perfil=$f_per["precio_de"];
                                       $precio_a_perfil=$f_per["precio_a"];
                                       $municipio_perfil=cadena($f_per["municipio"]);
                                       $promedio_evaluacion=$f_per["promedio_evaluacion"];
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
                                                      /*
                                                      if(!empty($municipio_perfil)):
                                                         ?>
                                                         <div class="product_meta">
                                                          <span class="posted_in">
                                                              <span class="grey">Ubicación: <?=$municipio_perfil?></span> 
                                                          </span>
                                                         </div>
                                                         <?
                                                      endif;
                                                      */
                                                      ?>
                                                   </div>
                                                   <div class="col-md-7">
                                                       <h3>
                                                           <a href="../perfil/?per=<?=$id_perfil?>&perfil=<?=$local_perfil?>"><?=$local_perfil?></a>
                                                       </h3>
                                                       <?
                                                       if(!empty($promedio_evaluacion)):
                                                         ?>
                                                          <div class="star-rating" title="Evaluación <?=$promedio_evaluacion?> de 5">
                                                              <span style="width:<?=($promedio_evaluacion*100)/5?>%">
                                                                  <strong class="rating"><?=$promedio_evaluacion?></strong> de 5
                                                              </span>
                                                          </div>
                                                         <?
                                                       endif;
                                                       if(!empty($precio_de_perfil) and !empty($precio_a_perfil)):
                                                         ?>
                                                         <span class="price">
                                                           <ins>
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
                                                           </ins>
                                                         </span>                                                      
                                                         <?
                                                       endif;
   
                                                       if(!empty($descripcion_corta_perfil)):
                                                         ?>
                                                          <p class="product-description">
                                                              <?=$descripcion_corta_perfil?>
                                                          </p>
                                                         <?
                                                       endif;
                                                         $c_cat=buscar("cat.categoria"
                                                                        ,"categorias_perfiles cat_per 
                                                                           LEFT OUTER JOIN categorias cat 
                                                                           ON cat.id_categoria=cat_per.id_categoria"
                                                                        ,"WHERE cat_per.id_perfil='".$id_perfil."'");
                                                         $lista_categorias="";
                                                         while($f_cat=$c_cat->fetch_assoc()):
                                                            $lista_categorias.=', <a href="#" rel="tag">'.cadena($f_cat["categoria"]).'</a>';
                                                         endwhile;
                                                         $c_cat->free();
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
                                                       ?>
                                                       <a href="../perfil/?per=<?=$id_perfil?>&perfil=<?=$local_perfil?>" rel="nofollow" class="theme_button inverse add_to_cart_button">
                                                       Más información
                                                       </a>
                                                   </div>
                                               </div>
                                           </div>
                                       </li>
                                       <?
                                       unset($id_perfil,$local_perfil,$imagen_perfil,$descripcion_corta_perfil,$precio_de_perfil,$precio_a_perfil,$municipio_perfil,$promedio_evaluacion,$lista_categorias);
                                    endwhile;
                                 	?>
											</ul>
                                 <?
										endif;
									else:
										?>
                              <h2 class="topmargin_0">No se encontró ningún resultado con los parámetros seleccionados.</h2>
                              <?
								  endif;
								  ?>
                      </div> <!-- eof .columns-* -->
                      
                      <?
                      if($total_paginas>1):
							 	?>
                        <div class="row">
                             <div class="col-sm-12">
                                 <ul class="pagination">
                                 	<?
												if($pagina!= 1):
													?>
													<li><a href="#" pagina="<?=$pagina-1?>"><i class="arrow-icon-left-open-3"></i></a></li>
													<?
												endif;
												for($i=1;$i<=$total_paginas;$i++):
													if ($pagina == $i):
														//si muestro el índice de la página actual, no coloco enlace
														?>
														<li class="active"><a href="#" pagina="<?=($pagina)?>"><?=$pagina?></a></li>
														<?
													else:
														//si el índice no corresponde con la página mostrada actualmente,
														//coloco el enlace para ir a esa página
														?>
														<li><a href="#" pagina="<?=($i)?>"><?=$i?></a></li>
														<?
													endif;
												endfor;
												if ($pagina != $total_paginas):
													?>
													<li><a href="#" pagina="<?=($pagina+1)?>"><i class="arrow-icon-right-open-3"></i></a></li>
													<?
												endif;
												?>
                                 </ul>
                             </div>
                         </div>
                        <?
							 endif;
							 ?>
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
               
              <div class="form-group">
                  <label class="grey" for="precio"></label>
                  <select class="form-control" name="precio" id="precio">
							<option>Todos</option>
                     <option value="1-100" <? if($p_precio=="1-100"): ?> selected <? endif;?>>$1 - $100</option>
                     <option value="100-200" <? if($p_precio=="100-200"): ?> selected <? endif;?>>$100 - $200</option>                     
                     <option value="200-300" <? if($p_precio=="200-300"): ?> selected <? endif;?>>$200 - $300</option>
                     <option value="300-400" <? if($p_precio=="300-400"): ?> selected <? endif;?>>$300 - $400</option>                     
                     <option value="400-500" <? if($p_precio=="400-500"): ?> selected <? endif;?>>$400 - $500</option>
                     <option value="500-600" <? if($p_precio=="500-600"): ?> selected <? endif;?>>$500 - $600</option>                     
                     <option value="600-700" <? if($p_precio=="600-700"): ?> selected <? endif;?>>$600 - $700</option>
                     <option value="700-800" <? if($p_precio=="700-800"): ?> selected <? endif;?>>$700 - $800</option>
                     <option value="800-900" <? if($p_precio=="800-900"): ?> selected <? endif;?>>$800 - $900</option>
                     <option value="900-1000" <? if($p_precio=="900-1000"): ?> selected <? endif;?>>$900 - $1000</option>
                     <option value="1000-adelante" <? if($p_precio=="1000-adelante"): ?> selected <? endif;?>>$1000 - en adelante</option>
                 	</select>
              </div>
              <div class="text-right">
                  <button type="button" class="theme_button inverse filtrar">Filtrar</button>
              </div>
          </form>
      </div>
      
		<div class="widget widget_layered_nav widget_categories">
			<h3 class="widget-title">Categorías</h3>
         <?
			$c_cat=buscar("DISTINCT cat_per.id_categoria
								,cat.categoria
								,(SELECT COUNT(cat_per2.id_perfil) 
									FROM categorias_perfiles cat_per2 
									WHERE cat_per2.id_categoria=cat_per.id_categoria) AS total_perfiles"
								,"categorias_perfiles cat_per 
									LEFT OUTER JOIN categorias cat 
									ON cat.id_categoria=cat_per.id_categoria"
								,"ORDER BY cat.categoria ASC");
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
                     <div class="checkbox">
                        <label>
                            <input name="categorias[]" value="<?=$id_categoria?>" type="checkbox" <? if(!empty($p_categorias) and count($p_categorias)>0 and in_array($id_categoria,$p_categorias)==true): ?> checked <? endif;?>>
                            <?=$categoria?>
                        </label>
                     </div>                  
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
			$con_ubi="";
			if(!empty($p_lugar)):
				$con_ubi.="WHERE est.estado LIKE '%".$p_lugar."%'";
			endif;
			$con_ubi.="ORDER BY per.municipio ASC";
         $c_ubi=buscar("DISTINCT per.municipio"
								,"perfiles per
									LEFT OUTER JOIN
									estados est
									ON est.id_estado=per.id_estado"
								,$con_ubi);
			if($c_ubi->num_rows>0):
				?>
             <ul>
             	<?
					while($f_ubi=$c_ubi->fetch_assoc()):
						$municipio=cadena($f_ubi["municipio"]);
						/*
						?>
                  <li>
                     <a class="ubicacion" ubicacion="<?=$municipio?>"><?=$municipio?></a>
                     <span>(<?=$total_perfiles?>)</span>
                  </li>
                  <?
						*/
						?>
						<li>
                     <div class="checkbox">
                        <label>
                            <input name="ubicaciones[]" value="<?=$municipio?>" type="checkbox" <? if(!empty($p_ubicaciones) and count($p_ubicaciones)>0 and in_array($municipio,$p_ubicaciones)==true): ?> checked <? endif;?>>
                            <?=$municipio?>
                        </label>
                     </div>                  
                  </li>                  
                  <?
						unset($municipio);
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
<script src="../js/compressed.js"></script><script src="../js/main.js"></script>
<script>
jQuery(document).ready(function(){
   jQuery('.filtrar').on('click', function(e){
		e.preventDefault();
		filtrar(1);
	});
	function filtrar(pagina){
		var buscar=jQuery("#buscar").val();
		var lugar=jQuery("#lugar").val();
		var buscar2=jQuery("#buscar2").val();
		var precio=jQuery("#precio").val();
	  	var categorias=[];
		var ubicaciones=[];
		var orderby=jQuery("#orderby").val();
		var orden=jQuery("#orden").val();		
		var pagina=pagina;
		jQuery("input[name='categorias[]']:checked").each(function(){
			categorias.push(parseInt(jQuery(this).val()));
		});
		jQuery("input[name='ubicaciones[]']:checked").each(function(){
			ubicaciones.push(jQuery(this).val());
		});
		jQuery(location).attr('href','../resultado_busqueda/?buscar='+buscar+"&lugar="+lugar+"&buscar2="+buscar2+"&precio="+precio+"&categorias="+categorias+"&ubicaciones="+ubicaciones+"&orderby="+orderby+"&orden="+orden+"&pagina="+pagina);
	}
	jQuery('#sort_view').on('click', function(e){
		var orden=jQuery("#orden").val();
		if(orden=="ASC"){
			jQuery('#sort_view').html('<i class="arrow-icon-up-small"></i>');
			jQuery("#orden").val("DESC");
		}
		else{
			jQuery('#sort_view').html('<i class="arrow-icon-down-small"></i>');
			jQuery("#orden").val("ASC");
		}
		filtrar(1);
	});
	jQuery('.pagination a').on('click', function(e){
		var pagina=jQuery(this).attr("pagina");
		filtrar(pagina);
	});
}); //end of "document ready" event
</script>
</body></html>