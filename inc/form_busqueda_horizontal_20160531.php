<section id="mainteasers" class="cs section_padding_0 columns_padding_5 table_section table_section_lg">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 bg_teaser after_cover color_bg_1">
                <div class="teaser_content media">
                    <div class="media-body">
                        <form class="order-form text-center" id="order_form" action="../resultado_busqueda" method="get">
                        	<div class="col-md-4">
                               <div class="form-group">
                                   <label for="fullname">Nombre</label>
                                   <input type="text" class="form-control" id="buscar" name="buscar" placeholder="¿Qué estás buscando?" value="<?=cadena($p_buscar);?>" required>
                               </div>
                          	</div>
                        	<div class="col-md-4">                           
                               <div class="form-group">
                                   <label for="department">Lugar</label>
                                   <input type="text" class="form-control" id="lugar" name="lugar" value="<?=cadena($p_lugar);?>" placeholder="¿En dónde?">
                                   <!--
                                   <select class="form-control" name="department" id="department" placeholder="¿En dónde?">
                                       <option></option>
                                   </select>
                                   -->
                               </div>
                            </div>
                        	<div class="col-md-4">                           
	                           <button type="submit" class="theme_button">ZiiKIT!</button>
                           </div>                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>