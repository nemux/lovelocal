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
      De: <select id="horarios_de<?=$campo?>" name="horarios_de<?=$campo?>">
      <?
      for($hor=8;$hor<=20;$hor++):
         if($hor<12):
            $for_hor=sprintf("%02d",$hor).":00 a.m.";
         else:
            if($hor==12):
               $for_hor=sprintf("%02d",$hor).":00 p.m.";
            else:
               $for_hor=sprintf("%02d",($hor-12)).":00 p.m.";
            endif;
         endif;
         ?>
         <option value="<?=sprintf("%02d",$hor).":00"?>"><?=$for_hor?></option>
         <? /*
         <option value="<?=sprintf("%02d",$hor).":15"?>"><?=sprintf("%02d",$hor).":15"?></option>
         <option value="<?=sprintf("%02d",$hor).":30"?>"><?=sprintf("%02d",$hor).":30"?></option>
         <option value="<?=sprintf("%02d",$hor).":45"?>"><?=sprintf("%02d",$hor).":45"?></option>
         */
      endfor;
      ?>
      </select>
      
      A: <select name="horarios_a<?=$campo?>">
         <?
         for($hor=8;$hor<=20;$hor++):
            if($hor<12):
               $for_hor=sprintf("%02d",$hor).":00 a.m.";
            else:
               if($hor==12):
                  $for_hor=sprintf("%02d",$hor).":00 p.m.";
               else:
                  $for_hor=sprintf("%02d",($hor-12)).":00 p.m.";
               endif;
            endif;
            ?>
            <option value="<?=sprintf("%02d",$hor).":00"?>"><?=$for_hor?></option>
            <?
         endfor;
         ?>
      </select>
      <br>
      <div style="display:inline-block; margin-right:15px; margin-bottom:7px;">
         <input type="checkbox" name="horarios_dias<?=$campo?>[]" value="Domingo">Domingo 
      </div>
      <div style="display:inline-block; margin-right:15px; margin-bottom:7px;">
         <input type="checkbox" name="horarios_dias<?=$campo?>[]" value="Lunes">Lunes 
      </div>
      <div style="display:inline-block; margin-right:15px; margin-bottom:7px;">
         <input type="checkbox" name="horarios_dias<?=$campo?>[]" value="Martes">Martes
      </div>
      <div style="display:inline-block; margin-right:15px; margin-bottom:7px;">
         <input type="checkbox" name="horarios_dias<?=$campo?>[]" value="Miércoles">Miércoles
      </div>
      <div style="display:inline-block; margin-right:15px; margin-bottom:7px;">
         <input type="checkbox" name="horarios_dias<?=$campo?>[]" value="Jueves">Jueves
      </div>
      <div style="display:inline-block; margin-right:15px; margin-bottom:7px;">
         <input type="checkbox" name="horarios_dias<?=$campo?>[]" value="Viernes">Viernes
      </div>
      <div style="display:inline-block; margin-right:15px; margin-bottom:7px;">
         <input type="checkbox" name="horarios_dias<?=$campo?>[]" value="Sábado">Sábado
      </div>
   </div>
   <?
endif;
?>