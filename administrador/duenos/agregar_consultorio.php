<?
$p_contador=$_POST["contador"]*1;
$p_registro=$_POST["registro"]*1;
if(!empty($p_contador)):
	if(!empty($p_registro)):
		$campo=$p_registro.$p_contador;
	else:
		$campo=$p_contador;
	endif;
	?>
   <div style="clear:both; margin-bottom:10px;padding-top:10px; border-top:solid 1px #b2b2b2">
   	<div style="display:inline-block; margin-right:7px; margin-bottom:7px;">
			Consultorio: <input type="text" name="consultorio<?=$campo?>" id="consultorio<?=$campo?>" value="">
      </div>
      <div style="display:inline-block; margin-right:7px; margin-bottom:7px;">
	      Tel(s): <input type="text" name="telefonos<?=$campo?>" id="telefonos<?=$campo?>" value=""> 
      </div>
      <div style="display:inline-block; margin-right:7px; margin-bottom:7px;">
	      Horarios: <input type="text" name="horarios<?=$campo?>" id="horarios<?=$campo?>" value="">
      </div>
   </div>
   <?
endif;
?>