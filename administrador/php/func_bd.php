<?php
function buscar($campos,$tabla,$condicion,$imprimir=false){
	global $mysqli;
	if($imprimir==true):
		echo "select ".$campos." from ".$tabla." ".$condicion."<br />";
	endif;
	$c_cf=$mysqli->query("select ".$campos." from ".$tabla." ".$condicion);
	return $c_cf;
}

function insertar($campos,$tabla,$valores,$imprimir=false){
	global $mysqli;
	$c_cf="insert into ".$tabla;
	if(!empty($campos)):
		$c_cf.=" (".$campos.") ";
	endif;
	$c_cf.=" values(".$valores.") ";
	if($imprimir==true):
		echo $c_cf."<br />";	
	endif;
	$r_cf=$mysqli->query($c_cf);
	if(!$r_cf):
		return false;
	else:
		return true;
	endif;
}

function actualizar($campos,$tabla,$condicion,$imprimir=false){
	global $mysqli;
	$c_cf="update ".$tabla;
	$c_cf.=" set ".$campos;
	$c_cf.=" ".$condicion;
	if($imprimir==true):
		echo $c_cf."<br />";	
	endif;
	$r_cf=$mysqli->query($c_cf);
	if(!$r_cf):
		return false;
	else:
		return true;
	endif;
}

function autonumerico($campo,$tabla){
	global $mysqli;
	$c_cf=buscar($campo,$tabla,"order by ".$campo." desc limit 1");
	while($f_cf=$c_cf->fetch_assoc()):
		$incremento=$f_cf[$campo]*1;
	endwhile;
	if(empty($incremento)):
		$incremento=1;
	endif;
	$c_cf2=$mysqli->query("ALTER TABLE ".$tabla." AUTO_INCREMENT=".$incremento);
	if(!$c_cf2):
		return false;
	else:
		return true;
	endif;
}

function eliminar($tabla,$condicion){
	global $mysqli;
	$c_cf=$mysqli->query("delete from ".$tabla." ".$condicion);
	if(!$c_cf):
		return false;
	else:
		return true;
	endif;
}
?>