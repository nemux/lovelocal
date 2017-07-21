<?
session_start();
$se_id_usuario=$_SESSION["s_id_usuario"];
$se_tipo_usuario=$_SESSION["s_tipo_usuario"];

include("php/config.php");
include("php/func.php");			
include("php/func_bd.php");

$p_notas_personales=cadenabd($_GET['notas_personales']);
$p_aleatorio=$_GET["aleatorio"];

if(!empty($p_aleatorio)	):
	//Actualizar notas_personales del super administrador
	$c_us=actualizar("notas='".$p_notas_personales."'","adm_usuarios","where id_usuario=".$se_id_usuario."");
endif;

//Consultar notas_personales del Super_Administrador
$c_us=buscar("notas","adm_usuarios","where id_usuario=".$se_id_usuario."");
//echo "select notas_personales from adm_usuarios","where id_usuario=".$se_id_usuario." and tipo_usuario='Super_Administrador'";
while($f_us=mysql_fetch_assoc($c_us)):
	$notas_personales=cadena($f_us['notas']);
endwhile;
$mysqli->close();
?>
<?=$notas_personales?>