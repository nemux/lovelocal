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
	//Buscar datos de perfil
	$c_per=buscar("per.id_perfil
						,per.perfil
						,per.nombres
						,per.apellidos
						,per.usuario
						,per.password
                  ,per.horario						
						,per.local
						,per.imagen		
						,per.calle
						,per.no_exterior
						,per.no_interior
						,per.colonia
						,per.municipio
						,per.id_estado
						,est.estado
						,per.codigo_postal
						,per.email
						,per.sitio_web
						,per.telefono
						,per.celular
						,per.descripcion_corta
						,per.descripcion_completa
						,per.precio_de
						,per.precio_a"
						,"perfiles per
						LEFT OUTER JOIN
						estados est
						ON est.id_estado=per.id_estado"
						,"WHERE 	per.id_perfil=".$se_id_perfil." 
							AND	per.usuario='".$se_usuario_perfil."'
							AND	per.password='".$se_password_perfil."'
							AND	per.estatus='activo'");
	while($f_per=$c_per->fetch_assoc()):
		$id_perfil=$f_per["id_perfil"];
		$perfil=cadena($f_per["perfil"]);
		$nombres=cadena($f_per["nombres"]);
		$apellidos=cadena($f_per["apellidos"]);
		$doctor=cadena($f_per["perfil"])." ".cadena($f_per["nombres"])." ".cadena($f_per["apellidos"]);
		$usuario=cadena($f_per["usuario"]);
		$password=cadena($f_per["password"]);
		$local=cadena($f_per["local"]);	
      $horario=cadena($f_per["horario"]);  	
		$imagen_perfil=$f_per["imagen"];
		$calle=cadena($f_per["calle"]);
		$no_exterior=cadena($f_per["no_exterior"]);
		$no_interior=cadena($f_per["no_interior"]);
		$colonia=cadena($f_per["colonia"]);
		$municipio=cadena($f_per["municipio"]);
		$id_estado_perfil=$f_per["id_estado"];
		$estado=cadena($f_per["estado"]);
		$codigo_postal=cadena($f_per["codigo_postal"]);
		$email=cadena($f_per["email"]);
		$sitio_web=cadena($f_per["sitio_web"]);
		$telefono=cadena($f_per["telefono"]);
		$celular=cadena($f_per["celular"]);
		$descripcion_corta=cadena($f_per["descripcion_corta"]);
		$descripcion_completa=cadena($f_per["descripcion_completa"]);
		$precio_de=$f_per["precio_de"];
		$precio_a=$f_per["precio_a"];
	endwhile;
	//Buscar categorias
	$c_cat=buscar("id_categoria","categorias_perfiles","WHERE id_perfil='".$se_id_perfil."'");
	$arreglo_categorias=array();
	while($f_cat=$c_cat->fetch_assoc()):
		$arreglo_categorias[]=$f_cat["id_categoria"];
	endwhile;
	?>
   <h3>Mis Datos:</h3>
   <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
      Perfil:
      </div>
      <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
         <?=$perfil?>
         <input type="hidden" id="perfil" value="<?=$perfil?>">
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
   <h3>Datos del Local:</h3>        
   <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
         Local:
      </div>
      <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
         <input type="text" name="local" value="<?=$local?>" maxlength="255" required="required"> *
      </div>
   </div> 
   <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
         Horario:
      </div>
      <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
         <input type="text" name="horario" value="<?=$horario?>" maxlength="255" required="required"> *
      </div>
   </div>    
   <?
   if(!empty($imagen_perfil) and file_exists("../administrador/perfiles/images/".$imagen_perfil)):
      ?>
      <div class="row">
        <div class="col-sm-2 col-md-2 col-lg-2">Imagen actual</div>
        <div class="col-sm-10 col-md-10 col-lg-10">
         <img src="../administrador/perfiles/images/<?=$imagen_perfil?>" style="max-width:100%;">
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
            <span>Le sugerimos una imagen de 600 x 400 pixeles y formato JPG</span>                                      
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
            <span>Le sugerimos una imagen de  600 x 400 pixeles y formato JPG</span>                                      
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
                     <option value="<?=$id_estado?>" <? if($id_estado==$id_estado_perfil): ?> selected="selected" <? endif;?>><?=$estado?></option>
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
   <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
         Rango de precios
      </div>
      <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
            De: <input name="precio_de" step="1.00" placeholder="100.00" type="number" value="<?=$precio_de?>"> A: <input name="precio_a" step="1.00" placeholder="100.00" type="number" value="<?=$precio_a?>">
      </div>
   </div>
   <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
         Descripción breve del lugar
      </div>
      <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
         <textarea id="descripcion_corta" name="descripcion_corta" style="width:100%;height:100px;"><?=$descripcion_corta?></textarea>
      </div>
   </div>                                 
   <?
   if($perfil=="Perfil 2" or $perfil=="Perfil 3"):
      ?>
      <div class="row">
         <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
            Descripción completa del lugar
         </div>
         <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
            <textarea id="descripcion_completa" name="descripcion_completa" style="width:100%;height:200px;"><?=$descripcion_completa?></textarea>
         </div>
      </div>     
      <?
   endif;
   ?>
   <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
         Categorías
      </div>
      <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
         <?
         //Buscar categorías 
         $c_cat=buscar("id_categoria,categoria","categorias","WHERE estatus='activo' ORDER BY orden ASC");
         if($c_cat->num_rows>0):
            while($f_cat=$c_cat->fetch_assoc()):
               $id_categoria=$f_cat["id_categoria"];
               $categoria=cadena($f_cat["categoria"]);
               ?>
               <div style="display:inline-block; margin-right:15px; margin-bottom:7px;">
                  <input type="checkbox" name="categorias[]" <? if(in_array($id_categoria,$arreglo_categorias)): ?> checked="checked" <? endif;?> value="<?=$id_categoria?>"> <?=$categoria?>
               </div>
               <?
               unset($id_categoria,$categoria);
            endwhile;
         endif;
         ?>
      </div>
   </div>
	<div class="row">
      <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
         Recompensa inicial
      </div>
      <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
         <?
         $regalo1="";
         $c_rec=buscar("regalo","regalos_perfiles","WHERE id_perfil='".$se_id_perfil."'");
         while($f_rec=$c_rec->fetch_assoc()):
            $regalo1=cadena($f_rec["regalo"]);
         endwhile;
         ?>
         <input type="text" name="regalo1" style="width:90%;" maxlength="255" required value="<?=$regalo1?>"> *
      </div>
   </div>   
   <?
endif;
?>