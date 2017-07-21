<?php
session_start();
$se_id_perfil=$_SESSION["s_id_perfil"];
$se_usuario_perfil=$_SESSION["s_usuario_perfil"];
$se_password_perfil=$_SESSION["s_password_perfil"];
ini_set("display_errors","On");
include("../administrador/php/config.php");
include("../administrador/php/func.php");
include("../administrador/php/func_bd.php");
include("../administrador/includes/phpmailer/class.phpmailer.php");
$errors=array();
if(empty($se_id_perfil) and empty($se_usuario_perfil) and empty($se_password_perfil)):
	die("Tu sesión ha finalizado. Es necesario que vuelvas a acceder");
else:
	//Buscar promociones del perfil
	$c_pro_cli=buscar("pro_cli.id_registro
						,cli.usuario
						,pro_cli.promocion
						,pro_cli.cupon
						,pro_per.imagen
						,pro_per.descripcion_corta
						,pro_cli.fecha_hora_registro
						,pro_cli.estatus"
						,"promociones_clientes pro_cli
						LEFT OUTER JOIN
							clientes cli
						ON cli.id_cliente=pro_cli.id_cliente
						LEFT OUTER JOIN
							promociones_perfiles pro_per
						ON pro_per.id_promocion=pro_cli.id_promocion"
						,"WHERE 	pro_cli.id_perfil=".$se_id_perfil,false);
	if($c_pro_cli->num_rows>0):
		?>
		<div class="table-responsive">
      	<table class="table table-striped" id="timetable">
	         <thead>      
               <tr>
                  <th>Cliente</th>
                  <th>Promoción</th>            
                  <th>Cupón</th>                                                
                  <th>Imagen</th>                  
                  <th>Descripción corta</th>  
                  <th>Fecha</th>                                                            
                  <th>Estatus</th>        
                  <th>Acción</th>                                                                
               </tr>
            </thead>
            <tbody>
					<?
               while($f_pro_cli=$c_pro_cli->fetch_assoc()):
                  $id_registro=$f_pro_cli["id_registro"];
                  $cliente=cadena($f_pro_cli["usuario"]);
                  $promocion=cadena($f_pro_cli["promocion"]);
                  $cupon=cadena($f_pro_cli["cupon"]);
						$imagen_promocion=$f_pro_cli["imagen"];
						$descripcion_corta_promocion=cadena($f_pro_cli["descripcion_corta"]);						
                  $fecha_hora_registro=$f_pro_cli["fecha_hora_registro"];
                  $estatus=cadena($f_pro_cli["estatus"]);
                  ?>
                  <tr>
                     <td><?=$cliente?></td>
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
                     <td>
                     	<a class="accion_promocion_asignada" accion="editar" id_cupon="<?=$id_registro?>" style="cursor:pointer"><i class="rt-icon2-edit highlight2"></i>Editar</a>
                     </td>
                  </tr>
                  <?
                  unset($id_registro,$cliente,$promocion,$cupon,$imagen_promocion,$descripcion_corta_promocion,$fecha_hora_registro,$estatus);
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