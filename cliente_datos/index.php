<?
session_start();
ini_set("display_errors","On");
$se_id_cliente=isset($_SESSION["s_id_cliente"]) ? $_SESSION["s_id_cliente"] : "";
$se_id_facebook=isset($_SESSION["s_id_facebook"]) ? $_SESSION["s_id_facebook"] : "";
$se_email_cliente=isset($_SESSION["s_email_cliente"]) ? $_SESSION["s_email_cliente"] : "";
$se_usuario_cliente=isset($_SESSION["s_usuario_cliente"]) ? $_SESSION["s_usuario_cliente"] : "";
$se_password_cliente=isset($_SESSION["s_password_cliente"]) ? $_SESSION["s_password_cliente"] : "";
include("../administrador/php/config.php");
include("../administrador/php/func_bd.php");
include("../administrador/php/func.php");
if((!empty($se_id_cliente) and !empty($se_usuario_cliente) and !empty($se_password_cliente)) or
	(!empty($se_id_cliente) and !empty($se_id_facebook) and !empty($se_email_cliente))
	):
	$con_cli="WHERE cli.estatus='activo'";
	if(!empty($se_id_cliente) and !empty($se_usuario_cliente) and !empty($se_password_cliente)):
		$con_cli.=" AND cli.id_cliente=".$se_id_cliente." 
						AND cli.usuario='".$se_usuario_cliente."'
						AND cli.password='".$se_password_cliente."'";
	elseif(!empty($se_id_cliente) and !empty($se_id_facebook) and !empty($se_email_cliente)):
		$con_cli.=" AND cli.id_cliente=".$se_id_cliente." 
						AND cli.id_facebook='".$se_id_facebook."'
						AND cli.email='".$se_email_cliente."'";
	endif;

	//Buscar datos de cliente
	$c_cli=buscar("cli.id_cliente
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
						,$con_cli,false);
	while($f_cli=$c_cli->fetch_assoc()):
		$id_cliente=$f_cli["id_cliente"];
		$titulo=cadena($f_cli["titulo"]);
		$nombres=cadena($f_cli["nombres"]);
		$apellidos=cadena($f_cli["apellidos"]);
		$cliente=cadena($f_cli["titulo"])." ".cadena($f_cli["nombres"])." ".cadena($f_cli["apellidos"]);
		$usuario=cadena($f_cli["usuario"]);
		$password=cadena($f_cli["password"]);
		$imagen_cliente=$f_cli["imagen"];
		$calle=cadena($f_cli["calle"]);
		$no_exterior=cadena($f_cli["no_exterior"]);
		$no_interior=cadena($f_cli["no_interior"]);
		$colonia=cadena($f_cli["colonia"]);
		$municipio=cadena($f_cli["municipio"]);
		$id_estado_cliente=$f_cli["id_estado"];
		$estado=cadena($f_cli["estado"]);
		$codigo_postal=cadena($f_cli["codigo_postal"]);
		$email=cadena($f_cli["email"]);
		$sitio_web=cadena($f_cli["sitio_web"]);
		$telefono=cadena($f_cli["telefono"]);
		$celular=cadena($f_cli["celular"]);
	endwhile;
endif;
?>
<!DOCTYPE html> <html class="no-js">
<head>
<title>Mis Datos | Clientes - LoveLocal</title>
<!-- Favicon -->
<link rel="shortcut icon" href="http://www.lovelocal.mx/images/favicon.png">
<meta charset="utf-8"><!--[if IE]> <meta http-equiv="X-UA-Compatible" content="IE=edge"><![endif]--> 
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../css/bootstrap.min.css">
<link rel="stylesheet" href="../css/main.css" id="color-switcher-link">
<link rel="stylesheet" href="../css/animations.css">
<link rel="stylesheet" href="../css/fonts.css">
<script src="../js/vendor/modernizr-2.6.2.min.js"></script>
<!--[if lt IE 9]> <script src="js/vendor/html5shiv.min.js"></script> <script src="js/vendor/respond.min.js"></script><![endif]-->
<script src="../assets/nicEdit/nicEdit.js" type="text/javascript"></script>
<script type="text/javascript">
	//new nicEditor().panelInstance("sitio_web");
</script>
</head>
<body><!--[if lt IE 9]> <div class="bg-danger text-center">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/" class="highlight">upgrade your browser</a> to improve your 
experience.</div><![endif]-->
<div class="boxed pattern8" id="canvas">
	<div class="container" id="box_wrapper">
   	<?
		include_once("../inc/header.php");
		include_once("../inc/form_busqueda_horizontal2.php");
		?>
      <section id="content" class="ls section_padding_top_25 section_padding_bottom_25">
          <div class="container">
            <div class="row ls_fondo4">
               <?
               if(!empty($id_cliente) and $se_id_cliente==$id_cliente):
                  ?>
                  <div class="col-xs-12 col-sm-12 col-md-11 col-md-offset-1">
                     <!-- Nav tabs -->
                     <ul class="nav nav-tabs topmargin_0" role="tablist">
                        <li class="active"><a href="#promorandom" role="tab" data-toggle="tab">Ve Nuestras Promociones</a></li>
                        <li><a href="#tab1" role="tab" data-toggle="tab">Mis Datos</a></li>
                        <li><a href="#tab_cupones_cliente" role="tab" data-toggle="tab">Mis cupones</a></li>
                        <li><a href="#tab2" role="tab" data-toggle="tab">Mis recompensas</a></li>
                        <li><a href="#tab_promociones_cliente" role="tab" data-toggle="tab">Mis promociones</a></li>
                        <li><a href="#tab_ziikfor" role="tab" data-toggle="tab">Como funciona LoveLocal</a></li>
                     </ul>
                     <!-- Tab panes -->
                      <div class="tab-content top-color-border bottommargin_30">
                          <div class="tab-pane fade in" id="tab1">
                              <style>
                              #form_datos{display: block; margin:10px auto; /*background:rgba(0, 0, 0, 0.1);*/ border-radius: 10px; padding: 15px }
                              #form_datos .nicEdit-main{
                                 background-color:#FFFFFF;
                              }
                              .progress_datos{position:relative; width:100%; border: 1px solid #ddd; padding: 1px; border-radius: 3px; }
                              .bar_datos{background-color:#03538E;width:0%; height:33px; border-radius: 3px; margin:0 !important;}
                              .percent_datos{position:absolute;color:#FFFFFF !important;display:inline-block; top:3px; left:48%; }
                              </style>   
                              <h3>Mis Datos:</h3>
                              <form id="form_datos" action="../inc/ajax_datos_cliente.php" method="post" enctype="multipart/form-data">
                               <!--mis_datos-->
                              <div id="div_datos">
                                 <!--<div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                    Título:
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                    	<input name="titulo" style="width:100px;" maxlength="255" type="text" value="<?=$titulo?>">
                                    </div>
                                 </div>-->
                                 <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                       Nombre(s):
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                       <input type="text" name="nombres" value="<?=$nombres?>" maxlength="255" required="required"> *
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                       Apellidos:
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                       <input type="text" name="apellidos" value="<?=$apellidos?>" maxlength="255" required="required"> *
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                       Usuario:
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                       <input type="text" name="usuario" value="<?=$usuario?>" maxlength="100" required="required"> *
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                       Contraseña:
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                       <input type="password" name="password" value="<?=$password?>" maxlength="100" required="required"> *
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                       Email
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                       <input type="text" name="email" value="<?=$email?>" maxlength="255" required/> *
                                    </div>
                                 </div>
                                 <?/*
                                 if(!empty($imagen_cliente) and file_exists("../administrador/clientes/images/".$imagen_cliente)):
                                    ?>
                                    <div class="row">
                                      <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">Imagen actual</div>
                                      <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                       <img src="../administrador/clientes/images/<?=$imagen_cliente?>" style="max-width:100%;">
                                      </div>
                                    </div>
                                    <div class="row">
                                      <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2"></div>
                                      <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                          <input type="checkbox" name="eliminar_imagen">Eliminar imagen
                                      </div>
                                    </div>
                                    <div class="row">
                                      <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">Sustituir por:</div>
                                      <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                          <input type="file" name="imagen"/>
                                          <br />
                                          <span>Le sugerimos una imagen de 225 x 225 pixeles y formato JPG</span>                                      
                                      </div>
                                    </div>
                                    <?
                                 else:
                                    ?>
                                    <div class="row">
                                      <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">Imagen</div>
                                      <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                          <input type="file" name="imagen"/>
                                          <br />
                                          <span>Le sugerimos una imagen de  225 x 225 pixeles y formato JPG</span>                                      
                                       </div>
                                    </div>
                                    <?
                                 endif;*/
                                 ?>
                                 <!--<div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                       Calle
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                       <input type="text" name="calle" value="<?=$calle?>" maxlength="255" required="required"> *
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                       Número exterior
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                       <input type="text" name="no_exterior" value="<?=$no_exterior?>" maxlength="100">
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                       Número interior
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                       <input type="text" name="no_interior" value="<?=$no_interior?>" maxlength="100">
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                       Colonia
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                       <input type="text" name="colonia" value="<?=$colonia?>" maxlength="255" required="required"> *
                                    </div>
                                 </div>-->
                                 <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                       Esta informacion no es obligatoria, pero nos ayudara para mandarle promociones exclusivas de la zona donde están, o enviarle promociones vía whatsapp 
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                       Código Postal
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                       <input type="text" name="codigo_postal" value="<?=$codigo_postal?>" maxlength="100" >
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                       Delegación o Municipio
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                       <input type="text" name="municipio" value="<?=$municipio?>" maxlength="255" > 
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                       Estado
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                       <?
                                          $c_est=buscar("id_estado,estado","estados","ORDER BY estado ASC");
                                          ?>
                                          <select name="id_estado">
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
                                        
                                    </div>
                                 </div>
                                 
                                 <!--<div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                       Sitio web
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                       <textarea id="sitio_web" name="sitio_web" style="width:100%;height:100px;"><?=$sitio_web?></textarea>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                       Teléfono(s)
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                       <input type="text" name="telefono" value="<?=$telefono?>" maxlength="255"/>
                                    </div>
                                 </div>-->
                                 <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                       Celular
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                       <input type="text" name="celular" value="<?=$celular?>" maxlength="255"/>
                                    </div>
                                 </div>
                              </div>
                              <!--mis_datos-->
                              <div class="row">
                                 <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                    <input type="hidden" name="action_datos" value="send">
                                 </div>
                                 <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                    <!--<button type="submit" id="form_datos_submit" name="form_datos_submit" class="theme_button topmargin_10" onclick="nicEditors.findEditor('sitio_web').saveContent();">Actualizar Datos</button>-->
                                    <button type="submit" id="form_datos_submit" name="form_datos_submit" class="theme_button topmargin_10">Actualizar Datos</button>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                 </div>
                                 <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                                    <div class="progress_datos">
                                       <div class="bar_datos"></div>
                                       <div class="percent_datos">0%</div>
                                    </div>
                                    <div id="status_datos"></div>
                                 </div>
                              </div>
                              </form>
                          </div>
                          <div class="tab-pane fade" id="tab_cupones_cliente">
                              <style>
                              #div_cupones{display: block; margin:10px auto; /*background:rgba(0, 0, 0, 0.1); */border-radius: 10px; padding: 15px }
                              </style>   
                              <h3>Mis cupones:</h3>
                               <!--div_cupones-->
                              <div id="div_cupones"></div>
                              <!--div_cupones-->                           
                          </div>
                          <div class="tab-pane fade" id="tab2">
                              <style>
                              #div_recompensas{display: block; margin:10px auto; /*background:rgba(0, 0, 0, 0.1); */border-radius: 10px; padding: 15px }
                              </style>   
                              <h3>Mis recompensas:</h3>
                               <!--div_recompensas-->
                              <div id="div_recompensas"></div>
                              <!--div_recompensas-->                           
                          </div>
                          <div class="tab-pane fade" id="tab_promociones_cliente">
                              <style>
                              #div_promociones{display: block; margin:10px auto; /*background:rgba(0, 0, 0, 0.1); */border-radius: 10px; padding: 15px }
                              </style>   
                              <h3>Mis promociones:</h3>
                               <!--div_promociones-->
                              <div id="div_promociones"></div>
                              <!--div_promociones-->                           
                          </div>
                          <div class="tab-pane fade" id="tab_ziikfor">
                              <style>
                              
                              </style>   
                              <h3></h3>
                               <!--div_ziikfor-->
                              <div id="div_ziikfor">
                                 
                                 <img class="visible-xs" src="http://lovelocal.mx/images/250x500.jpg" style="margin:0px auto; display:block"/> 
                                 <img class="hidden-xs" src="http://lovelocal.mx/images/650x650.jpg" style="margin:0px auto; display:block" /> 

                              </div>
                              <!--div_ziikfor-->
                        </div>
                        <div class="tab-pane fade in active" id="promorandom">
                              <div id="promocionesrandom">
                                 <!--Promociones-->
      <?php
                if ($id_perfil_nota > 0)
                {  
                  $c_pro=buscar("p.local, p.calle
            ,p.no_exterior
            ,p.no_interior
            ,p.colonia
            ,p.municipio
            ,est.estado
            ,p.codigo_postal,
            pro.id_perfil,pro.id_promocion,pro.promocion,pro.imagen,pro.descripcion_corta","promociones_perfiles pro, perfiles p, estados est","WHERE pro.id_perfil = '".$id_perfil_nota."' AND  pro.estatus='Activo'  AND pro.id_perfil=p.id_perfil AND p.id_estado = est.id_estado ORDER BY pro.id_promocion DESC limit 6",false);
                }
                else
                { 
                //Buscar promociones
                              $c_pro=buscar("p.local, p.calle
            ,p.no_exterior
            ,p.no_interior
            ,p.colonia
            ,p.municipio
            ,est.estado
            ,p.codigo_postal,
            pro.id_perfil,pro.id_promocion,pro.promocion,pro.imagen,pro.descripcion_corta","promociones_perfiles pro, perfiles p, estados est","WHERE pro.estatus='Activo'  AND pro.id_perfil=p.id_perfil AND p.id_estado = est.id_estado ORDER BY RAND() limit 6",false);
                }
                              if($c_pro->num_rows>0):
                                 ?>
                                 <!--<h3 class="bottommargin_10 topmargin_10 blue">PROMOCIONES</h3>
                                 <p class="notedesc">Nuestra especialidad es consentirte, además de nuestros descuentos te ofrecemos estas promociones:</p>-->
                                 
                                 <?
                      //$promociones_pendientes=0;
                      /*if(empty($se_id_cliente) and empty($se_usuario_cliente) and empty($se_password_cliente)):
                        ?>
                        <p><a href="../registro-clientes/?per=<?=$id_perfil?>">Regístrate en lovelocal.mx y descarga tu promoción.</a></p>
                        <div class="clearfix"></div>
                        
                        <?
                        
                      endif;*/                      
                      ?>
                                 <div id="message_promocion"></div>
                                 <div id="div_promociones" class="isotope masonry-layout row ls_fondo4">
                                    <?
                                    while($f_pro=$c_pro->fetch_assoc()):
                                       $id_promocion=$f_pro["id_promocion"];
                                       $promocion=cadena($f_pro["promocion"]);
                                       $local=cadena($f_pro["local"]);
                                       $imagen_promocion=$f_pro["imagen"];
                                       $id_perfil=$f_pro["id_perfil"];

    $calle=cadena($f_pro["calle"]);
    $no_exterior=cadena($f_pro["no_exterior"]);
    $no_interior=cadena($f_pro["no_interior"]);
    $colonia=cadena($f_pro["colonia"]);
    $municipio=cadena($f_pro["municipio"]);
    $estado=cadena($f_pro["estado"]);
    $codigo_postal=cadena($f_pro["codigo_postal"]);

                                       $descripcion_corta_promocion=cadena($f_pro["descripcion_corta"]);

$direccion="";
$direccion_mostrar="";
if(!empty($calle)):
  $direccion_mostrar.=", ".$calle;
  $direccion.=$calle." ";
endif;
if(!empty($no_exterior)):
  $direccion_mostrar.=", #".$no_exterior;
  $direccion.=" ".$no_exterior.", ";
endif;
if(!empty($no_interior)):
  $direccion_mostrar.=", ".$no_interior;
  //$direccion.=" ".$no_interior.", ";
endif;
if(!empty($colonia)):
  $direccion_mostrar.=", ".$colonia;
  $direccion.=$colonia.", ";
endif;
if(!empty($municipio)):
  $direccion_mostrar.=", ".$municipio;
  $direccion.=$municipio." ";
endif;
if(!empty($estado)):
  $direccion_mostrar.=", ".$estado;
  $direccion.=$estado.", ";
endif;
if(!empty($codigo_postal)):
  $direccion_mostrar.=", C.P. ".$codigo_postal;
  //$direccion.="C.P. ".$codigo_postal;
endif;
                          ?>
                          <article class="isotope-item col-lg-4 col-md-4 col-sm-6 col-xs-12 post format-standard">
                                        <?
                            if(!empty($imagen_promocion) and file_exists("../administrador/promociones/images/".$imagen_promocion)):
                              ?><a href="../perfil/?per=<?=$id_perfil?>&perfil=<?=$local_perfil?>" class="zoom first" title="<?=$promocion?>" >
                                             <div class="entry-thumbnail imgpromocion" style="height:210px">

                                                 
                                                    <img src="../administrador/promociones/images/<?=$imagen_promocion?>" class="attachment-shop_thumbnail" alt="<?=$promocion?>">
                                                 

                                 <header class="promociontexto entry-header" style=" background:rgba(11, 88, 150, 0.8); height:100px">
                  <?
                  if(!empty($promocion)):
                  ?>
                                         <h4 class="white" style="font-size:14px !important; font-weight:normal;">
                                             <strong style="display:block;font-size:18px !important; font-weight:bold;padding-bottom:5px"><?=$local?></strong>
                                             <?=$promocion?><br />
                                             <?php
                                             if(!empty($direccion)):
                        $direccion_mostrar.=", México";
                        $direccion.="México";
                      ?>
                                 <!--<h3>Ubicación</h3>-->
                                 <p style="font-size: 12px; padding-top:5px">
                                 <?='Dirección: '.substr($direccion_mostrar,2)?>
                                 </p>
                                  <?
                    endif;
                    ?>
                                         </h4>
                  <?
                    endif;
                  ?>                        
                </header>
                  <!-- .entry-header -->

                              </div></a>
                                <?
                            endif;
                            ?>
                            <!--<div class="promociondetalle post-content">
                              <div class="entry-content">
                                                                                
                                <?
                                                if(!empty($descripcion_corta_promocion) and $descripcion_corta_promocion!="<br>"):
                                                   ?>
                                                   <p><?=$descripcion_corta_promocion?></p>
                                                   <?
                                                endif;
                                                if((!empty($se_id_cliente) and !empty($se_usuario_cliente) and !empty($se_password_cliente) /*and empty($promociones_pendientes)*/) or
                                  (!empty($se_id_cliente) and !empty($se_id_facebook) and !empty($se_email_cliente) /*and empty($promociones_pendientes)*/)
                                  ):
                                  /*
                                                   $c_pro_cli=buscar("COUNT(id_registro) AS total_promociones","promociones_clientes","WHERE id_perfil='".$p_per."' AND id_cliente='".$se_id_cliente."' AND id_promocion='".$id_promocion."'");
                                                   while($f_pro_cli=$c_pro_cli->fetch_assoc()):
                                                      $total_promociones=$f_pro_cli["total_promociones"];
                                                   endwhile;
                                                   if(empty($total_promociones)):                                 
                                  */
                                    ?>
                                                      <!--<a class="theme_button divider_20 descarga_promocion" id_perfil="<?=$id_perfil?>" id_promocion="<?=$id_promocion?>" href="#">Descargar promoción</a>-->

                                                      <?
                                    /*
                                                   endif;
                                  $c_pro_cli->free();
                                  unset($total_promociones);
                                  */
                                               endif;
                                               ?>
                               <!--</div><!-- .entry-content -->
                            <!--</div><!-- .post-content -->
                          </article>
                          <!-- .post -->                         
                          <?
                                       unset($id_promocion,$promocion,$imagen_promocion,$descripcion_corta_promocion);
                                    endwhile;
                                    ?>
                                 </div>
                                 <?
                      //unset($promociones_pendientes);
                              endif; 
                    $c_pro->free();
                    ?>
      <!--end promociones-->
                              </div>                           
                          </div>
                       </div>
                  </div>
                  <?
               endif;
               ?>
            </div>
          </div>
      </section>      
   <?
	include_once("../inc/publicidad.php");
	include_once("../inc/copyright.php");
	?>
	</div><!-- eof #box_wrapper -->
</div>
<script src="../js/compressed.js"></script><script src="../js/main.js"></script>
<script src="../js/jquery.form.js"></script>
<script>
"use strict";
jQuery(document).ready(function(){
	//configuracion_textareas();
	
	var bar = jQuery('.bar_datos');
	var percent = jQuery('.percent_datos');
	var status = jQuery('#status_datos');
	jQuery('#form_datos').ajaxForm(
		{
		 beforeSend: function(){
			  status.empty();
			  var percentVal='0%';
			  bar.width(percentVal)
			  percent.html(percentVal);
		 },
		 uploadProgress: function(event, position, total, percentComplete) {
			  var percentVal = percentComplete + '%';
			  bar.width(percentVal)
			  percent.html(percentVal);
		 },
		 success: function() {
			  var percentVal = '100%';
			  bar.width(percentVal)
			  percent.html(percentVal);
		 },
		complete: function(xhr) {
			var respuesta=xhr.responseText;
			status.html(respuesta);
			if(jQuery('#status_datos div.exito').length){
				setTimeout(function(){
					status.empty();
					var percentVal = '0%';
					bar.width(percentVal)
					percent.html(percentVal);
					consultar_datos();
				}, 4000);
			}
			else if(jQuery('#status div.error').length){
				setTimeout(function(){ 
					status.empty();
					var percentVal = '0%';
					bar.width(percentVal)
					percent.html(percentVal);
				}, 4000);
			}
		}
	});
	function consultar_datos(){
		//alert("desde consultar datos");
		jQuery("#div_datos").empty().append("<img src='http://www.lovelocal.mx/administrador/images/gifs/loading.gif' width='30' style='border:none;'>");			
		var url="../inc/ajax_consulta_datos_cliente.php";
		var posting=jQuery.post(url);
		posting.done(function(data){
			//alert("data:"+data);
			jQuery("#div_datos").empty().append(data);
			/*new nicEditor({buttonList:['bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','image','link','unlink']}).panelInstance("sitio_web");*/
		});
	}
	function configuracion_textareas(){
		new nicEditor({buttonList:['bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','image','link','unlink']}).panelInstance("sitio_web");
	}
});
</script>
</body>
</html>