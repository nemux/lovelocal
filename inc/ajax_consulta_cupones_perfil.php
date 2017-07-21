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
	//Buscar cupones del perfil
	$c_rec=buscar("reg_cli.id_registro
						,cli.usuario
						,reg.regalo
						,reg_cli.cupon
						,reg_cli.fecha_hora_registro
						,reg_cli.estatus"
						,"regalos_clientes reg_cli
						LEFT OUTER JOIN
						clientes cli
						ON cli.id_cliente=reg_cli.id_cliente
						LEFT OUTER JOIN
						regalos_perfiles reg
						ON reg.id_regalo=reg_cli.id_regalo"
						,"WHERE 	reg.id_perfil=".$se_id_perfil,false);
	if($c_rec->num_rows>0):
		?>
		<div class="table-responsive">
      	<table class="table table-striped" id="timetable">
	         <thead>      
               <tr>
                  <th>Cliente</th>
                  <th>Regalo</th>            
                  <th>Cupón</th>                                                
                  <th>Fecha</th>                                                            
                  <th>Estatus</th>        
                  <th>Acción</th>                                                                
               </tr>
            </thead>
            <tbody>
					<?
               while($f_rec=$c_rec->fetch_assoc()):
                  $id_registro=$f_rec["id_registro"];
                  $cliente=cadena($f_rec["usuario"]);
                  $regalo=cadena($f_rec["regalo"]);
                  $cupon=cadena($f_rec["cupon"]);
                  $fecha_hora_registro=$f_rec["fecha_hora_registro"];
                  $estatus=cadena($f_rec["estatus"]);
                  ?>
                  <tr>
                     <td><?=$cliente?></td>
                     <td><?=$regalo?></td>                
                     <td><?=$cupon?></td>               
                     <td><?=substr($fecha_hora_registro,8,2)." ".substr(mes_letra(substr($fecha_hora_registro,5,2)),0,3)." ".substr($fecha_hora_registro,0,4)."<br>".horario(substr($fecha_hora_registro,11))?></td>
                     <td><?=$estatus?></td>
                     <td>
                     	<a class="accion_cupon" accion="editar" id_cupon="<?=$id_registro?>" style="cursor:pointer"><i class="rt-icon2-edit highlight2"></i>Editar</a>
                     </td>
                  </tr>
                  <?
                  unset($id_registro,$cliente,$regalo,$cupon,$fecha_hora_registro,$estatus);
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