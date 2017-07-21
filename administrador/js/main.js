// JavaScript Document
var $c=jQuery.noConflict();
$c(document).ready(function(){
	$c("#ocultar_menu").click(function(event){
		event.preventDefault();
		$c("#menu").hide("slow");
		$c("#mostrar_menu").show("slow");
		$c("#contenido").css("width","100%");
		
	});
	$c("#mostrar_menu").click(function(event){
		$c("#menu").show("slow");
		$c("#mostrar_menu").hide("slow");
		$c("#contenido").css("width","78%");
	});
});