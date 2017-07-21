<?
include_once("../administrador/php/config.php");
include_once("../administrador/php/func.php");
include_once("../administrador/php/func_bd.php");
$p_not=isset($_GET["not"]) ? $_GET["not"]*1 : "";
if(!empty($p_not)):
	$c_not=buscar("id_nota,nota,imagen,descripcion_completa","notas_editoriales","WHERE id_nota='".$p_not."'");	
	while($f_not=$c_not->fetch_assoc()):
		$id_nota=$f_not["id_nota"];
		$nota=cadena($f_not["nota"]);
		$imagen_nota=$f_not["imagen"];
		$descripcion_completa_nota=cadena($f_not["descripcion_completa"],true);
	endwhile;
endif;
?>
<!DOCTYPE html> <html class="no-js"> 
<head> 
<title><? if(!empty($nota)): echo $nota." - ";endif;?>ZiiKFOR</title> 
<!-- Favicon -->
<link rel="shortcut icon" href="http://www.ziikfor.com/images/favicon.png">
<meta charset="utf-8"><!--[if IE]> <meta http-equiv="X-UA-Compatible" content="IE=edge"><![endif]--> 
<meta name="description" content=""> 
<meta name="viewport" content="width=device-width, initial-scale=1"> 
<link rel="stylesheet" href="../css/bootstrap.min.css">
<link rel="stylesheet" href="../css/main.css" id="color-switcher-link">
<link rel="stylesheet" href="../css/animations.css">
<link rel="stylesheet" href="../css/fonts.css">
<script src="../js/vendor/modernizr-2.6.2.min.js"></script>
<!--[if lt IE 9]> <script src="js/vendor/html5shiv.min.js"></script> <script src="js/vendor/respond.min.js"></script><![endif]-->
</head>
<body><!--[if lt IE 9]> <div class="bg-danger text-center">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/" class="highlight">upgrade your browser</a> to improve your 
experience.</div><![endif]-->
<div class="boxed pattern8" id="canvas">
	<div class="container" id="box_wrapper">
   <?
	include_once("../inc/header.php");
	
	include_once("../inc/form_busqueda_horizontal.php");
	
	if(!empty($id_nota) and !empty($nota)):
		?>
      <section class="ls section_padding_15 table_section"><div class="container"><div class="row">
   	<div class="col-sm-12 text-left">
		<?
		if(!empty($imagen_nota) and file_exists("../administrador/notas_editoriales/images/".$imagen_nota)):
			?>
			<img class="" src="../administrador/notas_editoriales/images/<?=$imagen_nota?>" alt="<?=$nota?>">
			<?
		endif;
			if(!empty($nota)):
							?>
                     <h3 class="topmargin_10"><?=$nota?></h3>
                     <?
						endif;
						if(!empty($descripcion_completa_nota)):
							?>
                     <p class=""><?=$descripcion_completa_nota?></p>
                     <?
						endif;
		?>	
	   </div>
      </div></div></section>   
      <?
	endif;
	?>
   
	
   <?
	include_once("../inc/publicidad.php");
	include_once("../inc/copyright.php");
	?>

</div><!-- eof #box_wrapper -->
</div>
<script src="../js/compressed.js"></script><script src="../js/main.js"></script></body></html>