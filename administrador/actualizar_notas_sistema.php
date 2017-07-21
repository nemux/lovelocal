<?
session_start();
$se_id_usuario=$_SESSION["s_id_usuario"];
$se_tipo_usuario=$_SESSION["s_tipo_usuario"];

include("php/config.php");
include("php/func.php");			
include("php/func_bd.php");

$p_notas_sistema=cadenabd($_GET['notas_sistema']);
$p_aleatorio=$_GET["aleatorio"];

if(!empty($p_aleatorio)	):
	//Actualizar notas del super administrador
	$c_us=actualizar("notas_sistema='".$p_notas_sistema."'","adm_usuarios","where id_usuario=".$se_id_usuario." and tipo_usuario='Super_Administrador'");
	//echo "actualizar: update adm_usuarios set notas_sistema='".$p_notas_sistema."' where id_usuario=".$se_id_usuario." and tipo_usuario='Super_Administrador' <br>";
endif;

//Consultar notas del Super_Administrador
$c_us=buscar("notas_sistema","adm_usuarios","where id_usuario=".$se_id_usuario." and tipo_usuario='Super_Administrador'");
//echo "select notas_sistema from adm_usuarios","where id_usuario=".$se_id_usuario." and tipo_usuario='Super_Administrador'";
while($f_us=mysql_fetch_assoc($c_us)):
	$notas_sistema=cadena($f_us['notas_sistema']);
endwhile;
$mysqli->close();

die($notas_sistema);