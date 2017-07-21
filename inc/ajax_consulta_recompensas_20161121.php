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
	//Buscar recompensas del cliente
	$c_rec=buscar("eva_per.id_evaluacion
						,per.local
						,rec.recompensa
						,eva_per.evaluacion
						,eva_per.comentario
						,eva_per.cupon
						,eva_per.fecha_hora_registro
						,eva_per.estatus"
						,"evaluaciones_perfiles eva_per
						LEFT OUTER JOIN
						perfiles per
						ON per.id_perfil=eva_per.id_perfil
						LEFT OUTER JOIN
						recompensas_perfiles rec
						ON rec.id_recompensa=eva_per.id_recompensa
						AND rec.id_perfil=eva_per.id_perfil"
						,"WHERE 	eva_per.id_cliente=".$se_id_cliente,false);
	if($c_rec->num_rows>0):
		?>
		<div class="table-responsive">
      	<table class="table table-striped" id="timetable">
	         <thead>      
               <tr>
                  <th>Perfil</th>
                  <th>Recompensa</th>            
                  <th>Evaluacion</th>                        
                  <th>Comentario</th>                                    
                  <th>Cupón</th>                                                
                  <th>Fecha</th>                                                            
                  <th>Estatus</th>                                                                        
               </tr>
            </thead>
            <tbody>
					<?
               while($f_rec=$c_rec->fetch_assoc()):
                  $id_evaluacion=$f_rec["id_evaluacion"];
                  $perfil=cadena($f_rec["local"]);
                  $recompensa=cadena($f_rec["recompensa"]);
                  $evaluacion=cadena($f_rec["evaluacion"]);
                  $comentario=cadena($f_rec["comentario"]);
                  $cupon=cadena($f_rec["cupon"]);
                  $fecha_hora_registro=$f_rec["fecha_hora_registro"];
                  $estatus=cadena($f_rec["estatus"]);
                  ?>
                  <tr>
                     <td><?=$perfil?></td>
                     <td><?=$recompensa?></td>                
                     <td class="stars"><a class="star-<?=$evaluacion?>" href="#"><?=$evaluacion?></a></td>
                     <td><?=$comentario?></td>                        
                     <td><?=$cupon?></td>               
                     <td><?=substr($fecha_hora_registro,8,2)." ".substr(mes_letra(substr($fecha_hora_registro,5,2)),0,3)." ".substr($fecha_hora_registro,0,4)."<br>".horario(substr($fecha_hora_registro,11))?></td>
                     <td><?=$estatus?></td>
                  </tr>
                  <?
                  unset($id_evaluacion,$perfil,$recompensa,$evaluacion,$comentario,$cupon,$fecha_hora_registro,$estatus);
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