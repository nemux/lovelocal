<?
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
//ini_set("display_errors","On");
include_once("../administrador/php/config.php");
include_once("../administrador/php/func.php");
include_once("../administrador/php/func_bd.php");
$p_per=isset($_GET["per"]) ? $_GET["per"]*1 : "";
if(!empty($p_per)):
	$c_per=buscar("per.id_perfil
						,per.email
						,per.sitio_web
						,per.horario
						,per.telefono
						,per.local
						,per.imagen
						,per.calle
						,per.no_exterior
						,per.no_interior
						,per.colonia
						,per.municipio
						,est.estado
						,per.codigo_postal
						,per.descripcion_corta
						,per.descripcion_completa
						,per.precio_de
						,per.precio_a
						,per.perfil
						,(SELECT(
								SUM(eva_per.evaluacion) / COUNT(eva_per.id_evaluacion)
								)
							FROM evaluaciones_perfiles eva_per
							WHERE eva_per.id_perfil=per.id_perfil) AS promedio_evaluacion
						,(SELECT COUNT(eva_per2.id_evaluacion)
							FROM evaluaciones_perfiles eva_per2
							WHERE eva_per2.id_perfil=per.id_perfil) AS numero_evaluacion"
						,"perfiles per
						LEFT OUTER JOIN
						estados est
						ON est.id_estado=per.id_estado"
						,"WHERE per.id_perfil='".$p_per."'",false);
	while($f_per=$c_per->fetch_assoc()):
		$id_perfil=$f_per["id_perfil"];
	$email=cadena($f_per["email"]);
	$sitio_web=cadena($f_per["sitio_web"]);
	$telefono=cadena($f_per["telefono"]);
	$horario=cadena($f_per["horario"]);
	$precio_de=cadena($f_per["precio_de"]);
	$precio_a=cadena($f_per["precio_a"]);
		$local=cadena($f_per["local"]);
		$imagen_perfil=$f_per["imagen"];
		$calle=cadena($f_per["calle"]);
		$no_exterior=cadena($f_per["no_exterior"]);
		$no_interior=cadena($f_per["no_interior"]);
		$colonia=cadena($f_per["colonia"]);
		$municipio=cadena($f_per["municipio"]);
		$estado=cadena($f_per["estado"]);
		$codigo_postal=cadena($f_doc["codigo_postal"]);
		$descripcion_corta_perfil=cadena($f_per["descripcion_corta"],false);
		$descripcion_completa_perfil=cadena($f_per["descripcion_completa"],true);
		$promedio_evaluacion=$f_per["promedio_evaluacion"];
		$numero_evaluacion=$f_per["numero_evaluacion"];
		$perfil=$f_per["perfil"];
	endwhile;
	//$ruta=urlencode("http://lovelocal.mx/perfil/?per=".$id_perfil."&perfil=".$local);
	$ruta="http://www.lovelocal.mx/perfil/?per=".$id_perfil."&perfil=".$local;
	$ruta_imagen="";
	if(!empty($imagen_perfil) and file_exists("../administrador/perfiles/images/".$imagen_articulo)):
		//$ruta_imagen=urlencode("http://lovelocal.mx/administrador/perfiles/images/".$imagen_perfil);	
		$ruta_imagen="http://www.lovelocal.mx/administrador/perfiles/images/".$imagen_perfil;	
	endif;
endif;


$direccion="";
$direccion_mostrar="";
if(!empty($calle)):
	$direccion_mostrar.=", ".$calle;
	$direccion.=$calle." ";
endif;
if(!empty($no_exterior)):
	$direccion_mostrar.=", #".$no_exterior;
	$direccion.=" ".$no_exterior.", ";
endif;
if(!empty($no_interior)):
	$direccion_mostrar.=", ".$no_interior;
	//$direccion.=" ".$no_interior.", ";
endif;
if(!empty($colonia)):
	$direccion_mostrar.=", ".$colonia;
	$direccion.=$colonia.", ";
endif;
if(!empty($municipio)):
	$direccion_mostrar.=", ".$municipio;
	$direccion.=$municipio." ";
endif;
if(!empty($estado)):
	$direccion_mostrar.=", ".$estado;
	$direccion.=$estado.", ";
endif;
if(!empty($codigo_postal)):
	$direccion_mostrar.=", C.P. ".$codigo_postal;
	//$direccion.="C.P. ".$codigo_postal;
endif;

?>
<!doctype html>
<html>
<head>
<title><? if(!empty($local)): echo $local." - ";endif;?>LoveLocal</title> 
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
<meta property="og:title"         content="<?=$local?>" />
<? /*
<meta property="og:description"   content="<?=$local?>" />
*/
if(!empty($ruta_imagen)):
	?>
   <meta property="og:image" content="<?=$ruta_imagen?>" />
   <link href="<?=$ruta_imagen?>" rel="image_src"/>
   <?
endif;
?>
<!-- Favicon -->
<link rel="shortcut icon" href="http://www.lovelocal.mx/images/favicon.png">
<link rel="stylesheet" href="../css/bootstrap.min.css">
<link rel="stylesheet" href="../css/main.css" id="color-switcher-link">
<link rel="stylesheet" href="../css/animations.css">
<link rel="stylesheet" href="../css/fonts.css">
<script src="../js/vendor/modernizr-2.6.2.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<!--<script src="http://consultatudoc.com.mx/calendar/js/jquery-1.11.1.min.js" language="javascript" type="text/javascript"></script>-->
<!--[if lt IE 9]> <script src="js/vendor/html5shiv.min.js"></script> <script src="js/vendor/respond.min.js"></script><![endif]-->
<script type='text/javascript' data-cfasync='false' src='//dsms0mj1bbhn4.cloudfront.net/assets/pub/shareaholic.js' data-shr-siteid='b62717da79586728048c38b77c540a91' async='async'></script>
</head>
<body><!--[if lt IE 9]> <div class="bg-danger text-center">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/" class="highlight">upgrade your browser</a> to improve your 
experience.</div><![endif]-->
<div class="boxed pattern8" id="canvas">
	<div class="container" id="box_wrapper">
   		<?
		include_once("../inc/header.php");
		include_once("../inc/form_busqueda_horizontal2.php");
		?>
      <section id="content" class="ls section_padding_bottom_75">
          <div class="container">
              <div class="row">
              	<!--Imagen de portada-->
              	<div class="col-sm-12 nopadding imgfull">
              			
              			<?php
						if(!empty($imagen_perfil) and file_exists("../administrador/perfiles/images/".$imagen_perfil)):
							?>
                                 <div style="overflow:hidden; height:300px">
                                     <img src="http://www.lovelocal.mx/administrador/perfiles/images/<?=$imagen_perfil?>" class="attachment-shop_single wp-post-image" alt="<?=$local?>" title="<?=$local?>" rel="image_src">
                                </div>
                                 
                        <?php
							endif;
						?>
						<div class="efectslide">
						<!--Evaluaciones-->
						<?
								if(!empty($local)):
								?>
	                              <h1 itemprop="name" class="titleslide"><?=$local?></h1>                                 
                                 <?
										endif;
								?>
      						  	<p class="subtitle"><?=substr($direccion_mostrar,2)?>
      						  		
      						  	<?php 
                                 if($telefono != '')
                                 {
                                 ?>
                                 
                                 	<strong>Telefono: </strong><?php echo $telefono; ?>
                                 
                                 <?php 
                                 }
                                 ?>
      						  	</p>
      						  	
                              <div class="product-rating" itemprop="aggregateRating" itemscope="" itemtype="http://schema.org/AggregateRating">
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
											?>
                                  <span class="review-links">
                                      <a href="#comments" class="review-link" rel="nofollow">
                                          <span itemprop="reviewCount" class="count">Calificación <?=$promedio_evaluacion?> de 5 estrellas</span>
                                      </a>
                                  </span> 
                                      <!--<span class="grey"> | </span>
                                      <a href="#respond" class="review-link" rel="nofollow">
                                          Realizar evaluación
                                      </a> 
                                  </span>-->
                                  
                              </div>
						<!--End Evaluaciones-->
						</div>
				</div>

                  <div class="col-sm-12 col-md-12 col-lg-12">
                  	  <div class="col-sm-2">
                  	  			<!--<h5 class="topmargin_20">Comparte:</h5>-->
                             	<!--Shareaholic-->
                                <?php 
                                 if($precio_de != '')
                                 {
                                 ?>
                                 <strong class="product-option-name grey">Precios</strong>
                                 <p>
                                 	Desde <strong><?php echo $precio_de; ?></strong> hasta
                                 	<strong><?php echo $precio_a; ?></strong> 
                                 </p>
                                 <?php 
                                 }
                                 ?>

                                <?
                                if($perfil=="Perfil 2" or $perfil=="Perfil 3"){

										$c_cat_pro=buscar("DISTINCT tipo","productos_perfiles","WHERE id_perfil='".$p_per."' AND tipo<>'' ORDER BY tipo ASC");
										if($c_cat_pro->num_rows>0):
											while($f_cat_pro=$c_cat_pro->fetch_assoc()):
												$tipo_producto=$f_cat_pro["tipo"];
												?>
                                    <!--
                                    <strong class="product-option-name grey">Productos / Servicios</strong>
                                    -->
                                    <strong class="product-option-name grey"><?=$tipo_producto?>s</strong>                                    
                                    <?
                                    $c_pro=buscar("producto"
                                                   ,"productos_perfiles"
                                                   ,"WHERE id_perfil='".$p_per."'
																	 AND tipo='".$tipo_producto."'");
                                    if($c_pro->num_rows>0):
                                      while($f_pro=$c_pro->fetch_assoc()):
                                          $producto=cadena($f_pro["producto"]);
                                          ?>
                                         <div class="checkbox">
                                             <label>
                                             <? if($tipo_producto == 'Servicio')
                                             {?>
                                             <img src="http://www.lovelocal.mx/img/services/<?=$producto?>.png" style="height:25px !important" /> 
                                             <?php 
                                         		}
                                         	 ?>
                                             <?=$producto?>
                                             </label>
                                         </div>
                                          <?
                                          unset($producto);
                                       endwhile;
                                    endif;
												unset($tipo_producto);
											endwhile;
										endif;
									}//End if perfil 2 y 3
										?>
                  	  </div>
                  	  <div class="col-sm-6">
                  	  <div class='shareaholic-canvas' data-app='share_buttons' data-app-id='25891808'></div>
                  	  <div itemscope="" itemtype="http://schema.org/Product" class="product type-product row">
                  	  <!-- Descripcion -->
                  	  <div itemprop="offers" itemscope="" itemtype="http://schema.org/Offer">
	                             	<div class="">
	                             	<h3 class="bottommargin_10 topmargin_10 blue">ACERCA DE NOSOTROS</h3>
      									<?
										/*if(!empty($descripcion_completa_perfil) and $descripcion_completa_perfil!="<br>"):*/
												?>
                                     <!--<div itemprop="description">
                                         <p><?=$descripcion_completa_perfil?></p>
                                     </div>-->
                                    <?//elseif
											if(!empty($descripcion_corta_perfil)):
												?>
                                    <div itemprop="description">
                                    	<p><?=$descripcion_corta_perfil?></p>
                                     </div>
                                    <?
											endif;
											?>
                                 </div>
                                
                                 <!--<div class="clearfix">&nbsp;</div>-->
                                 
                                  
                              </div>
                              <!-- Categorias -->
                              <?php
										
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
                                 <!--<div class="product_meta">
                                  <span class="posted_in">
                                      <span class="grey">Categorías:</span> 
                                      <? echo substr($lista_categorias,2);?>
                                  </span>
                                 </div>-->
                                 <?php
										endif;
								 ?>


								 <!-- Cupon -->
								<?
								if($perfil=="Perfil 1" or $perfil=="Perfil 2" or $perfil=="Perfil 3"){
								//Buscar recompensa inicial
								$c_reg=buscar("id_regalo,regalo","regalos_perfiles","WHERE id_perfil='".$id_perfil."' AND estatus='activo'",false);
								if($c_reg->num_rows>0):
									while($f_reg=$c_reg->fetch_assoc()):
										$id_regalo=$f_reg["id_regalo"];
										$regalo=cadena($f_reg["regalo"]);
									endwhile;
									if(!empty($id_regalo) and !empty($regalo)):
										if(empty($se_id_cliente) and empty($se_usuario_cliente) and empty($se_password_cliente)):
											?>
								<a href="../registro-clientes/?per=<?=$id_perfil?>">		
                              <div class="cs shop-teaser cuponicon">
                                 <? 
                                 /*
                                   <span>Subtotal: 339$</span>
                                   <h3 class="grey margin_0">Grand Total: $339</h3>
                                 */
                                 ?>
                                <div class="textcupon"><?=$regalo?></div>
                                
                              </div>
                              </a>
                              <p class="notedesc">¡Este descuento es el primero de muchos! Recuerda que cada vez que reseñas un negocio, ganas  más descuentos.</p>
                              <p><a href="../registro-clientes/?per=<?=$id_perfil?>">Regístrate en lovelocal.mx y descarga tu Cupón.</a></p>

                              <?
										else:
											$c_reg_cli=buscar("COUNT(id_registro) AS total_regalos","regalos_clientes","WHERE id_regalo='".$id_regalo."' AND id_cliente='".$se_id_cliente."'");
											while($f_reg_cli=$c_reg_cli->fetch_assoc()):
												$total_regalos=$f_reg_cli["total_regalos"];
											endwhile;
											if(empty($total_regalos)):
												?>
                                 <div id="message_cupon"></div>
                                    <div id="div_cupon">

                                    <p><a class="descarga_cupon theme_button divider_20 descarga_promocion" style="display:block; width:50%; margin:0px auto;" id_perfil="<?=$id_perfil?>" id_regalo="<?=$id_regalo?>" href="#">DESCARGA TU Cupón</a></p>
                                    
                                    <p class="notedesc">¡Este descuento es el primero de muchos! Recuerda que cada vez que reseñas un negocio, ganas  más descuentos.</p>
                                    <a class="descarga_cupon descarga_promocion" style="display:block; width:50%; margin:0px auto;" id_perfil="<?=$id_perfil?>" id_regalo="<?=$id_regalo?>" href="#">

                                    <div class="cs shop-teaser cuponicon">
                                       <div class="textcupon"><?=$regalo?></div>
                                       
                                    </div>
                                    </a>
                                 </div>
                                 
                              	<?
											endif;
										endif;
									endif;
									unset($id_regalo,$regalo);
								endif;
							}//End perfil 2 y 3
								?>
											
											

								 <!-- Promociones -->
                      <?php
							  if($perfil=="Perfil 2" or $perfil=="Perfil 3"){		
							  //Buscar promociones
                              $c_pro=buscar("pro.id_promocion,pro.promocion,pro.imagen,pro.descripcion_corta","promociones_perfiles pro","WHERE pro.id_perfil='".$p_per."' AND estatus='Activo' ORDER BY pro.id_promocion DESC",false);
                              if($c_pro->num_rows>0):
                                 ?>
                                 <h3 class="bottommargin_10 topmargin_10 blue">PROMOCIONES</h3>
                                 <p class="notedesc">Nuestra especialidad es consentirte, además de nuestros descuentos te ofrecemos estas promociones:</p>
                                 
                                 <?
											//$promociones_pendientes=0;
											if(empty($se_id_cliente) and empty($se_usuario_cliente) and empty($se_password_cliente)):
												?>
												<p><a href="../registro-clientes/?per=<?=$id_perfil?>">Regístrate en lovelocal.mx y descarga tu promoción.</a></p>
												<div class="clearfix"></div>
												
												<?
												/*
											else:
												
												//Consultar promociones pendientes de este perfil
												$c_pro_pen=buscar("COUNT(id_registro) AS promociones_pendientes","promociones_clientes","WHERE id_perfil='".$p_per."' AND id_cliente='".$se_id_cliente."' AND estatus='En proceso'");
												while($f_pro_pen=$c_pro_pen->fetch_assoc()):
													$promociones_pendientes=$f_pro_pen["promociones_pendientes"];
												endwhile;
												if(!empty($promociones_pendientes)):
													?>
                                       <div class="alert alert-info">
                                       	Tienes promociones pendientes de este Perfil. Te recomendamos usarlas para poder descargar nuevas promociones.
                                       </div>
													<?
												endif;
												$c_pro_pen->free();
												*/
											endif;											
											?>
                                 <div id="message_promocion"></div>
                                 <div id="div_promociones" class="isotope masonry-layout row ls_fondo4">
                                    <?
                                    $cont = 1;
                                    while($f_pro=$c_pro->fetch_assoc()):
                                       $id_promocion=$f_pro["id_promocion"];
                                       $promocion=cadena($f_pro["promocion"]);
                                       $imagen_promocion=$f_pro["imagen"];
                                       $descripcion_corta_promocion=cadena($f_pro["descripcion_corta"]);
													?>
													<a class="descarga_promocion" id_perfil="<?=$id_perfil?>" id_promocion="<?=$id_promocion?>" href="#">
													<article class="isotope-item col-lg-6 col-md-6 col-sm-6 col-xs-12 post format-standard">
                                       	<?
														if(!empty($imagen_promocion) and file_exists("../administrador/promociones/images/".$imagen_promocion)):
															?>
                                             <div class="entry-thumbnail imgpromocion imgprod" style="height:165px">
                                                 <!--<a href="../administrador/promociones/images/<?=$imagen_promocion?>" class="zoom first" title="<?=$promocion?>" data-gal="prettyPhoto[promocion]">-->
                                                    <img src="../administrador/promociones/images/<?=$imagen_promocion?>" class="attachment-shop_thumbnail" alt="<?=$promocion?>">
                                                 <!--</a>-->

                                 <!--<header class="promociontexto entry-header">
									<?
									if(!empty($promocion)):
									?>
                                         <h4 class="white">
                                             <?=$promocion?>
                                         </h4>
									<?
										endif;
									?>												
								<!--</header>-->
							  	<!-- .entry-header -->

															</div>
         												<?
														endif;
														?>
														<div class="promociondetalle post-content">
															<div class="entry-content">
																<?
																if(!empty($promocion)):
																?>
							                                         <h4 style="margin:0px">
							                                             <?=$promocion?>
							                                         </h4>
																<?
																	endif;
																?>	                                                
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
                                                      <div class="theme_button divider_20">Descargar promoción</div>
                                                      

                                                      <?
																		/*
                                                   endif;
																	$c_pro_cli->free();
																	unset($total_promociones);
																	*/
                                               endif;
                                               ?>
															 </div><!-- .entry-content -->
														</div><!-- .post-content -->
													</article>
													</a>
													<!-- .post -->                         
													<?
													if ($cont == 2)
														{ $cont = 0;
															echo '<div style="clear:both"></div>';
														}
													$cont++;

                                       unset($id_promocion,$promocion,$imagen_promocion,$descripcion_corta_promocion);
                                    endwhile;
                                    ?>
                                 </div>
                                 <?
											//unset($promociones_pendientes);
                              endif; 
										$c_pro->free();
									}//End perfil 2 y 3
										?>
                              <!-- Evaluacion -->
                              <div class="" id="respond">
                      	<?
								if((!empty($se_id_cliente) and !empty($se_usuario_cliente) and !empty($se_password_cliente))or
									(!empty($se_id_cliente) and !empty($se_id_facebook) and !empty($se_email_cliente))
									):
									//Buscar datos del cliente
									$c_cli=buscar("usuario,email","clientes","WHERE id_cliente='".$se_id_cliente."'");
									while($f_cli=$c_cli->fetch_assoc()):
										$usuario_cliente=cadena($f_cli["usuario"]);
										$email_cliente=$f_cli["email"];
									endwhile;
									?>
                           <h1 class="blue center">¿Has visitado <?php echo $local; ?>?</h1>
                           <!--<p>
                              Realiza tu evaluación y registrate de forma rápida y automática. <br>
                              Para tener acceso a tus recompensas termina de llenar tus datos dentro de tu perfil y listo, disfruta de los beneficios Ziikfor
                           </p>-->
                           <p class="notedesc">¡Tu opinión es muy valiosa!, cada vez que calificas uno de los negocios afiliados te ganas un nuevo descuento para conocer otro comercio de la colonia.</p>
                            <div class="table-responsive">
                                 <table class="stars">
                                     <!--<tr>
                                         <td>1 Estrella</td>
                                         <td>2 Estrellas</td>
                                         <td>3 Estrellas</td>
                                         <td>4 Estrellas</td>
                                         <td>5 Estrellas</td>
                                     </tr>-->
                                     <tr>
                                     	 <td height="50">
                                     	 Asigna una calificación
                                     	 </td>
                                         <td>
                                             <a id="estrella1" class="calificacion star-1" estrella="1" href="#">1</a>
                                         </td>
                                         <td>
                                             <a id="estrella2" class="calificacion star-1" estrella="2" href="#">2</a>
                                         </td>
                                         <td>
                                             <a id="estrella3" class="calificacion star-1" estrella="3" href="#">3</a>
                                         </td>
                                         <td>
                                             <a id="estrella4" class="calificacion star-1" estrella="4" href="#">4</a>
                                         </td>
                                         <td>
                                             <a id="estrella5" class="calificacion star-1" estrella="5" href="#">5</a>
                                         </td>
                                     </tr>
                                 </table>
                             </div>
                             <div id="message_evaluacion"></div>
                             <form class="comment-form" id="commentform">
                             	<?
										if(!empty($usuario_cliente)):
											?>
                                 <p class="comment-form-author">
                                     <label>Usuario: </label>
                                     <?=$usuario_cliente?>
                                 </p>
                                 <?
										endif;
										?>
                                 <p class="comment-form-email">
                                     <label>Email: </label>
                                     <?=$email_cliente?>
                                 </p>
                                 <p class="comment-form-chat">
                                     <label for="comentario">Comentario</label>
                                     <textarea aria-required="true" rows="4" cols="45" name="comentario" id="comentario" class="form-control" placeholder="Comentario"></textarea>
                                 </p>
                                 <p class="form-submit topmargin_10">
                                 	<input type="hidden" name="calificacion" id="calificacion">
                                    <input type="hidden" name="id_perfil" id="id_perfil" value="<?=$p_per?>">
                                    <button type="button" id="submit" name="submit" class="theme_button">Enviar evaluación</button>
                                 </p>
                             </form>
                           <?
								else:
									?>
									<h1 class="blue center">¿Has visitado <?php echo $local; ?>?</h1>
                           <p><a href="../registro-clientes/?per=<?=$id_perfil?>">Regístrate en lovelocal.mx y realiza tu evaluación.</a></p>
                           <p>¡Tu opinión es muy valiosa!, cada vez que calificas uno de los negocios afiliados te ganas un nuevo descuento para conocer otro comercio de la colonia.</p>
                           <!--<p>
                           	Para tener acceso a tus recompensas termina de llenar tus datos dentro de tu perfil y listo, disfruta de los beneficios Ziikfor.
                           </p>-->
                           <?
								endif;
								?>
                      </div>
                      <!-- #respond -->
                      <?php
                      if($perfil=="Perfil 3"){	
										
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
                                             	<? /*
                                                 <a href="../administrador/articulos/images/<?=$imagen_articulo?>" class="zoom first" title="<?=$articulo?>" data-gal="prettyPhoto[article-gallery]">
                                                    <img src="../administrador/articulos/images/<?=$imagen_articulo?>" class="attachment-shop_thumbnail" alt="<?=$articulo?>">
                                                 </a>
																 */ ?>
                                                 <a href="../detalle-articulo/?art=<?=$id_articulo?>&articulo=<?=$articulo?>" title="<?=$articulo?>">
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
                          }
                          if($perfil=="Perfil 3"){	
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
							}   
							?>                
                              
                      <!-- End Videos -->
                      </div>
                      <!--Productos-->
                      <?
                                if($perfil=="Perfil 3"){
                                		$contprod = 1;
										$c_cat_pro=buscar("DISTINCT tipo","productos_perfiles","WHERE id_perfil='".$p_per."' AND tipo='Producto' ORDER BY tipo ASC");
										if($c_cat_pro->num_rows>0):
											while($f_cat_pro=$c_cat_pro->fetch_assoc()):
												$tipo_producto=$f_cat_pro["tipo"];
												
												?>
                                    
                                    <strong class="product-option-name grey" style="border-bottom: 0px"><?=$tipo_producto?>s</strong>
                                    <br />                                    
                                    <?
                                    $c_pro=buscar("producto, imagen, descripcion_corta"
                                                   ,"productos_perfiles"
                                                   ,"WHERE id_perfil='".$p_per."'
																	 AND tipo='".$tipo_producto."'");
                                    if($c_pro->num_rows>0):
                                      while($f_pro=$c_pro->fetch_assoc()):
                                       $producto=cadena($f_pro["producto"]);
                                       $imagen_producto=$f_pro["imagen"];
                                       $descripcion_corta_producto=cadena($f_pro["descripcion_corta"]);
                                       if ($contprod == 3) {
                                       	$contprod = 1;
                                       	echo '<div style="clear:both"></div>';
                                       }
                                          ?>
                                       
     <article class="isotope-item col-lg-6 col-md-6 col-sm-6 col-xs-12 post format-standard">
     <div class="entry-thumbnail imgpromocion imgprod" style="height:165px">
     	  <a href="../administrador/productos/images/<?=$imagen_producto?>" class="zoom first" title="<?=$producto?>" data-gal="prettyPhoto[productos]">
          <img  src="../administrador/productos/images/<?=$imagen_producto?>" class="attachment-shop_thumbnail" alt="<?=$producto?>">
          </a>
       		
	 </div>
	 
       <div class="promociondetalle post-content">
				<div class="entry-content"> 
				<h4 style="margin:0px"><?=$producto?></h4>
					<?
                    if(!empty($descripcion_corta_producto) and $descripcion_corta_producto!="<br>"):
                       ?>
                       <p><?=$descripcion_corta_producto?></p>
                       <?
                    endif;
                    ?>
				</div>
		</div>
</article>

                                         
                                          <?
                                          unset($producto);
                                          $contprod++;
                                       endwhile;
                                    endif;
												unset($tipo_producto);
											endwhile;
										endif;
									}//End if perfil 2 y 3
										?>

                  	  </div>
                  	  <div class="col-sm-4">
                  	  <h1 class="blue">Visitanos en:</h1>
                  	  <section id="map" class="ls ms"></section>
                  	  <br />
                  	  <?php 
                  	  				  
									  if(!empty($direccion)):
										  	$direccion_mostrar.=", México";
										  	$direccion.="México";
											?>
                                 <!--<h3>Ubicación</h3>-->
                                 <p>
                                 <?=substr($direccion_mostrar,2)?>
                                 </p>
                                 <?php 
                                 if($horario != '')
                                 {
                                 ?>
                                 <p>
                                 	<strong>Horario: </strong><?php echo $horario; ?>
                                 </p>
                                 <?php 
                                 }
                                 ?>
                                 <?php 
                                 if($telefono != '')
                                 {
                                 ?>
                                 <p>
                                 	<strong>Telefono: </strong><?php echo $telefono; ?>
                                 </p>
                                 <?php 
                                 }
                                 ?>
                                 <?php 
                                 if($email != '')
                                 {
                                 ?>
                                 <p>
                                 	<strong>Correo Electronico: </strong><?php echo $email; ?>
                                 </p>
                                 <?php 
                                 }
                                 ?>
                                 <?php 
                                 if($sitio_web != '' && $sitio_web != '<br>')
                                 {
                                 ?>
                                 <p>
                                 	<strong>Sitio web: </strong><?php echo $sitio_web; ?>
                                 </p>
                                 <?php 
                                 }
                                 ?>
					                  
                                 <?
									  endif;
							     if($perfil=="Perfil 2" or $perfil=="Perfil 3"){
								?>
								
								<!-- Galeria de Imagenes -->
								<h1 class="blue">Galeria de Fotos</h1>
								<div class="images">
                          		<?
										if(!empty($imagen_perfil) and file_exists("../administrador/perfiles/images/".$imagen_perfil)):
											?>
                                 <a href="../administrador/perfiles/images/<?=$imagen_perfil?>" itemprop="image" class="main-image zoom" title="" data-gal="prettyPhoto[product-gallery]">
         									<? /*
                                     <span class="onsale">Sale</span>
         
                                     <span class="newproduct">New</span>
                                   	*/ ?>
                                     <img src="http://www.lovelocal.mx/administrador/perfiles/images/<?=$imagen_perfil?>" class="attachment-shop_single wp-post-image" alt="<?=$local?>" title="<?=$local?>" rel="image_src">
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
								 }//End perfil 2 y 3
								 ?>	
									  
                             	
                                                      
                              <div class="product-icons row">
                                  
                              </div>
                          </div> <!-- eof .images -->
                  	  </div>
                  	  
                     
                      
                  </div> <!--eof .col-sm-12 (main content)-->
              </div>
          </div>
      </section>
   <?
	include_once("../inc/publicidad.php");
	include_once("../inc/copyright.php");
	?>
	</div><!-- eof #box_wrapper -->
</div>
<script>
jQuery(function($){
	$(document).ready(function(){
		configuracion_descarga_promocion();
		$(".descarga_cupon").click(
			function(event){
				event.preventDefault();
				var id_perfil=new Number($(this).attr("id_perfil"))*1;
				var id_regalo=new Number($(this).attr("id_regalo"))*1;
				if(id_perfil>0 && id_regalo>0){
					$.ajax({
						data:{id_perfil:id_perfil,id_regalo:id_regalo},
						url:'../inc/ajax_generar-cupon.php',
						type:  'post',
						beforeSend: function () {
							$("#message_cupon").html("<div class=\"alert alert-info\">Generando cupón, espera por favor...</div>");
						},
						success:function(response){
							$("#message_cupon").html(response);
							if($('#message_cupon div.alert-success').length){
								$("#div_cupon").empty();
							}
						}
					});
				}
			}
		);
		function configuracion_descarga_promocion(){
			$(".descarga_promocion").on("click",
				function(event){
					event.preventDefault();
					var id_perfil=new Number($(this).attr("id_perfil"))*1;
					var id_promocion=new Number($(this).attr("id_promocion"))*1;
					if(id_perfil>0 && id_promocion>0){
						$.ajax({
							data:{id_perfil:id_perfil,id_promocion:id_promocion},
							url:'../inc/ajax_generar-cupon-promocion.php',
							type:  'post',
							beforeSend: function () {
								$("#message_promocion").html("<div class=\"alert alert-info\">Generando cupón de promoción, espera por favor...</div>");
							},
							success:function(response){
								$("#message_promocion").html(response);
								if($('#message_promocion div.alert-success').length){
									consultar_promociones(id_perfil);
									//$("#div_promociones").empty();
								}
							}
						});
					}
				}
			);				
		}
		function consultar_promociones(id_perfil){
			var id_perfil=new Number(id_perfil)*1;
			if(id_perfil>0){
				$.ajax({
					data:{id_perfil:id_perfil},
					url:'../inc/ajax_front_consultar-promociones.php',
					type:  'post',
					beforeSend: function () {
						$("#div_promociones").empty().html("<div class=\"alert alert-info\">Consultando promociones, espera por favor...</div>");
					},
					success:function(response){
						$("#div_promociones").html(response);
						configuracion_descarga_promocion()
					}
				});
			}
		}
		$('.calificacion').on('click', function(e){
			e.preventDefault();
			var estrella=new Number($(this).attr("estrella"))*1;
			if(estrella>0){
				$("#calificacion").val(estrella);
				/*$(".calificacion").css("color","#fa5c5d");
				$(this).css("color","#03538E");*/
				$(".calificacion").css("color","#ed7221");
				var est = estrella;
				while (est > 0)
				{
					$("#estrella"+est).css("color","#03538E");
					est = est - 1;
				}
				$(this).css("color","#03538E");
			}
		});
		$('#submit').on('click',function(e){
			e.preventDefault();
			var usuario="";
			var email="";
			var id_perfil=new Number($("#id_perfil").val())*1;
			var calificacion=new Number($("#calificacion").val())*1;
			var comentario=$("#comentario").val();
			var error=false;
			$("#message_evaluacion").html("");
			if(($("#usuario").length)>0 && ($("#email").length)>0){
				usuario=$("#usuario").val();
				email=$("#email").val();			
				if(usuario==""){
					$("#message_evaluacion").append("<div class=\"alert alert-warning\">Es necesario que captures un usuario.</div>");
					error=true;
				}
				if(email==""){
					$("#message_evaluacion").append("<div class=\"alert alert-warning\">Es necesario que captures un email.</div>");
					error=true;				
				}
				else{
					if(!ValidateEmail(email)){
						$("#message_evaluacion").append("<div class=\"alert alert-warning\">Es necesario que captures un email válido.</div>");
						error=true;
					}
				}
			}
			if(calificacion==0){
				$("#message_evaluacion").append("<div class=\"alert alert-warning\">Es necesario que realices tu evaluación.</div>");
			}
			if(id_perfil>0 && calificacion>0 && error==false){
				jQuery.ajax({
					data:{usuario:usuario,email:email,id_perfil:id_perfil,calificacion:calificacion,comentario:comentario},
					url:'../inc/ajax_agregar_evaluacion.php',
					type:  'post',
					beforeSend: function () {
						$("#message_evaluacion").html("<div class=\"alert alert-info\">Enviando evaluación, espera por favor...</div>");
					},
					success:function(response){
						$("#message_evaluacion").html(response);
						if($("#usuario").length>0 && $("#email").length>0){
							$("#usuario").val("");
							$("#calificacion").val("");
							$("#comentario").val("");
							$(".calificacion").css("color","#fa5c5d");
						}
					}
				});
			}
		});	
		function ValidateEmail(email) {
        var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        return expr.test(email);
	    };
	}); //end of "document ready" event
});
</script>
<script src="../js/compressed.js"></script>
<script src="../js/main.js"></script>
<? /*
<script type="text/javascript">
"use strict";
jQuery(document).ready(function() {				 
	jQuery(".descarga_cupon").click(
		function(event){
			event.preventDefault();
			
		}
	);
});	 
<?
*/
if(!empty($direccion)):
	?>
	<!-- Map Scripts -->
   <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=true&key=AIzaSyCCgRjnO4H9xH86BMJly-rvnjxhBy6oyJo"></script>
   <script type="text/javascript">
      var lat;
      var lng;
      var map;
      var styles = [{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#060606"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#03538E"},{"visibility":"on"}]}];
      
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
              center: center/*,
              styles: styles*/
          };
          map = new google.maps.Map(document.getElementById('map'), settings);
          
         var image = {
             url: 'http://www.lovelocal.mx/images/icon_ziikfor.png',
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
</body>
</html>