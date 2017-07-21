<?php
session_start();
$se_id_perfil=$_SESSION["s_id_perfil"];
$se_usuario_perfil=$_SESSION["s_usuario_perfil"];
$se_password_perfil=$_SESSION["s_password_perfil"];
ini_set("display_errors","On");
include("../administrador/php/config.php");
include("../administrador/php/func.php");
include("../administrador/php/func_bd.php");
$errors=array();
if(empty($se_id_perfil) and empty($se_usuario_perfil) and empty($se_password_perfil)):
	die("Tu sesión ha finalizado. Es necesario que vuelvas a acceder");
else:
	//Buscar promociones de perfil
	$c_pro=buscar("pro.id_promocion
						,pro.promocion
						,pro.imagen
						,pro.descripcion_corta
						,pro.descripcion_completa
						,pro.fecha_hora_registro
						,pro.estatus"
						,"promociones_perfiles pro"
						,"WHERE 	pro.id_perfil=".$se_id_perfil."
						ORDER BY pro.fecha_hora_registro DESC");
	if($c_pro->num_rows>0):
		?>
		<div class="table-responsive">
      	<table class="table table-striped" id="timetable">
	         <thead>      
               <tr>
                  <th>Promoción</th>            
                  <th>Imagen</th>                        
                  <th>Descripción corta</th>                                    
                  <th>Fecha</th>                                                            
                  <th>Estatus</th>        
                  <th>Acción</th>                                                                
               </tr>
            </thead>
            <tbody>      
				<?
            while($f_pro=$c_pro->fetch_assoc()):
               $id_promocion=$f_pro["id_promocion"];
               $promocion=cadena($f_pro["promocion"]);
               $imagen=$f_pro["imagen"];
               $descripcion_corta=cadena($f_pro["descripcion_corta"]);
               $descripcion_completa=cadena($f_pro["descripcion_completa"]);
               $fecha_hora_registro=$f_pro["fecha_hora_registro"];
               $estatus=$f_pro["estatus"];
               ?>
               <tr>
                  <td><?=$promocion?></td>
                  <td>
                  	<?
							if(!empty($imagen) and file_exists("../administrador/promociones/images/".$imagen)):
								?>
								<div class="entry-thumbnail">                  
									<img src="../administrador/promociones/images/<?=$imagen?>" alt="<?=$promocion?>" style="max-width:100px;">
								</div>                  
								<?
							endif;
							?>
                  </td>                
                  <td><?=$descripcion_corta?></td>
                  <td><?=substr($fecha_hora_registro,8,2)." ".substr(mes_letra(substr($fecha_hora_registro,5,2)),0,3)." ".substr($fecha_hora_registro,0,4)."<br>".horario(substr($fecha_hora_registro,11))?></td>
                  <td><?=$estatus?></td>
                  <td>
                     <a class="accion_promocion" accion="editar" id_promocion="<?=$id_promocion?>" style="cursor:pointer"><i class="rt-icon2-edit highlight2"></i>Editar</a>
                      <a class="accion_promocion" accion="eliminar" id_promocion="<?=$id_promocion?>" style="cursor:pointer"><i class="rt-icon2-delete-outline highlight2"></i>Eliminar</a>
                  </td>
               </tr>
               <?
               unset($id_promocion,$promocion,$imagen,$descripcion_corta,$fecha_registro,$hora_registro,$estatus);
            endwhile;
            ?>
            </tbody>
         </table>
      </div>
      <?
	else:
		?>
	   <div class="alert alert-warning">No se tiene registrada ninguna promoción.</div>
      <?
	endif;
endif;
?>