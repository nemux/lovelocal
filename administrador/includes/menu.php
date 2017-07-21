<?
$se_id_usuario=$_SESSION["s_id_usuario"];
$se_tipo_usuario=$_SESSION["s_tipo_usuario"];
$se_altas=$_SESSION['s_altas'];
$se_bajas=$_SESSION['s_bajas'];
$se_actualizaciones=$_SESSION['s_actualizaciones'];
$se_reportes=$_SESSION['s_reportes'];
if(!empty($se_id_usuario)):
	?>
   <div class="modulo_menu">
      <div class="titulo_notas" onclick="javascript:location.href='http://www.lovelocal.mx/administrador/';" style="cursor:hand;cursor:pointer;">
         NOTAS
      </div>
   </div>
   <div class="div_separador">&nbsp;</div>
   <?
endif;
if(!empty($se_altas) || !empty($se_bajas) || !empty($se_actualizaciones)|| !empty($se_reportes)):
	$camposi="DISTINCT (se.id_modulo) AS id_modulo
				,mo.modulo
				,mo.imagen";
	$tablasi="adm_secciones se
				left outer join
				adm_modulos mo
				on mo.id_modulo=se.id_modulo";
				
	$c_mo="WHERE 	se.mostrar_menu='si'
				AND ";

	$c_mo.=" (";
	
	$s_se="";
	
	if(!empty($se_altas)):
		$s_se.=" OR se.id_seccion IN (".$se_altas.") ";
	endif;
	if(!empty($se_bajas)):
		$s_se.=" OR se.id_seccion IN (".$se_bajas.") ";
	endif;
	if(!empty($se_actualizaciones)):
		$s_se.=" OR se.id_seccion IN (".$se_actualizaciones.") ";
	endif;
	if(!empty($se_consultas)):
		$s_se.=" OR se.id_seccion IN (".$se_consultas.") ";
	endif;
	if(!empty($se_cargas)):
		$s_se.=" OR se.id_seccion IN (".$se_cargas.") ";
	endif;
	if(!empty($se_reportes)):
		$s_se.=" OR se.id_seccion IN (".$se_reportes.") ";
	endif;
	$s_se.=" ) ";
	
	$s_se=substr($s_se,3);
	$c_mo.=$s_se;
	
	$c_mo.=" ORDER BY mo.orden";
	
	$r_mo=buscar($camposi,$tablasi,$c_mo);
	
	while($f_mo=$r_mo->fetch_assoc()):
		$id_modulo=$f_mo['id_modulo'];
		$modulo=utf8_encode($f_mo['modulo']);
		$imagen_modulo=$f_mo['imagen'];
		?>
		<div class="modulo_menu">
      	<!--
         <div class="imagen_modulo">
            <? 
				/*
            if(!empty($imagen_modulo)):
               ?>
					<img src="http://www.lovelocal.mx/administrador/images/modulos/<?=$imagen_modulo?>" />
               <?
				else:
					?>
               &nbsp;
               <?
            endif;
				*/
            ?>
         </div>
         -->
			<div class="titulo_modulo_borde">
			<?=strtoupper($modulo);?>
         </div>
         <?
			$camposi="se.id_seccion
						,mo.modulo
						,mo.imagen
						,se.seccion
						,se.imagen as imagen_seccion
						,se.enlace ";
			$tablasi="adm_secciones se
						left outer join
						adm_modulos mo
						on			mo.id_modulo=se.id_modulo";
			$condicioni="WHERE 	se.id_modulo=".$id_modulo."
							AND		se.mostrar_menu='si'
							AND		";
			$condicioni.=" (";
			$condicioni.=$s_se;
			$condicioni.=" ORDER BY se.orden";
			
			//echo $c_se."<br>";
			
			$r_se=buscar($camposi,$tablasi,$condicioni,false);
			$fise=$r_se->num_rows;
			$cose=0;
			while($f_se=$r_se->fetch_assoc()):
				$cose++;
				$id_seccion=$f_se['id_seccion'];
				$seccion=strtoupper(utf8_encode($f_se['seccion']));
				$imagen_seccion=$f_se['imagen_seccion'];
				$enlace=utf8_encode($f_se['enlace'])."/?se=".$id_seccion;
				?>
            <div class="boton_menu" <? if($cose==$fise): ?> style="/*border-bottom-color:#000080;border-bottom-style:solid;border-bottom-width:3px;*/"<? endif;?> onclick="location.href='http://www.lovelocal.mx/administrador/<?=$enlace;?>';">
               <div class="imagen_seccion">      
                  <? 
                  if(!empty($imagen_seccion)):
                     ?>
                   	  <img src="http://www.lovelocal.mx/administrador/images/secciones/<?=$imagen_seccion?>" />
                     <?
						else:
							?>
                     &nbsp;
                     <?
                  endif;
                  ?>
               </div>         
               <div class="titulo_seccion">		
						<?
                  echo $seccion;
                  ?>
               </div>
            </div>
            <?
				unset($id_seccion);
				unset($seccion);
				unset($imagen_seccion);
				unset($enlace);
			endwhile;
			?>
		</div>
	   <div class="div_separador">&nbsp;</div>
		 <?
		 unset($id_modulo);
		 unset($modulo);
		 unset($imagen_modulo);
		 unset($fise);
		 unset($cose);
	endwhile;
endif;
if(!empty($se_id_usuario)):
	?>
   <div class="modulo_menu">
	   <div class="titulo_modulo_salir" onclick="javascript:location.href='http://www.lovelocal.mx/administrador/logout/';" style="cursor:hand;cursor:pointer;">
		SALIR
      </div>
   </div>
	<div class="div_separador">&nbsp;</div>
	<?
endif;
?>