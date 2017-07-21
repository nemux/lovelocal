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
	//Buscar productos del perfil
	$c_rec=buscar("prod.id_producto
						,prod.tipo
						,prod.producto"
						,"productos_perfiles prod"
						,"WHERE prod.id_perfil=".$se_id_perfil,false);
	if($c_rec->num_rows>0):
		?>
		<div class="table-responsive">
      	<table class="table table-striped" id="timetable">
	         <thead>      
               <tr>
                  <th>ID</th>
                  <th>Tipo</th>            
                  <th>Producto / Servicio</th>
                  <th>Acción</th>      
               </tr>
            </thead>
            <tbody>
					<?
               while($f_rec=$c_rec->fetch_assoc()):
                  $id_producto=$f_rec["id_producto"];
                  $tipo=cadena($f_rec["tipo"]);
                  $producto=cadena($f_rec["producto"]);
                  ?>
                  <tr>
                     <td><?=$id_producto?></td>
                     <td><?=$tipo?></td>
                     <td><?=$producto?></td>
                     <td>
                     	<a class="accion_producto" accion="editar" id_producto="<?=$id_producto?>" style="cursor:pointer"><i class="rt-icon2-edit highlight2"></i>Editar</a>
                        <a class="accion_producto" accion="eliminar" id_producto="<?=$id_producto?>" style="cursor:pointer"><i class="rt-icon2-delete-outline highlight2"></i>Eliminar</a>
                     </td>                
                  </tr>
                  <?
                  unset($id_producto,$tipo,$producto);
               endwhile;
               ?>
            </tbody>
         </table>
      </div>
      <?
	else:
		?>
	   <div class="alert alert-warning">No se tiene registrado ningún producto o servicio aún.</div>
      <?
	endif;
endif;
?>