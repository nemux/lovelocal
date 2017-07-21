<?php
session_start();
require_once __DIR__ . '/src/Facebook/autoload.php';
$fb = new Facebook\Facebook([
  'app_id' => '1065855423516582',//263928443976890
  'app_secret' => '3a9524c3e9fd02a3ca428b3ba47252fc',
  'default_graph_version' => 'v2.6', 
  'persistent_data_handler' => 'session'
  ]);
$helper = $fb->getRedirectLoginHelper();
$permissions = ['email']; // optional
try {
	if (isset($_SESSION['facebook_access_token'])) {
		$accessToken = $_SESSION['facebook_access_token'];
	} else {
  		$accessToken = $helper->getAccessToken();
	}
} catch(Facebook\Exceptions\FacebookResponseException $e) {
 	// When Graph returns an error
 	echo 'Graph returned an error: ' . $e->getMessage();

  	exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
 	// When validation fails or other local issues
	echo 'Facebook SDK returned an error: ' . $e->getMessage();
  	exit;
}
if(isset($accessToken)) {
	date_default_timezone_set('Mexico/General');
	$fecha_hora_actual=date("Y-m-d H:i:s");
	include("../administrador/php/config.php");
	include("../administrador/php/func.php");
	include("../administrador/php/func_bd.php");
	if (isset($_SESSION['facebook_access_token'])) {
		$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
	} else {
		// getting short-lived access token
		$_SESSION['facebook_access_token'] = (string) $accessToken;

	  	// OAuth 2.0 client handler
		$oAuth2Client = $fb->getOAuth2Client();

		// Exchanges a short-lived access token for a long-lived one
		$longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);

		$_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;

		// setting default access token to be used in script
		$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
	}

	// redirect the user back to the same page if it has "code" GET variable
	if (isset($_GET['code'])) {
		header('Location: ./');
	}
	// getting basic info about user
	try {
		$profile_request = $fb->get('/me?fields=name,first_name,last_name,email');
		$profile = $profile_request->getGraphNode()->asArray();
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
		// When Graph returns an error
		echo 'Graph returned an error: ' . $e->getMessage();
		session_destroy();
		// redirecting user back to app login page
		header("Location: ./");
		exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
		// When validation fails or other local issues
		echo 'Facebook SDK returned an error: ' . $e->getMessage();
		exit;
	}
	/*
	// printing $profile array on the screen which holds the basic info about user
	echo "<pre>";
	print_r($profile);
	echo "</pre>";	
	echo "<br>";
	echo 'Logged in as:' .$profile["name"].'<br>';
	echo "accessToken: ".$accessToken."<br>";
	*/
	$name=$profile["name"];
	$first_name=$profile["first_name"];
	$last_name=$profile["last_name"];
	$email=$profile["email"];	
	$id=$profile["id"];
	//Buscar con email e ID Facebook
	$c_cli=buscar("id_cliente","clientes","WHERE email='".$email."' AND id_facebook='".$id."'");
	while($f_cli=$c_cli->fetch_assoc()):
		$id_cliente=$f_cli["id_cliente"];
	endwhile;
	if(!empty($id_cliente))://Ya existe con ID Facebook y email
		//Crear las sesiones
		$_SESSION["s_id_cliente"]=$id_cliente;
		$_SESSION["s_id_facebook"]=$id;
		$_SESSION["s_email_cliente"]=$email;
		header('Location: ../cliente_datos/');
	else://No existe 
		//Buscar con email
		$c_cli2=buscar("id_cliente","clientes","WHERE email='".$email."'");
		while($f_cli2=$c_cli2->fetch_assoc()):
			$id_cliente2=$f_cli2["id_cliente"];
		endwhile;
		if(!empty($id_cliente2))://Ya existe con email registrado
			//Actualizar para agregar el ID Facebook
			$c_cli3=actualizar("nombre='".$first_name."',apellidos='".$last_name."',id_facebook='".$id."'","clientes","WHERE id_cliente='".$id_cliente2."'");
			//Crear las sesiones
			$_SESSION["s_id_cliente"]=$id_cliente2;
			$_SESSION["s_id_facebook"]=$id;
			$_SESSION["s_email_cliente"]=$email;
			header('Location: ../cliente_datos/');
		else:
			//Registrarlo
			$c_cli3=insertar("nombres,apellidos,id_facebook,email,estatus,fecha_hora_registro","clientes","'".$first_name."','".$last_name."','".$id."','".$email."','activo','".$fecha_hora_actual."'");
			if($c_cli3==true):
				//Crear las sesiones
				$_SESSION["s_id_cliente"]=$id_cliente;
				$_SESSION["s_id_facebook"]=$id;
				$_SESSION["s_email_cliente"]=$email;
				header('Location: ../cliente_datos/');
			else:
				echo 'Error: No fue posible registrarte. Intenta de nuevo.';
			endif;
		endif;
	endif;
  	// Now you can redirect to another page and use the access token from $_SESSION['facebook_access_token']
} else {
	// replace your website URL same as added in the developers.facebook.com/apps e.g. if you used http instead of https and you used non-www version or www version of your website then you must add the same here
	$loginUrl = $helper->getLoginUrl('http://www.lovelocal.mx/fb/index.php', $permissions);
	echo '<a href="' . $loginUrl . '"><img src="img/btn_facebook.png"></a>';
}