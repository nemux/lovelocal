"use strict";
function pieChart() {
	
	//circle progress bar
	if (jQuery().easyPieChart) {
		var count = 0 ;
		// var colors = ['#55bce9', '#7370b5', '#6496cf'];
		var colors = ['#55bce9'];

		jQuery('.chart').each(function(){
			
			var imagePos = jQuery(this).offset().top;
			var topOfWindow = jQuery(window).scrollTop();
			if (imagePos < topOfWindow+900) {

				jQuery(this).easyPieChart({
			        barColor: colors[count],
					trackColor: '#ffffff',
					scaleColor: false,
					scaleLength: false,
					lineCap: 'butt',
					lineWidth: 20,
					size: 270,
					rotate: 0,
					animate: 3000,
					onStep: function(from, to, percent) {
							jQuery(this.el).find('.percent').text(Math.round(percent));
						}
			    });
			}
			count++;
			if (count >= colors.length) { count = 0};
		});
	}
}

//function that initiating template plugins on document.ready event
function documentReadyInit() {
	///////////
	//Plugins//
	///////////
    //contact form processing
    jQuery('form.contact-form').on('submit', function( e ){
        e.preventDefault();
        var $form = jQuery(this);
        jQuery($form).find('span.contact-form-respond').remove();
        //checking on empty values
        var formFields = $form.serializeArray();
        for (var i = formFields.length - 1; i >= 0; i--) {
        	if (!formFields[i].value.length) {
        		$form.find('[name="' + formFields[i].name + '"]').addClass('invalid').on('focus', function(){jQuery(this).removeClass('invalid')});
        	};
        };
        //if one of form fields is empty - exit
        if ($form.find('[name]').hasClass('invalid')) {
        	return;
        };
        //sending form data to PHP server if fields are not empty
        var request = $form.serialize();
        var ajax = jQuery.post( "contact-form.php", request )
            .done(function( data ) {
                jQuery($form).find('[type="submit"]').attr('disabled', false).parent().append('<span class="contact-form-respond highlight">'+data+'</span>');
        })
            .fail(function( data ) {
                jQuery($form).find('[type="submit"]').attr('disabled', false).parent().append('<span class="contact-form-respond highlight">Mail cannot be sent. You need PHP server to send mail.</span>');
        })
    });
    
    //mailchimp subscribe form processing
    jQuery('.signup').on('submit', function( e ) {
        e.preventDefault();
        var $form = jQuery(this);
        // update user interface
        $form.find('.response').html('Adding email address...');
        // Prepare query string and send AJAX request
        jQuery.ajax({
            url: 'mailchimp/store-address.php',
            data: 'ajax=true&email=' + escape($form.find('.mailchimp_email').val()),
            success: function(msg) {
                $form.find('.response').html(msg);
            }
        });
    });
	
	//twitter
	//slide tweets
	jQuery('#tweets .twitter').bind('loaded', function(){
		jQuery(this).addClass('flexslider').find('ul').addClass('slides');
	});
	if (jQuery().tweet) {
		jQuery('.twitter').tweet({
			modpath: "./twitter/",
		    count: 2,
		    avatar_size: 48,
		    loading_text: 'loading twitter feed...',
		    join_text: 'auto',
		    username: 'ThemeForest', 
		    template: "{avatar}<div class=\"tweet_right\">{time}{join}<span class=\"tweet_text\">{tweet_text}</span></div>"
		});
	}


	//mainmenu
	if (jQuery().superfish) {
		jQuery('ul.sf-menu').superfish({
			delay:       300,
			animation:   {opacity:'show'},
			animationOut: {opacity: 'hide'},
			speed:       'fast',
			disableHI:   false,
			cssArrows:   true,
			autoArrows:  true
		});
	}

		//toggle mobile menu
	jQuery('.toggle_menu').on('click', function(){
		jQuery('.toggle_menu').toggleClass('mobile-active');
		jQuery('.page_header').toggleClass('mobile-active');
	});

	jQuery('.mainmenu a').on('click', function(){
		if (!jQuery(this).hasClass('sf-with-ul')) {
			jQuery('.toggle_menu').toggleClass('mobile-active');
			jQuery('.page_header').toggleClass('mobile-active');
		}
	});
		
    
	//single page localscroll and scrollspy
	var navHeight = jQuery('.page_header').outerHeight(true);
	jQuery('body').scrollspy({
		target: '.mainmenu_wrapper',
		offset: navHeight
	});
	if (jQuery().localScroll) {
		jQuery('.mainmenu, #land').localScroll({
			duration:900,
			easing:'easeInOutQuart',
			offset: -navHeight+10
		});
	}

	////////////////////
	//header processing/
	////////////////////
		//stick header to top
			//wrap header with div for smooth sticking
	var $header = jQuery('.page_header').first();
	if ($header.length) {
		var headerHeight = $header.outerHeight();
		$header.wrap('<div class="page_header_wrapper"></div>').parent().css({height: headerHeight}); //wrap header for smooth stick and unstick
			//get offset
		var headerOffset = $header.offset().top;
		jQuery($header).affix({
			offset: {
				top: headerOffset,
				bottom: 0
			}
		});
			//if header has different height on afixed and affixed-top positions - correcting wrapper height
		jQuery($header).on('affixed-top.bs.affix', function () {
			$header.parent().css({height: $header.outerHeight()});
		});
	}

	//toTop
	if (jQuery().UItoTop) {
        jQuery().UItoTop({ easingType: 'easeOutQuart' });
    }

	//parallax
	if (jQuery().parallax) {
		jQuery('.parallax').parallax("50%", 0.02);
	}
	
    //prettyPhoto
    if (jQuery().prettyPhoto) {
	   	jQuery("a[data-gal^='prettyPhoto']").prettyPhoto({
	   		hook: 'data-gal',
			theme: 'facebook' /* light_rounded / dark_rounded / light_square / dark_square / facebook / pp_default*/
	  	});
	}


   	//carousel
   	if (jQuery().carousel) {
		jQuery('.carousel').carousel();
	}

	//owl carousel
	if (jQuery().owlCarousel) {
		jQuery('.owl-carousel').each(function() {
			var $carousel = jQuery(this);
			var loop = $carousel.data('loop') ? $carousel.data('loop') : false;
			var margin = ($carousel.data('margin') || $carousel.data('margin') == 0) ? $carousel.data('margin') : 30;
			var nav = $carousel.data('nav') ? $carousel.data('nav') : false;
			var dots = $carousel.data('dots') ? $carousel.data('dots') : false;
			var themeClass = $carousel.data('themeClass') ? $carousel.data('themeClass') : 'owl-theme';
			var center = $carousel.data('center') ? $carousel.data('center') : false;
			var items = $carousel.data('items') ? $carousel.data('items') : 4;
			var autoplay = $carousel.data('autoplay') ? $carousel.data('autoplay') : false;
			var responsiveXs = $carousel.data('responsive-xs') ? $carousel.data('responsive-xs') : 1;
			var responsiveSm = $carousel.data('responsive-sm') ? $carousel.data('responsive-sm') : 2;
			var responsiveMd = $carousel.data('responsive-md') ? $carousel.data('responsive-md') : 3;
			var responsiveLg = $carousel.data('responsive-lg') ? $carousel.data('responsive-lg') : 4;
			// var responsive = $carousel.data('responsive') ? jQuery.parseJSON($carousel.data('responsive')) : {0:{items:1},767:{items:2},992:{items:2},1200:{items: 4}};

			$carousel.owlCarousel({
				loop: loop,
				margin: margin,
				nav: nav,
				autoplay: autoplay,
				dots: dots,
				themeClass: themeClass,
				center: center,
				items: items,
				responsive: {
					0:{
						items: responsiveXs
					},
					767:{
						items: responsiveSm
					},
					992:{
						items: responsiveMd
					},
					1200:{
						items: responsiveLg
					}
				},
			});
		});

	} //eof owl-carousel
	
	//comingsoon counter
	if (jQuery().countdown) {
		//today date plus month for demo purpose
		var demoDate = new Date();
		demoDate.setMonth(demoDate.getMonth()+1);
		jQuery('#comingsoon-countdown').countdown({until: demoDate});
	}


	/////////
	//shop///
	/////////
	jQuery('#toggle_shop_view').on('click', function( e ) {
		e.preventDefault();
		jQuery(this).toggleClass('grid-view');
		jQuery('#products').toggleClass('grid-view list-view');
	});
	
	//zoom image
	if (jQuery().elevateZoom) {
		jQuery('#product-image').elevateZoom({
			gallery: 'product-image-gallery',
			cursor: 'pointer', 
			galleryActiveClass: 'active', 
			responsive:true, 
			loadingIcon: 'img/AjaxLoader.gif'
		});
	}
	
	//add review button
	jQuery('.review-link').on('click', function( e ) {
		var thisLink = jQuery(this);
		var reviewTabLink = jQuery('a[href="#reviews_tab"]');
		//show tab only if it's hidden
		if (!reviewTabLink.parent().hasClass('active')) {
			reviewTabLink
				.tab('show')
				.on('shown.bs.tab', function (e) {
					jQuery(window).scrollTo(jQuery(thisLink).attr('href'), 400);
				})
		}
		jQuery(window).scrollTo(jQuery(thisLink).attr('href'), 400);
	});

	//product counter
	jQuery('.plus, .minus').on('click', function( e ) {
		var numberField = jQuery(this).parent().find('[type="number"]');
		var currentVal = numberField.val();
		var sign = jQuery(this).val();
		if (sign === '-') {
			if (currentVal > 1) {
				numberField.val(parseFloat(currentVal) - 1);
			}
		} else {
			numberField.val(parseFloat(currentVal) + 1);
		}
	});
	
	//remove product from cart
	jQuery('a.remove').on('click', function( e ) {
		e.preventDefault();
		jQuery(this).closest('tr').remove();
	});

	//color filter 
	jQuery(".color-filters").find("a[data-background-color]").each(function() {
		jQuery(this).css({"background-color" : jQuery(this).data("background-color")});
	});

	//adding CSS classes for elements that needs different styles depending on they widht width
	//see 'plugins.js' file
	jQuery('#mainteasers .col-lg-4').addWidthClass({
		breakpoints: [500, 600]
	});


	//background image teaser
	jQuery(".bg_teaser").each(function(){
		var $teaser = jQuery(this);
		var imagePath = $teaser.find("img").first().attr("src");
		$teaser.css("background-image", "url(" + imagePath + ")");
		if (!$teaser.find('.bg_overlay').length) {
			$teaser.prepend('<div class="bg_overlay"/>');
		}
	});

	//bootstrap tab - show first tab 
	jQuery('.nav-tabs').each(function() {
		jQuery(this).find('a').first().tab('show');
	});
	jQuery('.tab-content').each(function() {
		jQuery(this).find('.tab-pane').first().addClass('fade in');
	});

	//bootstrap collapse - show first tab 
	jQuery('.panel-group').each(function() {
		jQuery(this).find('a').first().filter('.collapsed').trigger('click');
	});
}//eof documentReadyInit

//function that initiating template plugins on window.load event
function windowLoadInit() {
	//tooltip
   	if (jQuery().tooltip) {
		jQuery('[data-toggle="tooltip"]').tooltip();
	}
		
	//chart
	pieChart();

	//layerSlider
	if (jQuery().layerSlider) {
		jQuery('#layerslider').layerSlider({
			// showBarTimer: true,
			// showCircleTimer: false,
        });
	}

	//flexslider
	if (jQuery().flexslider) {
		jQuery(".mainslider .flexslider").flexslider({
			animation: "fade",
			useCSS: true,
			controlNav: false,   
			directionNav: true,
		    prevText: "",
		    nextText: "",
			smoothHeight: false,
			slideshowSpeed:10000,
			animationSpeed:600,
			autoplay:true,
			start: function( slider ) {
				slider.find('.slide_description > div').children().css({'visibility': 'hidden'});
				slider.find('.flex-active-slide .slide_description > div').children().each(function(index){
				var self = jQuery(this);
				var animationClass = !self.data('animation') ? 'fadeInRight' : self.data('animation');
				setTimeout(function(){
						self.addClass("animated "+animationClass);
					}, index*200);
				});
			},
			after :function( slider ){
				slider.find('.flex-active-slide .slide_description > div').children().each(function(index){
				var self = jQuery(this);
				var animationClass = !self.data('animation') ? 'fadeInRight' : self.data('animation');
				setTimeout(function(){
						self.addClass("animated "+animationClass);
					}, index*200);
				});
			},
			end :function( slider ){
				slider.find('.slide_description > div').children().each(function() {
					jQuery(this).attr('class', '');
				});
			}
		});

		jQuery(".flexslider").flexslider({
			animation: "fade",
			useCSS: true,
			controlNav: true,   
			directionNav: false,
		    prevText: "",
		    nextText: "",
			smoothHeight: true,
			slideshowSpeed:5000,
			animationSpeed:800,
			after :function( slider ){
			}
		});
	}

	//preloader
	jQuery(".preloaderimg").fadeOut();
	jQuery(".preloader").delay(200).fadeOut("slow").delay(200, function(){
		jQuery(this).remove();
	});

	jQuery('body').scrollspy('refresh');


	
	//animation to elements on scroll
	if (jQuery().appear) {
		jQuery('.to_animate').appear();
		jQuery('.to_animate').filter(':appeared').each(function(index){
			var self = jQuery(this);
			var animationClass = !self.data('animation') ? 'fadeInUp' : self.data('animation');
			var animationDelay = !self.data('delay') ? 210 : self.data('delay');
			setTimeout(function(){
				self.addClass("animated " + animationClass);
			}, index * animationDelay);
		});

		jQuery('body').on('appear', '.to_animate', function(e, $affected ) {
			jQuery($affected).each(function(index){
				var self = jQuery(this);
				var animationClass = !self.data('animation') ? 'fadeInUp' : self.data('animation');
				var animationDelay = !self.data('delay') ? 210 : self.data('delay');
				setTimeout(function(){
					self.addClass("animated " + animationClass);
				}, index * animationDelay);
			});
		});
	}

	//counters init on scroll
	if (jQuery().appear) {
		jQuery('.counter').appear();
		jQuery('.counter').filter(':appeared').each(function(index){
			if (jQuery(this).hasClass('counted')) {
				return;
			} else {
				jQuery(this).countTo().addClass('counted');
			}
		});
		jQuery('body').on('appear', '.counter', function(e, $affected ) {
			jQuery($affected).each(function(index){
				if (jQuery(this).hasClass('counted')) {
					return;
				} else {
					jQuery(this).countTo().addClass('counted');
				}
				
			});
		});
	}
	function consultar_cupones_cliente(){
		jQuery("#div_cupones").empty().append("<img src='http://www.ziikfor.com/administrador/images/gifs/loading.gif' width='30' style='border:none;'>");
		var url="../inc/ajax_consulta_cupones_cliente.php";
		var posting=jQuery.post(url);
		posting.done(function(data){
			jQuery("#div_cupones").empty().append(data);
		});
	}
	function consultar_recompensas(){
		jQuery("#div_recompensas").empty().append("<img src='http://www.ziikfor.com/administrador/images/gifs/loading.gif' width='30' style='border:none;'>");
		var url="../inc/ajax_consulta_recompensas.php";
		var posting=jQuery.post(url);
		posting.done(function(data){
			jQuery("#div_recompensas").empty().append(data);
		});
	}
	function consultar_promociones_cliente(){
		jQuery("#div_promociones").empty().append("<img src='http://www.ziikfor.com/administrador/images/gifs/loading.gif' width='30' style='border:none;'>");
		var url="../inc/ajax_consulta_promociones_cliente.php";
		var posting=jQuery.post(url);
		posting.done(function(data){
			jQuery("#div_promociones").empty().append(data);
		});
	}
	
	/*RECOMPENSAS PERFIL*/	
	function consultar_recompensas_perfil(){
		jQuery("#div_recompensas").empty().append("<img src='http://www.ziikfor.com/administrador/images/gifs/loading.gif' width='30' style='border:none;'>");
		var url="../inc/ajax_consulta_recompensas_perfil.php";
		var posting=jQuery.post(url);
		posting.done(function(data){
			jQuery("#div_recompensa").empty();
			jQuery("#div_recompensas").empty().append(data);
			configuracion_recompensas_perfil();
		});
	}
	function configuracion_recompensas_perfil(){
		jQuery(".accion_recompensa").on('click',function(e){
			var accion=jQuery(this).attr("accion");
			var id_recompensa=new Number(jQuery(this).attr("id_recompensa"))*1;
			if(id_recompensa>0){
				var parametros={
					"id_recompensa":id_recompensa
				};
				if(accion=="editar"){
					jQuery.ajax({
						 data:  parametros,
						 url:   '../inc/ajax_actualizar_recompensa.php',
						 type:  'post',
						 beforeSend:function(){
						 jQuery("#div_recompensa").html("Cargando formulario, espera por favor...");
						 },
						 success:function(response){
							jQuery("#div_recompensa").html(response);
							configuracion_nuevo_recompensa();
						 }
					});
				}
				else if(accion=="eliminar"){
					if(!confirm("¿Esta seguro(a) de eliminar la recompensa seleccionada?")){		
						return false;
					}
					else{
						jQuery.ajax({
							 data:  parametros,
							 url:   '../inc/ajax_eliminar_recompensa.php',
							 type:  'post',
							 beforeSend:function(){
							 jQuery("#div_recompensa").html("Eliminando recompensa, espera por favor...");
							 },
							 success:function(response){
								jQuery("#div_recompensa").html(response);
								consultar_recompensas_perfil();
							 }
						});
					}
				}
			}
		});
	}		
	function configuracion_nuevo_recompensa(){
		var bar_recompensas = jQuery('.bar_recompensas');
		var percent_recompensas = jQuery('.percent_recompensas');
		var status_recompensas = jQuery('#status_recompensas');
		jQuery('#form_recompensas').ajaxForm({
			 beforeSend: function() {
				  status_recompensas.empty();
				  var percentVal='0%';
				  bar_recompensas.width(percentVal)
				  percent_recompensas.html(percentVal);
			 },
			 uploadProgress: function(event, position, total, percentComplete) {
				  var percentVal = percentComplete + '%';
				  bar_recompensas.width(percentVal)
				  percent_recompensas.html(percentVal);
			 },
			 success: function() {
				  var percentVal = '100%';
				  bar_recompensas.width(percentVal)
				  percent_recompensas.html(percentVal);
			 },
			complete: function(xhr) {
				var respuesta=xhr.responseText;
				status_recompensas.html(respuesta);
				if(jQuery('#status_recompensas div.exito').length){
					setTimeout(function(){
						jQuery('#form_recompensas').clearForm();						
						status_recompensas.empty();
						var percentVal = '0%';
						bar_recompensas.width(percentVal)
						percent_recompensas.html(percentVal);
						jQuery("#div_recompensa").html("");
						consultar_recompensas_perfil();
					}, 4000);
				}
				else if(jQuery('#status_recompensas div.error').length){
					setTimeout(function(){ 
						status_recompensas.empty();
						var percentVal = '0%';
						bar_recompensas.width(percentVal)
						percent_recompensas.html(percentVal);
					}, 4000);
				}
			}
		});
	}
	jQuery("#nuevo_recompensa").on('click',function(e){
		e.preventDefault();
		var parametros="";
		jQuery.ajax({
			 data:  parametros,
			 url:   '../inc/ajax_nuevo_recompensa.php',
			 type:  'post',
			 beforeSend:function(){
			 jQuery("#div_recompensa").html("Cargando formulario, espera por favor...");
			 },
			 success:function(response){
				jQuery("#div_recompensa").html(response);
				configuracion_nuevo_recompensa();
			 }
		});
	});
	/*RECOMPENSAS PERFIL*/	
	
	/*FOTOS PERFIL*/
	function consultar_fotos_perfil(){
		jQuery("#div_fotos").empty().append("<img src='http://www.ziikfor.com/administrador/images/gifs/loading.gif' width='30' style='border:none;'>");
		var url="../inc/ajax_consulta_fotos_perfil.php";
		var posting=jQuery.post(url);
		posting.done(function(data){
			jQuery("#div_fotos").empty().append(data);
			configuracion_fotos_perfil();
		});
	}
	function configuracion_fotos_perfil(){
		jQuery(".accion_foto").on('click',function(e){
			var accion=jQuery(this).attr("accion");
			var id_foto=new Number(jQuery(this).attr("id_foto"))*1;
			if(id_foto>0){
				var parametros={
					"id_foto":id_foto
				};
				if(accion=="editar"){
					jQuery.ajax({
						 data:  parametros,
						 url:   '../inc/ajax_actualizar_foto.php',
						 type:  'post',
						 beforeSend:function(){
						 jQuery("#div_foto").html("Cargando formulario, espera por favor...");
						 },
						 success:function(response){
							jQuery("#div_foto").html(response);
							configuracion_nuevo_foto();
						 }
					});
				}
				else if(accion=="eliminar"){
					if(!confirm("¿Esta seguro(a) de eliminar la foto seleccionada?")){
						return false;
					}
					else{
						jQuery.ajax({
							 data:  parametros,
							 url:   '../inc/ajax_eliminar_foto.php',
							 type:  'post',
							 beforeSend:function(){
							 jQuery("#div_foto").html("Eliminando foto, espera por favor...");
							 },
							 success:function(response){
								jQuery("#div_foto").html(response);
								consultar_fotos_perfil();
							 }
						});
					}
				}
			}
		});
	}		
	function configuracion_nuevo_foto(){
		var bar_fotos = jQuery('.bar_fotos');
		var percent_fotos = jQuery('.percent_fotos');
		var status_fotos = jQuery('#status_fotos');
		jQuery('#form_fotos').ajaxForm({
			 beforeSend: function() {
				  status_fotos.empty();
				  var percentVal='0%';
				  bar_fotos.width(percentVal)
				  percent_fotos.html(percentVal);
			 },
			 uploadProgress: function(event, position, total, percentComplete) {
				  var percentVal = percentComplete + '%';
				  bar_fotos.width(percentVal)
				  percent_fotos.html(percentVal);
			 },
			 success: function() {
				  var percentVal = '100%';
				  bar_fotos.width(percentVal)
				  percent_fotos.html(percentVal);
			 },
			complete: function(xhr) {
				var respuesta=xhr.responseText;
				status_fotos.html(respuesta);
				if(jQuery('#status_fotos div.exito').length){
					setTimeout(function(){
						jQuery('#form_fotos').clearForm();						
						status_fotos.empty();
						var percentVal = '0%';
						bar_fotos.width(percentVal)
						percent_fotos.html(percentVal);
						jQuery("#div_foto").html("");
						consultar_fotos_perfil();
					}, 4000);
				}
				else if(jQuery('#status_fotos div.error').length){
					setTimeout(function(){ 
						status_fotos.empty();
						var percentVal = '0%';
						bar_fotos.width(percentVal)
						percent_fotos.html(percentVal);
					}, 4000);
				}
			}
		});
	}
	jQuery("#nuevo_foto").on('click',function(e){
		e.preventDefault();
		var parametros="";
		jQuery.ajax({
			 data:  parametros,
			 url:   '../inc/ajax_nuevo_foto.php',
			 type:  'post',
			 beforeSend:function(){
			 jQuery("#div_foto").html("Cargando formulario, espera por favor...");
			 },
			 success:function(response){
				jQuery("#div_foto").html(response);
				configuracion_nuevo_foto();
			 }
		});
	});
	/*FOTOS PERFIL*/
	
	/*PRODUCTOS PERFIL*/
	function consultar_productos_perfil(){
		jQuery("#div_productos").empty().append("<img src='http://www.ziikfor.com/administrador/images/gifs/loading.gif' width='30' style='border:none;'>");
		var url="../inc/ajax_consulta_productos_perfil.php";
		var posting=jQuery.post(url);
		posting.done(function(data){
			jQuery("#div_productos").empty().append(data);
			configuracion_productos_perfil();
		});
	}
	function configuracion_productos_perfil(){
		jQuery(".accion_producto").on('click',function(e){
			var accion=jQuery(this).attr("accion");
			var id_producto=new Number(jQuery(this).attr("id_producto"))*1;
			if(id_producto>0){
				var parametros={
					"id_producto":id_producto
				};
				if(accion=="editar"){
					jQuery.ajax({
						 data:  parametros,
						 url:   '../inc/ajax_actualizar_producto.php',
						 type:  'post',
						 beforeSend:function(){
						 jQuery("#div_producto").html("Cargando formulario, espera por favor...");
						 },
						 success:function(response){
							jQuery("#div_producto").html(response);
							configuracion_nuevo_producto();
						 }
					});
				}
				else if(accion=="eliminar"){
					if(!confirm("¿Esta seguro(a) de eliminar el producto seleccionado?")){
						return false;
					}
					else{
						jQuery.ajax({
							 data:  parametros,
							 url:   '../inc/ajax_eliminar_producto.php',
							 type:  'post',
							 beforeSend:function(){
							 jQuery("#div_producto").html("Eliminando producto, espera por favor...");
							 },
							 success:function(response){
								jQuery("#div_producto").html(response);
								consultar_productos_perfil();
							 }
						});
					}
				}
			}
		});
	}		
	function configuracion_nuevo_producto(){
		var bar_productos = jQuery('.bar_productos');
		var percent_productos = jQuery('.percent_productos');
		var status_productos = jQuery('#status_productos');
		jQuery('#form_productos').ajaxForm({
			 beforeSend: function() {
				  status_productos.empty();
				  var percentVal='0%';
				  bar_productos.width(percentVal)
				  percent_productos.html(percentVal);
			 },
			 uploadProgress: function(event, position, total, percentComplete) {
				  var percentVal = percentComplete + '%';
				  bar_productos.width(percentVal)
				  percent_productos.html(percentVal);
			 },
			 success: function() {
				  var percentVal = '100%';
				  bar_productos.width(percentVal)
				  percent_productos.html(percentVal);
			 },
			complete: function(xhr) {
				var respuesta=xhr.responseText;
				status_productos.html(respuesta);
				if(jQuery('#status_productos div.exito').length){
					setTimeout(function(){
						jQuery('#form_productos').clearForm();						
						status_productos.empty();
						var percentVal = '0%';
						bar_productos.width(percentVal)
						percent_productos.html(percentVal);
						jQuery("#div_producto").html("");
						consultar_productos_perfil();
					}, 4000);
				}
				else if(jQuery('#status_productos div.error').length){
					setTimeout(function(){ 
						status_productos.empty();
						var percentVal = '0%';
						bar_productos.width(percentVal)
						percent_productos.html(percentVal);
					}, 4000);
				}
			}
		});
	}
	jQuery("#nuevo_producto").on('click',function(e){
		e.preventDefault();
		var parametros="";
		jQuery.ajax({
			 data:  parametros,
			 url:   '../inc/ajax_nuevo_producto.php',
			 type:  'post',
			 beforeSend:function(){
			 jQuery("#div_producto").html("Cargando formulario, espera por favor...");
			 },
			 success:function(response){
				jQuery("#div_producto").html(response);
				configuracion_nuevo_producto();
			 }
		});
	});
	/*PRODUCTOS PERFIL*/	
	
		
	/*VIDEOS PERFIL*/		
	function consultar_videos_perfil(){
		jQuery("#div_videos").empty().append("<img src='http://www.ziikfor.com/administrador/images/gifs/loading.gif' width='30' style='border:none;'>");
		var url="../inc/ajax_consulta_videos_perfil.php";
		var posting=jQuery.post(url);
		posting.done(function(data){
			jQuery("#div_videos").empty().append(data);
			configuracion_videos_perfil()
		});
	}
	function configuracion_videos_perfil(){
		jQuery(".accion_video").on('click',function(e){
			var accion=jQuery(this).attr("accion");
			var id_video=new Number(jQuery(this).attr("id_video"))*1;
			if(id_video>0){
				var parametros={
					"id_video":id_video
				};
				if(accion=="editar"){
					jQuery.ajax({
						 data:  parametros,
						 url:   '../inc/ajax_actualizar_video.php',
						 type:  'post',
						 beforeSend:function(){
						 jQuery("#div_video").html("Cargando formulario, espera por favor...");
						 },
						 success:function(response){
							jQuery("#div_video").html(response);
							configuracion_nuevo_video();
						 }
					});
				}
				else if(accion=="eliminar"){
					if(!confirm("¿Esta seguro(a) de eliminar el video seleccionado?")){
						return false;
					}
					else{
						jQuery.ajax({
							 data:  parametros,
							 url:   '../inc/ajax_eliminar_video.php',
							 type:  'post',
							 beforeSend:function(){
							 jQuery("#div_video").html("Eliminando video, espera por favor...");
							 },
							 success:function(response){
								jQuery("#div_video").html(response);
								consultar_videos_perfil();
							 }
						});
					}
				}
			}
		});
	}		
	function configuracion_nuevo_video(){
		var bar_videos = jQuery('.bar_videos');
		var percent_videos = jQuery('.percent_videos');
		var status_videos = jQuery('#status_videos');
		jQuery('#form_videos').ajaxForm({
			 beforeSend: function() {
				  status_videos.empty();
				  var percentVal='0%';
				  bar_videos.width(percentVal)
				  percent_videos.html(percentVal);
			 },
			 uploadProgress: function(event, position, total, percentComplete) {
				  var percentVal = percentComplete + '%';
				  bar_videos.width(percentVal)
				  percent_videos.html(percentVal);
			 },
			 success: function() {
				  var percentVal = '100%';
				  bar_videos.width(percentVal)
				  percent_videos.html(percentVal);
			 },
			complete: function(xhr) {
				var respuesta=xhr.responseText;
				status_videos.html(respuesta);
				if(jQuery('#status_videos div.exito').length){
					setTimeout(function(){
						jQuery('#form_videos').clearForm();						
						status_videos.empty();
						var percentVal = '0%';
						bar_videos.width(percentVal)
						percent_videos.html(percentVal);
						jQuery("#div_video").html("");
						consultar_videos_perfil();
					}, 4000);
				}
				else if(jQuery('#status_videos div.error').length){
					setTimeout(function(){ 
						status_videos.empty();
						var percentVal = '0%';
						bar_videos.width(percentVal)
						percent_videos.html(percentVal);
					}, 4000);
				}
			}
		});
	}
	jQuery("#nuevo_video").on('click',function(e){
		e.preventDefault();
		var parametros="";
		jQuery.ajax({
			 data:  parametros,
			 url:   '../inc/ajax_nuevo_video.php',
			 type:  'post',
			 beforeSend:function(){
			 jQuery("#div_video").html("Cargando formulario, espera por favor...");
			 },
			 success:function(response){
				jQuery("#div_video").html(response);
				configuracion_nuevo_video();
			 }
		});
	});	
	/*VIDEOS PERFIL*/		
	
	/*ARTTCULOS PERFIL*/				
	function consultar_articulos_perfil(){
		jQuery("#div_articulos").empty().append("<img src='http://www.ziikfor.com/administrador/images/gifs/loading.gif' width='30' style='border:none;'>");
		var url="../inc/ajax_consulta_articulos_perfil.php";
		var posting=jQuery.post(url);
		posting.done(function(data){
			jQuery("#div_articulos").empty().append(data);
			configuracion_articulos_perfil();
		});
	}
	function configuracion_articulos_perfil(){
		jQuery(".accion_articulo").on('click',function(e){
			var accion=jQuery(this).attr("accion");
			var id_articulo=new Number(jQuery(this).attr("id_articulo"))*1;
			if(id_articulo>0){
				var parametros={
					"id_articulo":id_articulo
				};
				if(accion=="editar"){
					jQuery.ajax({
						 data:  parametros,
						 url:   '../inc/ajax_actualizar_articulo.php',
						 type:  'post',
						 beforeSend:function(){
						 jQuery("#div_articulo").html("Cargando formulario, espera por favor...");
						 },
						 success:function(response){
							jQuery("#div_articulo").html(response);
							configuracion_nuevo_articulo();
							new nicEditor({buttonList:['bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','image','link','unlink']}).panelInstance("descripcion_corta_articulo");
							new nicEditor({buttonList:['bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','image','link','unlink']}).panelInstance("descripcion_completa_articulo");								
						 }
					});
				}
				else if(accion=="eliminar"){
					if(!confirm("¿Esta seguro(a) de eliminar el articulo seleccionado?")){
						return false;
					}
					else{
						jQuery.ajax({
							 data:  parametros,
							 url:   '../inc/ajax_eliminar_articulo.php',
							 type:  'post',
							 beforeSend:function(){
							 jQuery("#div_articulo").html("Eliminando articulo, espera por favor...");
							 },
							 success:function(response){
								jQuery("#div_articulo").html(response);
								consultar_articulos_perfil();
							 }
						});
					}
				}
			}
		});
	}		
	function configuracion_nuevo_articulo(){
		var bar_articulos = jQuery('.bar_articulos');
		var percent_articulos = jQuery('.percent_articulos');
		var status_articulos = jQuery('#status_articulos');
		jQuery('#form_articulos').ajaxForm({
			 beforeSend: function() {
				  status_articulos.empty();
				  var percentVal='0%';
				  bar_articulos.width(percentVal)
				  percent_articulos.html(percentVal);
			 },
			 uploadProgress: function(event, position, total, percentComplete) {
				  var percentVal = percentComplete + '%';
				  bar_articulos.width(percentVal)
				  percent_articulos.html(percentVal);
			 },
			 success: function() {
				  var percentVal = '100%';
				  bar_articulos.width(percentVal)
				  percent_articulos.html(percentVal);
			 },
			complete: function(xhr) {
				var respuesta=xhr.responseText;
				status_articulos.html(respuesta);
				if(jQuery('#status_articulos div.exito').length){
					setTimeout(function(){
						jQuery('#form_articulos').clearForm();						
						status_articulos.empty();
						var percentVal = '0%';
						bar_articulos.width(percentVal)
						percent_articulos.html(percentVal);
						jQuery("#div_articulo").html("");
						consultar_articulos_perfil();
					}, 4000);
				}
				else if(jQuery('#status_articulos div.error').length){
					setTimeout(function(){ 
						status_articulos.empty();
						var percentVal = '0%';
						bar_articulos.width(percentVal)
						percent_articulos.html(percentVal);
					}, 4000);
				}
			}
		});
	}
	jQuery("#nuevo_articulo").on('click',function(e){
		e.preventDefault();
		var parametros="";
		jQuery.ajax({
			 data:  parametros,
			 url:   '../inc/ajax_nuevo_articulo.php',
			 type:  'post',
			 beforeSend:function(){
			 jQuery("#div_articulo").html("Cargando formulario, espera por favor...");
			 },
			 success:function(response){
				jQuery("#div_articulo").html(response);
				configuracion_nuevo_articulo();
				new nicEditor({buttonList:['bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','image','link','unlink']}).panelInstance("descripcion_corta_articulo");
				new nicEditor({buttonList:['bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','image','link','unlink']}).panelInstance("descripcion_completa_articulo");								
			 }
		});
	});
	/*ARTTCULOS PERFIL*/	
	
	/*CUPONES PERFIL*/
	function consultar_cupones_perfil(){
		jQuery("#div_cupones").empty().append("<img src='http://www.ziikfor.com/administrador/images/gifs/loading.gif' width='30' style='border:none;'>");
		var url="../inc/ajax_consulta_cupones_perfil.php";
		var posting=jQuery.post(url);
		posting.done(function(data){
			jQuery("#div_cupones").empty().append(data);
			configuracion_cupones_perfil();
		});
	}
	function configuracion_cupones_perfil(){
		jQuery(".accion_cupon").on('click',function(e){
			var accion=jQuery(this).attr("accion");
			var id_cupon=new Number(jQuery(this).attr("id_cupon"))*1;
			if(id_cupon>0){
				var parametros={
					"id_cupon":id_cupon
				};
				if(accion=="editar"){
					jQuery.ajax({
						 data:  parametros,
						 url:   '../inc/ajax_actualizar_cupon.php',
						 type:  'post',
						 beforeSend:function(){
						 jQuery("#div_cupon").html("Cargando formulario, espera por favor...");
						 },
						 success:function(response){
							jQuery("#div_cupon").html(response);
							configuracion_nuevo_cupon();
						 }
					});
				}
			}
		});
	}		
	function configuracion_nuevo_cupon(){
		var bar_cupones = jQuery('.bar_cupones');
		var percent_cupones = jQuery('.percent_cupones');
		var status_cupones = jQuery('#status_cupones');
		jQuery('#form_cupones').ajaxForm({
			 beforeSend: function() {
				  status_cupones.empty();
				  var percentVal='0%';
				  bar_cupones.width(percentVal)
				  percent_cupones.html(percentVal);
			 },
			 uploadProgress: function(event, position, total, percentComplete) {
				  var percentVal = percentComplete + '%';
				  bar_cupones.width(percentVal)
				  percent_cupones.html(percentVal);
			 },
			 success: function() {
				  var percentVal = '100%';
				  bar_cupones.width(percentVal)
				  percent_cupones.html(percentVal);
			 },
			complete: function(xhr) {
				var respuesta=xhr.responseText;
				status_cupones.html(respuesta);
				if(jQuery('#status_cupones div.exito').length){
					setTimeout(function(){
						jQuery('#form_cupones').clearForm();						
						status_cupones.empty();
						var percentVal = '0%';
						bar_cupones.width(percentVal)
						percent_cupones.html(percentVal);
						jQuery("#div_cupon").html("");
						consultar_cupones_perfil();
					}, 4000);
				}
				else if(jQuery('#status_cupones div.error').length){
					setTimeout(function(){ 
						status_cupones.empty();
						var percentVal = '0%';
						bar_cupones.width(percentVal)
						percent_cupones.html(percentVal);
					}, 4000);
				}
			}
		});
	}
	/*CUPONES PERFIL*/
	
	/*EVALUACIONES PERFIL*/
	function consultar_evaluaciones_perfil(){
		jQuery("#div_evaluaciones").empty().append("<img src='http://www.ziikfor.com/administrador/images/gifs/loading.gif' width='30' style='border:none;'>");
		var url="../inc/ajax_consulta_evaluaciones_perfil.php";
		var posting=jQuery.post(url);
		posting.done(function(data){
			jQuery("#div_evaluaciones").empty().append(data);
			configuracion_evaluaciones_perfil();
		});
	}
	function configuracion_evaluaciones_perfil(){
		jQuery(".accion_evaluacion").on('click',function(e){
			var accion=jQuery(this).attr("accion");
			var id_evaluacion=new Number(jQuery(this).attr("id_evaluacion"))*1;
			if(id_evaluacion>0){
				var parametros={
					"id_evaluacion":id_evaluacion
				};
				if(accion=="editar"){
					jQuery.ajax({
						 data:  parametros,
						 url:   '../inc/ajax_actualizar_evaluacion.php',
						 type:  'post',
						 beforeSend:function(){
						 jQuery("#div_evaluacion").html("Cargando formulario, espera por favor...");
						 },
						 success:function(response){
							jQuery("#div_evaluacion").html(response);
							configuracion_nuevo_evaluacion();
						 }
					});
				}
			}
		});
	}		
	function configuracion_nuevo_evaluacion(){
		var bar_evaluaciones = jQuery('.bar_evaluaciones');
		var percent_evaluaciones = jQuery('.percent_evaluaciones');
		var status_evaluaciones = jQuery('#status_evaluaciones');
		jQuery('#form_evaluaciones').ajaxForm({
			 beforeSend: function() {
				  status_evaluaciones.empty();
				  var percentVal='0%';
				  bar_evaluaciones.width(percentVal)
				  percent_evaluaciones.html(percentVal);
			 },
			 uploadProgress: function(event, position, total, percentComplete) {
				  var percentVal = percentComplete + '%';
				  bar_evaluaciones.width(percentVal)
				  percent_evaluaciones.html(percentVal);
			 },
			 success: function() {
				  var percentVal = '100%';
				  bar_evaluaciones.width(percentVal)
				  percent_evaluaciones.html(percentVal);
			 },
			complete: function(xhr) {
				var respuesta=xhr.responseText;
				status_evaluaciones.html(respuesta);
				if(jQuery('#status_evaluaciones div.exito').length){
					setTimeout(function(){
						jQuery('#form_evaluaciones').clearForm();						
						status_evaluaciones.empty();
						var percentVal = '0%';
						bar_evaluaciones.width(percentVal)
						percent_evaluaciones.html(percentVal);
						jQuery("#div_evaluacion").html("");
						consultar_evaluaciones_perfil();
					}, 4000);
				}
				else if(jQuery('#status_evaluaciones div.error').length){
					setTimeout(function(){ 
						status_evaluaciones.empty();
						var percentVal = '0%';
						bar_evaluaciones.width(percentVal)
						percent_evaluaciones.html(percentVal);
					}, 4000);
				}
			}
		});
	}
	/*EVALUACIONES PERFIL*/
	
	/*PROMOCIONES PERFIL*/
	function consultar_promociones_perfil(){
		jQuery("#div_promociones").empty().append("<img src='http://www.ziikfor.com/administrador/images/gifs/loading.gif' width='30' style='border:none;'>");
		var url="../inc/ajax_consulta_promociones_perfil.php";
		var posting=jQuery.post(url);
		posting.done(function(data){
			jQuery("#div_promociones").empty().append(data);
			configuracion_promociones_perfil();
		});
	}
	function configuracion_promociones_perfil(){
		jQuery(".accion_promocion").on('click',function(e){
			var accion=jQuery(this).attr("accion");
			var id_promocion=new Number(jQuery(this).attr("id_promocion"))*1;
			if(id_promocion>0){
				var parametros={
					"id_promocion":id_promocion
				};
				if(accion=="editar"){
					jQuery.ajax({
						 data:  parametros,
						 url:   '../inc/ajax_actualizar_promocion.php',
						 type:  'post',
						 beforeSend:function(){
						 jQuery("#div_promocion").html("Cargando formulario, espera por favor...");
						 },
						 success:function(response){
							jQuery("#div_promocion").html(response);
							configuracion_nuevo_promocion();
							new nicEditor({buttonList:['bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','image','link','unlink']}).panelInstance("descripcion_corta_promocion");
							//new nicEditor({buttonList:['bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','image','link','unlink']}).panelInstance("descripcion_completa_promocion");								
						 }
					});
				}
				else if(accion=="eliminar"){
					if(!confirm("¿Esta seguro(a) de eliminar la promocion seleccionada?")){
						return false;
					}
					else{
						jQuery.ajax({
							 data:  parametros,
							 url:   '../inc/ajax_eliminar_promocion.php',
							 type:  'post',
							 beforeSend:function(){
							 jQuery("#div_promocion").html("Eliminando promocion, espera por favor...");
							 },
							 success:function(response){
								jQuery("#div_promocion").html(response);
								consultar_promociones_perfil();
							 }
						});
					}
				}
			}
		});
	}		
	function configuracion_nuevo_promocion(){
		var bar_promociones = jQuery('.bar_promociones');
		var percent_promociones = jQuery('.percent_promociones');
		var status_promociones = jQuery('#status_promociones');
		jQuery('#form_promociones').ajaxForm({
			 beforeSend: function() {
				  status_promociones.empty();
				  var percentVal='0%';
				  bar_promociones.width(percentVal)
				  percent_promociones.html(percentVal);
			 },
			 uploadProgress: function(event, position, total, percentComplete) {
				  var percentVal = percentComplete + '%';
				  bar_promociones.width(percentVal)
				  percent_promociones.html(percentVal);
			 },
			 success: function() {
				  var percentVal = '100%';
				  bar_promociones.width(percentVal)
				  percent_promociones.html(percentVal);
			 },
			complete: function(xhr) {
				var respuesta=xhr.responseText;
				status_promociones.html(respuesta);
				if(jQuery('#status_promociones div.exito').length){
					setTimeout(function(){
						jQuery('#form_promociones').clearForm();						
						status_promociones.empty();
						var percentVal = '0%';
						bar_promociones.width(percentVal)
						percent_promociones.html(percentVal);
						jQuery("#div_promocion").html("");
						consultar_promociones_perfil();
					}, 4000);
				}
				else if(jQuery('#status_promociones div.error').length){
					setTimeout(function(){ 
						status_promociones.empty();
						var percentVal = '0%';
						bar_promociones.width(percentVal)
						percent_promociones.html(percentVal);
					}, 4000);
				}
			}
		});
	}
	jQuery("#nuevo_promocion").on('click',function(e){
		e.preventDefault();
		var parametros="";
		jQuery.ajax({
			 data:  parametros,
			 url:   '../inc/ajax_nuevo_promocion.php',
			 type:  'post',
			 beforeSend:function(){
			 jQuery("#div_promocion").html("Cargando formulario, espera por favor...");
			 },
			 success:function(response){
				jQuery("#div_promocion").html(response);
				configuracion_nuevo_promocion();
				new nicEditor({buttonList:['bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','image','link','unlink']}).panelInstance("descripcion_corta_promocion");
				//new nicEditor({buttonList:['bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','image','link','unlink']}).panelInstance("descripcion_completa_promocion");								
			 }
		});
	});
	/*PROMOCIONES PERFIL*/
	
	/*PROMOCIONES ASIGNADAS PERFIL*/
	function consultar_promociones_asignadas_perfil(){
		jQuery("#div_cupones").empty().append("<img src='http://www.ziikfor.com/administrador/images/gifs/loading.gif' width='30' style='border:none;'>");
		var url="../inc/ajax_consulta_promociones_asignadas_perfil.php";
		var posting=jQuery.post(url);
		posting.done(function(data){
			jQuery("#div_promociones_asignadas").empty().append(data);
			configuracion_promociones_asignadas_perfil();
		});
	}
	function configuracion_promociones_asignadas_perfil(){
		jQuery(".accion_promocion_asignada").on('click',function(e){
			var accion=jQuery(this).attr("accion");
			var id_cupon=new Number(jQuery(this).attr("id_cupon"))*1;
			if(id_cupon>0){
				var parametros={
					"id_cupon":id_cupon
				};
				if(accion=="editar"){
					jQuery.ajax({
						 data:  parametros,
						 url:   '../inc/ajax_actualizar_promocion_asignada.php',
						 type:  'post',
						 beforeSend:function(){
						 jQuery("#div_promocion_asignada").html("Cargando formulario, espera por favor...");
						 },
						 success:function(response){
							jQuery("#div_promocion_asignada").html(response);
							configuracion_nuevo_promocion_asignada();
						 }
					});
				}
			}
		});
	}		
	function configuracion_nuevo_promocion_asignada(){
		var bar_cupones_promocion = jQuery('.bar_cupones_promocion');
		var percent_cupones_promocion = jQuery('.percent_cupones_promocion');
		var status_cupones_promocion = jQuery('#status_cupones_promocion');
		jQuery('#form_cupones_promocion').ajaxForm({
			 beforeSend: function() {
				  status_cupones_promocion.empty();
				  var percentVal='0%';
				  bar_cupones_promocion.width(percentVal)
				  percent_cupones_promocion.html(percentVal);
			 },
			 uploadProgress: function(event, position, total, percentComplete) {
				  var percentVal = percentComplete + '%';
				  bar_cupones_promocion.width(percentVal)
				  percent_cupones_promocion.html(percentVal);
			 },
			 success: function() {
				  var percentVal = '100%';
				  bar_cupones_promocion.width(percentVal)
				  percent_cupones_promocion.html(percentVal);
			 },
			complete: function(xhr) {
				var respuesta=xhr.responseText;
				status_cupones_promocion.html(respuesta);
				if(jQuery('#status_cupones_promocion div.exito').length){
					setTimeout(function(){
						jQuery('#form_cupones_promocion').clearForm();						
						status_cupones_promocion.empty();
						var percentVal = '0%';
						bar_cupones_promocion.width(percentVal)
						percent_cupones_promocion.html(percentVal);
						jQuery("#div_promocion_asignada").html("");
						consultar_promociones_asignadas_perfil();
					}, 4000);
				}
				else if(jQuery('#status_cupones_promocion div.error').length){
					setTimeout(function(){ 
						status_cupones_promocion.empty();
						var percentVal = '0%';
						bar_cupones_promocion.width(percentVal)
						percent_cupones_promocion.html(percentVal);
					}, 4000);
				}
			}
		});
	}
	/*PROMOCIONES ASIGNADAS PERFIL*/
	
	//bootstrap animated progressbar
	if (jQuery().appear) {
		if (jQuery().progressbar) {
			jQuery('.progress .progress-bar').appear();
			jQuery('.progress .progress-bar').filter(':appeared').each(function(index){
				jQuery(this).progressbar({
			        transition_delay: 300
			    });
			});
			jQuery('body').on('appear', '.progress .progress-bar', function(e, $affected ) {
				jQuery($affected).each(function(index){
					jQuery(this).progressbar({
				        transition_delay: 300
				    });
				});
			});
			//animate progress bar inside bootstrap tab
			jQuery('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
				var target=jQuery(e.target).attr('href');
				switch(target){
					case "#tab_cupones_cliente":
						consultar_cupones_cliente();
					break;
					case "#tab2":
						consultar_recompensas();
					break;
					case "#tab_promociones_cliente":
						consultar_promociones_cliente();
					break;
					case "#tab3":
						consultar_recompensas_perfil();
					break;
					case "#tab4":
						consultar_fotos_perfil();
					break;
					case "#tab5":
						consultar_productos_perfil();
					break;
					case "#tab6":
						consultar_videos_perfil();
					break;
					case "#tab7":
						consultar_articulos_perfil();
					break;
					case "#tab_cupones_perfil":
						consultar_cupones_perfil();
					break;
					case "#tab8":
						consultar_evaluaciones_perfil();
					break;
					case "#tab_promociones_perfil":
						consultar_promociones_perfil();
					break;
					case "#tab_promociones_asignadas_perfil":
						consultar_promociones_asignadas_perfil();
					break;
				}
				jQuery(jQuery(e.target).attr('href')).find('.progress .progress-bar').progressbar({
		        transition_delay: 300
			   });
			});
		}
	}


	//flickr
	// use http://idgettr.com/ to find your ID
	if (jQuery().jflickrfeed) {
		jQuery("#flickr").jflickrfeed({
			flickrbase: "http://api.flickr.com/services/feeds/",
			limit: 8,
			qstrings: {
				id: "74705142@N08"
			},
			itemTemplate: '<a href="{{image_b}}" data-gal="prettyPhoto[pp_gal]"><li><img alt="{{title}}" src="{{image_s}}" /></li></a>'
		}, function(data) {
			jQuery("#flickr a").prettyPhoto({
				hook: 'data-gal',
				theme: 'facebook'
	   		});
		});
	}
}//eof windowLoadInit

jQuery(document).ready(function() {
	documentReadyInit();
}); //end of "document ready" event


jQuery(window).load(function(){
   	windowLoadInit();
}); //end of "window load" event

jQuery(window).resize(function(){

	jQuery('body').scrollspy('refresh');
	// $('#navbar-main').data('bs.affix').options.offset = newOffset
	var $header = jQuery('.page_header');
	if ($header.length) {
		$header.first().data('bs.affix').options.offset = $header.first().offset().top;
	}
	jQuery(".page_header_wrapper").css({height: $header.first().outerHeight()}); //editing header wrapper height for smooth stick and unstick
	
});

jQuery(window).scroll(function() {
	//circle progress bar
	pieChart();
});