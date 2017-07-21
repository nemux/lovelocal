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
	//Buscar evaluaciones del perfil
	$c_rec=buscar("eva_per.id_evaluacion
						,cli.usuario
						,rec.recompensa
						,eva_per.evaluacion
						,eva_per.comentario
						,eva_per.cupon
						,eva_per.fecha_hora_registro
						,eva_per.estatus"
						,"evaluaciones_perfiles eva_per
						LEFT OUTER JOIN
						clientes cli
						ON cli.id_cliente=eva_per.id_cliente
						LEFT OUTER JOIN
						recompensas_perfiles rec
						ON rec.id_recompensa=eva_per.id_recompensa
						AND rec.id_perfil=eva_per.id_perfil"
						,"WHERE 	eva_per.id_perfil=".$se_id_perfil,false);
	if($c_rec->num_rows>0):
		?>
		<div class="table-responsive">
      	<table class="table table-striped" id="timetable">
	         <thead>      
               <tr>
                  <th>Cliente</th>
                  <th>Recompensa</th>            
                  <th>Evaluacion</th>                        
                  <th>Comentario</th>                                    
                  <th>Cupón</th>                                                
                  <th>Fecha</th>                                                            
                  <th>Estatus</th>        
                  <th>Acción</th>                                                                
               </tr>
            </thead>
            <tbody>
					<?
               while($f_rec=$c_rec->fetch_assoc()):
                  $id_evaluacion=$f_rec["id_evaluacion"];
                  $cliente=cadena($f_rec["usuario"]);
                  $recompensa=cadena($f_rec["recompensa"]);
                  $evaluacion=cadena($f_rec["evaluacion"]);
                  $comentario=cadena($f_rec["comentario"]);
                  $cupon=cadena($f_rec["cupon"]);
                  $fecha_hora_registro=$f_rec["fecha_hora_registro"];
                  $estatus=cadena($f_rec["estatus"]);
                  ?>
                  <tr>
                     <td><?=$cliente?></td>
                     <td><?=$recompensa?></td>                
                     <td class="stars"><a class="star-<?=$evaluacion?>" href="#"><?=$evaluacion?></a></td>
                     <td><?=$comentario?></td>                        
                     <td><?=$cupon?></td>               
                     <td><?=substr($fecha_hora_registro,8,2)." ".substr(mes_letra(substr($fecha_hora_registro,5,2)),0,3)." ".substr($fecha_hora_registro,0,4)."<br>".horario(substr($fecha_hora_registro,11))?></td>
                     <td><?=$estatus?></td>
                     <td>
                     	<a class="accion_evaluacion" accion="editar" id_evaluacion="<?=$id_evaluacion?>" style="cursor:pointer"><i class="rt-icon2-edit highlight2"></i>Editar</a>
                     </td>
                  </tr>
                  <?
                  unset($id_evaluacion,$cliente,$recompensa,$evaluacion,$comentario,$cupon,$fecha_hora_registro,$estatus);
               endwhile;
               ?>
            </tbody>
         </table>
      </div>
      <?
	else:
		?>
	   <div class="alert alert-warning">No se tiene registrada ninguna evaluación aún.</div>
      <?
	endif;
endif;
?>