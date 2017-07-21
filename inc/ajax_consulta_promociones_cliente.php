<?php
session_start();
$se_id_cliente=$_SESSION["s_id_cliente"];
$se_usuario_cliente=$_SESSION["s_usuario_cliente"];
$se_password_cliente=$_SESSION["s_password_cliente"];
ini_set("display_errors","On");
include("../administrador/php/config.php");
include("../administrador/php/func.php");
include("../administrador/php/func_bd.php");
include("../administrador/includes/phpmailer/class.phpmailer.php");
$errors=array();
if(empty($se_id_cliente) and empty($se_usuario_cliente) and empty($se_password_cliente)):
	die("Tu sesión ha finalizado. Es necesario que vuelvas a acceder");
else:
	//Buscar promociones del cliente
	$c_rec=buscar("pro_cli.id_registro
						,per.local
						,pro_per.promocion
						,pro_cli.cupon						
						,pro_per.imagen
						,pro_per.descripcion_corta
						,pro_cli.fecha_hora_registro
						,pro_cli.estatus"
						,"promociones_clientes pro_cli
						LEFT OUTER JOIN
							promociones_perfiles pro_per
						ON pro_per.id_promocion=pro_cli.id_promocion
						LEFT OUTER JOIN
							perfiles per
						ON per.id_perfil=pro_cli.id_perfil"
						,"WHERE pro_cli.id_cliente=".$se_id_cliente,false);
	if($c_rec->num_rows>0):
		?>
		<div class="table-responsive">
      	<table class="table table-striped" id="timetable">
	         <thead>      
               <tr>
                  <th>Perfil</th>
                  <th>Promoción</th>
                  <th>Cupón</th>                                                
                  <th>Imagen</th>                  
                  <th>Descripción corta</th>                                    
                  <th>Fecha</th>            
                  <th>Estatus</th>                                                                   
               </tr>
            </thead>
            <tbody>
					<?
               while($f_rec=$c_rec->fetch_assoc()):
                  $id_registro=$f_rec["id_registro"];
                  $perfil=cadena($f_rec["local"]);
                  $promocion=cadena($f_rec["promocion"]);
                  $cupon=cadena($f_rec["cupon"]);
						$imagen_promocion=$f_rec["imagen"];
						$descripcion_corta_promocion=cadena($f_rec["descripcion_corta"]);
                  $fecha_hora_registro=$f_rec["fecha_hora_registro"];
                  $estatus=cadena($f_rec["estatus"]);
                  ?>
                  <tr>
                     <td><?=$perfil?></td>
                     <td><?=$promocion?></td>                
                     <td><?=$cupon?></td>               
                     <td>
                     	<?
								if(!empty($imagen_promocion) and file_exists("../administrador/promociones/images/".$imagen_promocion)):
									?>
                           <img src="../administrador/promociones/images/<?=$imagen_promocion?>" style="max-width:100px;">
                           <?
								endif;
								?>
                     </td>
                     <td><?=$descripcion_corta_promocion?></td> 
                     <td><?=substr($fecha_hora_registro,8,2)." ".substr(mes_letra(substr($fecha_hora_registro,5,2)),0,3)." ".substr($fecha_hora_registro,0,4)."<br>".horario(substr($fecha_hora_registro,11))?></td>
                     <td><?=$estatus?></td>
                  </tr>
                  <?
                  unset($id_registro,$perfil,$promocion,$cupon,$imagen_promocion,$descripcion_corta_promocion,$fecha_hora_registro,$estatus);
               endwhile;
               ?>
            </tbody>
         </table>
      </div>
      <?
	else:
		?>
	   <div class="alert alert-warning">No se tiene registrado ningun cupón de promoción.</div>
      <?
	endif;
endif;
?>