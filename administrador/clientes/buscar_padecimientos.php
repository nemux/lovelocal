<?php
include("../php/config.php");
include("../php/func.php");			
include("../php/func_bd.php");
//get search term
$searchTerm = $_GET['term'];
//get matched data from skills table
$query=buscar("padecimiento","padecimientos","WHERE padecimiento LIKE '%".cadenabd($searchTerm)."%' AND estatus='activo' ORDER BY padecimiento",true);
while($row=mysql_fetch_assoc($query)):
	$data[]=$row['padecimiento'];
endwhile;
//return json data
echo json_encode($data);
?>