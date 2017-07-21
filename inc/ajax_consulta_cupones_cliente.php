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
	//Buscar cupones del cliente
	$c_rec=buscar("reg_cli.id_registro
						,per.local
						,reg.regalo
						,reg_cli.cupon
						,reg_cli.fecha_hora_registro
						,reg_cli.estatus"
						,"regalos_clientes reg_cli
						LEFT OUTER JOIN
						regalos_perfiles reg
						ON reg.id_regalo=reg_cli.id_regalo
						LEFT OUTER JOIN
						perfiles per
						ON per.id_perfil=reg.id_perfil"
						,"WHERE reg_cli.id_cliente=".$se_id_cliente,false);
	if($c_rec->num_rows>0):
		?>
		<div class="table-responsive">
      	<table class="table table-striped" id="timetable">
	         <thead>      
               <tr>
                  <th>Perfil</th>
                  <th>Recompensa inicial</th>            
                  <th>Cupón</th>                                                
                  <th>Fecha</th>            
                  <th>Estatus</th>                                                                        
               </tr>
            </thead>
            <tbody>
					<?
               while($f_rec=$c_rec->fetch_assoc()):
                  $id_registro=$f_rec["id_registro"];
                  $perfil=cadena($f_rec["local"]);
                  $regalo=cadena($f_rec["regalo"]);
                  $cupon=cadena($f_rec["cupon"]);
                  $fecha_hora_registro=$f_rec["fecha_hora_registro"];
                  $estatus=cadena($f_rec["estatus"]);
                  ?>
                  <tr>
                     <td><?=$perfil?></td>
                     <td><?=$regalo?></td>                
                     <td><?=$cupon?></td>               
                     <td><?=substr($fecha_hora_registro,8,2)." ".substr(mes_letra(substr($fecha_hora_registro,5,2)),0,3)." ".substr($fecha_hora_registro,0,4)."<br>".horario(substr($fecha_hora_registro,11))?></td>
                     <td><?=$estatus?></td>
                  </tr>
                  <?
                  unset($id_registro,$perfil,$regalo,$cupon,$fecha_hora_registro,$estatus);
               endwhile;
               ?>
            </tbody>
         </table>
      </div>
      <?
	else:
		?>
	   <div class="alert alert-warning">No se tiene registrado ningun cupón.</div>
      <?
	endif;
endif;
?>