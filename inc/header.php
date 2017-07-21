<?php
error_reporting(0);
?>
<header id="header" class="page_header header_white">
   <div class="container">
      <div class="row">
         <div class="col-lg-3 col-md-4 col-xs-12">
            <a href="http://www.lovelocal.mx/" class="logo top_logo"><img src="../images/logo.png" alt=""></a>
            <span style="" class="toggle_menu"><span></span></span>
         </div>
         <div class="col-lg-9 col-md-8 text-right">
            <div class="page_social_icons">
               <?
               $c_red=buscar("titulo,enlace","redes_sociales","WHERE estatus='activo' ORDER BY orden");
               if($c_red->num_rows>0):
                  ?>
                  <!--<span class="titulo_enlace">
                  Síguenos en: </span>-->
                  <?
                  while($f_red=$c_red->fetch_assoc()):
                     $titulo_red=$f_red["titulo"];
                     $enlace_red=cadena($f_red["enlace"]);
                     $clase_red="";
                     switch($titulo_red):
                        case "twitter":
                           $clase_red="rt-icon2-twitter3";
                        break;
                        case "facebook":
                           $clase_red="rt-icon2-facebook3";                      
                        break;
                        case "linkedin":
                           $clase_red="rt-icon2-linkedin";                       
                        break;
                        case "google":
                           $clase_red="rt-icon2-google-plus3";                      
                        break;
                        case "youtube":
                           $clase_red="rt-icon2-youtube";                        
                        break;
                        case "instagram":
                           $clase_red="rt-icon2-instagram2";                        
                        break;
                        case "flickr":
                           $clase_red="rt-icon2-flickr4s";                       
                        break;
                        case "skype":
                           $clase_red="rt-icon2-social-skype";                      
                        break;
                        case "pinterest":
                           $clase_red="rt-icon2-pinterest";                      
                        break;
                     endswitch;
                     ?>
                     <div class="teaser_icon size_small">
                        <a href="<?=$enlace_red?>" title="<?=$titulo_red?>" target="_blank"><i class="<?=$clase_red?>"></i></a>
                     </div>
                     <?
                     unset($titulo_red,$enlace_red,$clase_red);
                  endwhile;
                  ?>
                  &nbsp;
                  <?
               endif;
               /*
               <a class="enlace">Regístrate</a>
                | */
                if((isset($se_id_cliente) and isset($se_usuario_cliente) and !empty($se_id_cliente) and !empty($se_usuario_cliente)) or
                  (!empty($se_id_cliente) and !empty($se_id_facebook) and !empty($se_email_cliente))
                  ):
                  ?>
                  <span style="color:#fa5c5d; padding-left:30px;font-size:16px;">Bienvenido(a): 
                     <strong style="font-size:16px">
                        <? 
                        if(!empty($se_usuario_cliente)):
                           echo $se_usuario_cliente; 
                        else: 
                           echo $se_email_cliente; 
                        endif;
                        ?>
                     </strong>
                  </span> | 
                  <a href="http://www.lovelocal.mx/cliente_datos/" style="color:#03538E;font-size:16px;font-weight:bold;">Mis datos</a> |
                  <a class="enlace" href="http://www.lovelocal.mx/logout/" style="color:#03538E;">Salir</a>   
                  <?
               elseif(isset($se_id_perfil) and isset($se_usuario_perfil) and !empty($se_id_perfil) and !empty($se_usuario_perfil)):
                  ?>
                  <span style="color:#fa5c5d; padding-left:30px;font-size:16px;">Bienvenido(a): <strong style="font-size:16px"><?=$se_usuario_perfil?></strong></span> | 
                  <a href="http://www.lovelocal.mx/perfil_datos/" style="color:#03538E;font-size:16px; font-weight:bold;">Mis datos</a> |
                  <a class="enlace" href="http://www.lovelocal.mx/logout/" style="color:#03538E;">Salir</a>   
                  <?
               else:
                  ?>
                  <a class="enlace" href="http://www.lovelocal.mx/login/">Ingresa</a> / <a class="enlace" href="http://www.lovelocal.mx/registro-clientes/">Registro</a>
                  <?
                endif;
                ?>
               <!--
               <span class=""><i class="rt-icon2-pin-alt highlight"></i> 4321 Your Address, Country </span>
               <span class=""><i class="rt-icon2-newspaper-alt highlight"></i> 8 (800) 695-2684</span>
               <span class=""><i class="rt-icon2-envelope highlight"></i> support@company.com</span>
               -->
            </div>
         </div>
         <div class="col-lg-12 col-md-12 text-right nopadding">
            
            
            <?
            $c_seci=buscar("id_seccion,seccion","secciones","WHERE estatus='activo' ORDER BY orden ASC");
            $fiseci=$c_seci->num_rows;
            if($fiseci>0):
               ?>
               <nav class="mainmenu_wrapper">
                  <ul class="mainmenu nav sf-menu">
                     <?
                     $con_seci=0;
                     while($f_seci=$c_seci->fetch_assoc()):
                        $con_seci++;
                        $id_seccioni=$f_seci["id_seccion"];
                        $seccioni=cadena($f_seci["seccion"]);
                        ?>
                        <li><a href="../seccion/?sec=<?=$id_seccioni?>&seccion=<?=$seccioni?>"><?=$seccioni?></a></li>
                        <?
                        if($con_seci<$fiseci):
                           ?>
                           <li> | </li>             
                           <?
                        endif;
                        unset($id_seccioni,$seccioni);
                     endwhile;
                     ?>
                  </ul>
               </nav>
               <?
            endif;
            ?>
         </div>
      </div>
   </div>
</header>