<script language="JavaScript" type="text/JavaScript">
var $b=jQuery.noConflict();
$b(document).ready(function(){
	$b(window).resize(function(){
		var alto_resolucion=$b(window).height();
		//var total_alto=$b('#cabecera').outerHeight()+$b('#contenido').outerHeight()+$b('#pie').outerHeight();
		var total_alto=$b('#contenedor').outerHeight()+3;
		//alert("alto_resolucion: "+alto_resolucion+", total_alto: "+total_alto+ " y diferencia: "+(alto_resolucion-(total_alto)));
		if(alto_resolucion>total_alto){
			var diferencia=alto_resolucion-(total_alto);
			
			$b('#pie').css({
			top:diferencia+'px',
			position:'relative'
			});
			
		}
	});
	$b(window).resize();
 
});
</script>