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
	//Buscar datos de cliente
	$c_doc=buscar("cli.id_cliente
						,cli.titulo
						,cli.nombres
						,cli.apellidos
						,cli.usuario
						,cli.password						
						,cli.imagen		
						,cli.calle
						,cli.no_exterior
						,cli.no_interior
						,cli.colonia
						,cli.municipio
						,cli.id_estado
						,est.estado
						,cli.codigo_postal
						,cli.email
						,cli.sitio_web
						,cli.telefono
						,cli.celular"
						,"clientes cli
						LEFT OUTER JOIN
						estados est
						ON est.id_estado=cli.id_estado"
						,"WHERE 	cli.id_cliente=".$se_id_cliente." 
							AND	cli.usuario='".$se_usuario_cliente."'
							AND	cli.password='".$se_password_cliente."'
							AND	cli.estatus='activo'");
	while($f_doc=$c_doc->fetch_assoc()):
		$id_cliente=$f_doc["id_cliente"];
		$titulo=cadena($f_doc["titulo"]);
		$nombres=cadena($f_doc["nombres"]);
		$apellidos=cadena($f_doc["apellidos"]);
		$doctor=cadena($f_doc["titulo"])." ".cadena($f_doc["nombres"])." ".cadena($f_doc["apellidos"]);
		$usuario=cadena($f_doc["usuario"]);
		$password=cadena($f_doc["password"]);
		$imagen_cliente=$f_doc["imagen"];
		$calle=cadena($f_doc["calle"]);
		$no_exterior=cadena($f_doc["no_exterior"]);
		$no_interior=cadena($f_doc["no_interior"]);
		$colonia=cadena($f_doc["colonia"]);
		$municipio=cadena($f_doc["municipio"]);
		$id_estado_cliente=$f_doc["id_estado"];
		$estado=cadena($f_doc["estado"]);
		$codigo_postal=cadena($f_doc["codigo_postal"]);
		$email=cadena($f_doc["email"]);
		$sitio_web=cadena($f_doc["sitio_web"]);
		$telefono=cadena($f_doc["telefono"]);
		$celular=cadena($f_doc["celular"]);
	endwhile;
	?>
	<div class="row">
      <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
      Título:
      </div>
      <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
         <input name="titulo" style="width:100px;" maxlength="255" type="text" value="<?=$titulo?>">
      </div>
   </div>   
   <div class="row">
      <div class="col-sm-2 col-md-2 col-lg-2">
         Nombre(s):
      </div>
      <div class="col-sm-10 col-md-10 col-lg-10">
         <input type="text" name="nombres" value="<?=$nombres?>" maxlength="255" required="required"> *
      </div>
   </div>
   <div class="row">
      <div class="col-sm-2 col-md-2 col-lg-2">
         Apellidos:
      </div>
      <div class="col-sm-10 col-md-10 col-lg-10">
         <input type="text" name="apellidos" value="<?=$apellidos?>" maxlength="255" required="required"> *
      </div>
   </div>
   <div class="row">
      <div class="col-sm-2 col-md-2 col-lg-2">
         Usuario:
      </div>
      <div class="col-sm-10 col-md-10 col-lg-10">
         <input type="text" name="usuario" value="<?=$usuario?>" maxlength="100" required="required"> *
      </div>
   </div>
   <div class="row">
      <div class="col-sm-2 col-md-2 col-lg-2">
         Contraseña:
      </div>
      <div class="col-sm-10 col-md-10 col-lg-10">
         <input type="password" name="password" value="<?=$password?>" maxlength="100" required="required"> *
      </div>
   </div>
   <?
   if(!empty($imagen_cliente) and file_exists("../administrador/clientes/images/".$imagen_cliente)):
      ?>
      <div class="row">
        <div class="col-sm-2 col-md-2 col-lg-2">Imagen actual</div>
        <div class="col-sm-10 col-md-10 col-lg-10">
         <img src="../administrador/clientes/images/<?=$imagen_cliente?>" style="max-width:100%;">
        </div>
      </div>
      <div class="row">
        <div class="col-sm-2 col-md-2 col-lg-2"></div>
        <div class="col-sm-10 col-md-10 col-lg-10">
            <input type="checkbox" name="eliminar_imagen">Eliminar imagen
        </div>
      </div>
      <div class="row">
        <div class="col-sm-2 col-md-2 col-lg-2">Sustituir por:</div>
        <div class="col-sm-10 col-md-10 col-lg-10">
            <input type="file" name="imagen"/>
            <br />
            <span>Le sugerimos una imagen de 225 x 225 pixeles y formato JPG</span>                                      
        </div>
      </div>
      <?
   else:
      ?>
      <div class="row">
        <div class="col-sm-2 col-md-2 col-lg-2">Imagen</div>
        <div class="col-sm-10 col-md-10 col-lg-10">
            <input type="file" name="imagen"/>
            <br />
            <span>Le sugerimos una imagen de  225 x 225 pixeles y formato JPG</span>                                      
         </div>
      </div>
      <?
   endif;
   ?>
   <div class="row">
      <div class="col-sm-2 col-md-2 col-lg-2">
         Calle
      </div>
      <div class="col-sm-10 col-md-10 col-lg-10">
         <input type="text" name="calle" value="<?=$calle?>" maxlength="255" required="required"> *
      </div>
   </div>
   <div class="row">
      <div class="col-sm-2 col-md-2 col-lg-2">
         Número exterior
      </div>
      <div class="col-sm-10 col-md-10 col-lg-10">
         <input type="text" name="no_exterior" value="<?=$no_exterior?>" maxlength="100">
      </div>
   </div>
   <div class="row">
      <div class="col-sm-2 col-md-2 col-lg-2">
         Número interior
      </div>
      <div class="col-sm-10 col-md-10 col-lg-10">
         <input type="text" name="no_interior" value="<?=$no_interior?>" maxlength="100">
      </div>
   </div>
   <div class="row">
      <div class="col-sm-2 col-md-2 col-lg-2">
         Colonia
      </div>
      <div class="col-sm-10 col-md-10 col-lg-10">
         <input type="text" name="colonia" value="<?=$colonia?>" maxlength="255" required="required"> *
      </div>
   </div>
   <div class="row">
      <div class="col-sm-2 col-md-2 col-lg-2">
         Código Postal
      </div>
      <div class="col-sm-10 col-md-10 col-lg-10">
         <input type="text" name="codigo_postal" value="<?=$codigo_postal?>" maxlength="100" required="required"> *
      </div>
   </div>
   <div class="row">
      <div class="col-sm-2 col-md-2 col-lg-2">
         Delegación o Municipio
      </div>
      <div class="col-sm-10 col-md-10 col-lg-10">
         <input type="text" name="municipio" value="<?=$municipio?>" maxlength="255" required="required"> *
      </div>
   </div>
   <div class="row">
      <div class="col-sm-2 col-md-2 col-lg-2">
         Estado
      </div>
      <div class="col-sm-10 col-md-10 col-lg-10">
         <?
            $c_est=buscar("id_estado,estado","estados","ORDER BY estado ASC");
            ?>
            <select name="id_estado" required>
               <option value="">Seleccione ...</option>
               <?
               if($c_est->num_rows>0):
                  while($f_est=$c_est->fetch_assoc()):
                     $id_estado=$f_est["id_estado"];
                     $estado=cadena($f_est["estado"]);
                     ?>
                     <option value="<?=$id_estado?>" <? if($id_estado==$id_estado_cliente): ?> selected="selected" <? endif;?>><?=$estado?></option>
                     <?
                     unset($id_estado,$estado);
                  endwhile; unset($f_est);
               endif; unset($c_est);
               ?>
            </select>
          *
      </div>
   </div>
   <div class="row">
      <div class="col-sm-2 col-md-2 col-lg-2">
         Email
      </div>
      <div class="col-sm-10 col-md-10 col-lg-10">
         <input type="text" name="email" value="<?=$email?>" maxlength="255" required/> *
      </div>
   </div>
   <div class="row">
      <div class="col-sm-2 col-md-2 col-lg-2">
         Sitio web
      </div>
      <div class="col-sm-10 col-md-10 col-lg-10">
         <textarea name="sitio_web" id="sitio_web" style="width:100%; height:100px;"><?=$sitio_web?></textarea>
      </div>
   </div>
   <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
         Teléfono(s)
      </div>
      <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
         <input type="text" name="telefono" value="<?=$telefono?>" maxlength="255"/>
      </div>
   </div>
   <div class="row">
      <div class="col-sm-2 col-md-2 col-lg-2">
         Celular
      </div>
      <div class="col-sm-10 col-md-10 col-lg-10">
         <input type="text" name="celular" value="<?=$celular?>" maxlength="255"/>
      </div>
   </div>
   <?
endif;
?>