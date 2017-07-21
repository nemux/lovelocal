<?
$c_pub=buscar("banner,imagen,enlace","banners_publicitarios","WHERE estatus='activo' ORDER BY orden ASC");
if($c_pub->num_rows>0):
	?>
   <section id="tablero" class="ls  section_padding_top_5 section_padding_bottom_5 parallax">
      <div class="container">
         <div class="row">
             <div class="col-sm-12">
					<div id="gallery-owl-carousel" class="owl-carousel" 
                data-nav="false" 
                data-items="1"
                data-responsive-lg="1"
                data-responsive-md="1"
                data-responsive-sm="1"
                data-responsive-xs="1"
                data-autoplay="true"
                data-loop="<? if($c_pub->num_rows>1):?>true<? else:?>false<? endif;?>"
                >
                	<?
						while($f_pub=$c_pub->fetch_assoc()):
							$banner=cadena($f_pub["banner"]);
							$imagen_pub=$f_pub["imagen"];
							$enlace_pub=trim(str_replace("<br>","",$f_pub["enlace"]));
							?>
                     <div class="gallery-item padding-item">
                        <div>
                            <div class="gallery-image">
                            	<?
										if(!empty($imagen_pub) and file_exists("../administrador/banners_publicitarios/images/".$imagen_pub)):
											if(!empty($enlace_pub)):
												?>
												<a href="<?=$enlace_pub?>" target="_blank">
													<img src="../administrador/banners_publicitarios/images/<?=$imagen_pub?>" alt="<?=$banner?>">
												</a>
												<?
											else:
												?>
												<img src="../administrador/banners_publicitarios/images/<?=$imagen_pub?>" alt="<?=$banner?>">
												<?
											endif;
										endif;
										?>
                            </div>
                        </div>
                    	</div>
                     <?
							unset($banner,$imagen_pub,$enlace_pub);
						endwhile;
						?>
                </div>   
             </div>
         </div>
      </div>
   </section>
   <?
endif;
?>