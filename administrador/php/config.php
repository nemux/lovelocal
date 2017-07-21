<?php
error_reporting(0);
$mysqli = new mysqli();
if($mysqli->connect_errno):
	echo "Error: ".$mysqli->connect_error."\n";
   exit;
endif;