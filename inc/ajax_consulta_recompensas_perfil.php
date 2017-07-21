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
	//Buscar recompensas del perfil
	$c_rec=buscar("rec.id_recompensa
						,rec.recompensa
						,rec.estatus"
						,"recompensas_perfiles rec"
						,"WHERE rec.id_perfil=".$se_id_perfil,false);
	if($c_rec->num_rows>0):
		?>
		<div class="table-responsive">
      	<table class="table table-striped" id="timetable">
	         <thead>      
               <tr>
                  <th>ID</th>
                  <th>Recompensa</th>            
                  <th>Estatus</th>    
                  <th>Acción</th>                                                                    
               </tr>
            </thead>
            <tbody>
					<?
               while($f_rec=$c_rec->fetch_assoc()):
                  $id_recompensa=$f_rec["id_recompensa"];
                  $recompensa=cadena($f_rec["recompensa"]);
                  $estatus=cadena($f_rec["estatus"]);
                  ?>
                  <tr>
                     <td><?=$id_recompensa?></td>
                     <td><?=$recompensa?></td>                
                     <td><?=$estatus?></td>
                     <td>
                     	<a class="accion_recompensa" accion="editar" id_recompensa="<?=$id_recompensa?>" style="cursor:pointer"><i class="rt-icon2-edit highlight2"></i>Editar</a>
                        <a class="accion_recompensa" accion="eliminar" id_recompensa="<?=$id_recompensa?>" style="cursor:pointer"><i class="rt-icon2-delete-outline highlight2"></i>Eliminar</a>
                     </td>
                  </tr>
                  <?
                  unset($id_recompensa,$recompensa,$estatus);
               endwhile;
               ?>
            </tbody>
         </table>
      </div>
      <?
	else:
		?>
	   <div class="alert alert-warning">No se tiene registrada ninguna recompensa aún.</div>
      <?
	endif;
endif;
?>