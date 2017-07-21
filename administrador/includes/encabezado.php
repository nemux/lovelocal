<?
$se_id_usuario=$_SESSION["s_id_usuario"];
?>
<div id="imagen_encabezado">
<img src="http://www.lovelocal.mx/images/logo.png" height="40"" alt="">
</div>
<div id="titulo_encabezado">
<?
if(!empty($se_id_usuario)):
	//Nombre de usuario
	$c_us=buscar("nombre_completo,notas,notas_sistema","adm_usuarios","where id_usuario=".$se_id_usuario);
	while($f_us=$c_us->fetch_assoc()):
		$nombre_completo=cadena($f_us['nombre_completo']);
	endwhile;
	?>
   <div id="bienvenida_encabezado">
	   <p><a href="/administrador/usuarios/datos/" target="_top">Bienvenido(a):</a> <strong><?=$nombre_completo?></strong></p>
   </div>
	<?
	unset($nombre_completo);
endif;
?>
</div>