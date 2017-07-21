<?
$c_pub=buscar("imagen,enlace","banners_publicitarios","WHERE estatus='activo' ORDER BY orden ASC");
if($c_pub->num_rows>0):
	?>
   <section id="tablero" class="ls  section_padding_top_5 section_padding_bottom_5 parallax">
      <div class="container">
         <div class="row">
             <div class="col-sm-12">
               <img src="../images/banner_publicitario.jpg">
             </div>
         </div>
      </div>
   </section>
   <?
endif;
?>	