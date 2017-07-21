<?
session_start();
ini_set("display_errors","Off");
$se_id_cliente=$_SESSION["s_id_cliente"];
$se_id_facebook=isset($_SESSION["s_id_facebook"]) ? $_SESSION["s_id_facebook"] : "";
$se_email_cliente=isset($_SESSION["s_email_cliente"]) ? $_SESSION["s_email_cliente"] : "";
$se_usuario_cliente=$_SESSION["s_usuario_cliente"];
$se_password_cliente=$_SESSION["s_password_cliente"];
$se_id_perfil=isset($_SESSION["s_id_perfil"]) ? $_SESSION["s_id_perfil"] : "";
$se_usuario_perfil=isset($_SESSION["s_usuario_perfil"]) ? $_SESSION["s_usuario_perfil"] : "";
$se_password_perfil=isset($_SESSION["s_password_perfil"]) ? $_SESSION["s_password_perfil"] : "";
include_once("../administrador/php/config.php");
include_once("../administrador/php/func.php");
include_once("../administrador/php/func_bd.php");
?>
<!DOCTYPE html> <html class="no-js"> 
<head> 
<title>Aviso de privacidad - LoveLocal</title> 
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
</head>
<body><!--[if lt IE 9]> <div class="bg-danger text-center">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/" class="highlight">upgrade your browser</a> to improve your 
experience.</div><![endif]-->
<div class="boxed pattern8" id="canvas">
	<div class="container" id="box_wrapper">
   <?
	include_once("../inc/header.php");
	
	include_once("../inc/form_busqueda_horizontal2.php");
	
	?>
	<section class="ls ms section_padding_10 section_padding_top_15 table_section">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 selected">
					<h3 class="topmargin_0">Aviso de privacidad</h3>
					<p class="text-center">Aviso de Privacidad Integral <strong>ZIIKFOR S.A de C.V</strong></p>
               <ol>
                  <li>
               		
                     <p>   	
                  	<strong><u>IDENTIDAD Y DOMICILIO DEL RESPONSABLE.</u></strong>&nbsp;El presente Aviso de Privacidad (en lo  sucesivo referido como &ldquo;Aviso&rdquo;) establece los términos y condiciones en virtud  de los cuales <strong>LoveLocal  S.A de C.V</strong>. (en  adelante &ldquo;<strong>LoveLocal</strong>&rdquo;), con domicilio para oír y recibir notificaciones  en San  ramón # 34, colonia del valle, código postal 03100, delegación, Delegación  Benito Juárez, CDMX; en su  carácter de Responsable (o el Encargado que designe LoveLocal) tratará los datos personales del Titular.
                  	</p>
                  </li>
                  <li><strong><u>CONSENTIMIENTO DEL TITULAR.</u></strong>&nbsp;Para efectos de lo dispuesto en la Ley  Federal de Protección de Datos Personales en Posesión de los Particulares (la  &ldquo;LFPDP&rdquo;) y demás legislación aplicable, el Titular manifiesta (i) que el  presente Aviso le ha sido dado a conocer por el Responsable, (ii) haber leído,  entendido y acordado los términos expuestos en este Aviso, por lo que otorga su  consentimiento respecto del tratamiento de sus datos personales. En caso de que  los datos personales recopilados incluyan datos patrimoniales o financieros,  mediante la firma del contrato correspondiente, sea en formato impreso, o  utilizando medios electrónicos y sus correspondientes procesos para la  formación del consentimiento, se llevarán a cabo actos que constituyen el  consentimiento expreso del titular y (iii) que otorga su consentimiento para  que LoveLocal o sus Encargados realicen transferencias y/o remisiones de datos  personales en términos del apartado 6 del presente Aviso.
                  	<p></p>
                  </li>
                  <li><strong><u>DATOS PERSONALES QUE RECABAMOS.</u></strong>&nbsp;LoveLocal puede recolectar datos personales del  Titular mediante la entrega directa y/o personal por cualquier medio de  contacto entre el Titular y el Responsable o sus Encargados. También puede  recolectar datos personales de manera indirecta a través de fuentes de acceso  público y de otras fuentes disponibles en el mercado.&nbsp;
                  	<p></p>
	                  <p>LoveLocal  también recaba datos  relacionados con la prestación de los servicios de telecomunicaciones que  brinda y datos referentes al acceso y/o uso de dichos servicios.</p>
                  </li>
                  <li>
                  	<strong><u>FINALIDAD DE LOS DATOS PERSONALES.</u></strong>
                  	<p><br>
   &nbsp;<strong><u>FINALIDADES PRIMARIAS.</u></strong>&nbsp;LoveLocal tratará los datos  personales del Titular con la finalidad de llevar a cabo las actividades y  gestiones enfocadas al cumplimiento de las obligaciones originadas y derivadas  de cualquier relación jurídica y comercial que establezca con motivo de la  prestación de sus servicios; facturación; cobranza; crédito; atención a  clientes; servicio técnico; otorgamiento de garantías; gestión de servicios de  valor agregado y contenidos; administración de aplicaciones y sitios Web;  contacto con el cliente, y proporcionar, renovar, cambiar, devolver o cancelar  los servicios que el Titular solicite. Asimismo para actividades relacionadas  con el control de acceso y resguardo de los recursos materiales y humanos  dentro de las instalaciones del Responsable.</p>
               <p><strong><u>FINALIDADES SECUNDARIAS.</u></strong>&nbsp;Asimismo, LoveLocal tratará datos personales  para otras finalidades como enviar notificación de ofertas, avisos y/o mensajes  promocionales; comunicaciones con fines de mercadotecnia, publicidad o  telemarketing sobre productos y servicios nuevos o existentes ya sean propios o  de socios comerciales; realizar encuestas; estadísticas; estudios de mercado,  registros sobre hábitos de consumo a través de herramientas de captura  automática de datos, intereses y comportamiento; realizar programas de beneficios  e incentivos; participar en redes sociales, chats y/o foros de discusión;  participar en eventos, trivias, concursos, rifas, juegos y sorteos; evaluar la  calidad de los servicios; y en general para cualquier actividad encaminada a  promover, mantener, mejorar y evaluar sus productos y servicios.</p>
               	<p>
                  Puede oponerse al tratamiento de sus datos para las finalidades  secundarias a través de los medios puestos a su disposición para el ejercicio  de sus derechos ARCO. En caso de no oponerse en un plazo de cinco días hábiles  posteriores a que sus datos fueron recabados, se entenderá que ha otorgado su  consentimiento.</p>
                  </li>
                  <li>
                  	<p><strong><u>VIDEOVIGILANCIA Y FOTOGRAFIA.</u></strong>Toda persona que ingrese a las instalaciones  del Responsable, podrá ser videograbada por nuestras cámaras de seguridad,  asimismo podría ser fotografiada.
                     </p>
                  	<p>Las imágenes captadas por las cámaras del sistema de circuito cerrado de  televisión serán utilizadas para su seguridad y de las personas que nos  visitan, con el propósito de monitorear vía remota los inmuebles y, confirmar  en tiempo real cualquier condición de riesgo para minimizarla. Asimismo, con el  fin de resguardar los recursos materiales y humanos dentro de nuestras  instalaciones. Las fotografías son destinadas a llevar a cabo el control de  acceso a nuestras instalaciones corporativas.<br>
                     </p>
                     <p>
	                  Las videograbaciones y/o fotografías son almacenadas de 25 a 35 días en  los inmuebles.</p>
                  </li>
                  <li>
                  	<p><strong><u>TRANSFERENCIAS Y/O REMISIONES DE DATOS.</u></strong>&nbsp;LoveLocal requiere compartir los datos  personales del Titular con el objeto de dar cumplimiento a sus obligaciones  jurídicas y/o comerciales, para lo cual ha celebrado o celebrará diversos  acuerdos comerciales tanto en territorio nacional como en el extranjero. Los  receptores de los datos personales, están obligados por virtud del contrato  correspondiente, a mantener la confidencialidad de los datos personales  suministrados y a observar el presente Aviso. LoveLocal y/o sus Encargados podrán  comunicar los datos personales recolectados a cualquier otra sociedad del mismo  grupo empresarial al que pertenezca el Responsable y que opere con los mismos  procesos y políticas internas, sea que se encuentre en territorio nacional o en  el extranjero, para su tratamiento con las mismas finalidades descritas en este  Aviso.
                     </p>
                  	<p>
                  Su información personal puede remitirse, almacenarse y procesarse en un país  distinto de donde se proporcionó, lo cual se llevará a cabo de conformidad con  las leyes de protección de datos aplicables. Tomamos medidas para proteger la  información personal sin importar el país donde se almacena o a donde se  remite. Tenemos procedimientos y controles oportunos para procurar esta  protección.
                  </p>
                  <p>
                  LoveLocal no requiere el consentimiento del Titular para realizar transferencias  de datos personales nacionales o internacionales en los casos previstos en el  Artículo 37 de la LFPDP o en cualquier otro caso de excepción previsto por la  misma u otra legislación aplicable.
               </p>
                  </li>
                  <li><strong><u>PROCEDIMIENTO PARA EJERCER LOS DERECHOS ARCO Y  REVOCACIÓN DEL CONSENTIMIENTO.</u></strong>&nbsp;El  Titular tiene, en todo momento, derecho de acceder, rectificar y cancelar sus  datos, así como de oponerse al tratamiento de los mismos o revocar el  consentimiento que haya proporcionado presentando una solicitud en el formato  que para tal fin le entregaremos a petición expresa, misma que debe contener la  información y documentación siguiente:</li>
                  <ol>
                     <li>Nombre  del Titular y domicilio u otro medio para comunicarle la respuesta a su  solicitud;</li>
                     <li>Los  documentos vigentes que acrediten su identidad (copia simple en formato impreso  o electrónico de su credencial de elector, pasaporte o Visa) o, en su caso, la  representación legal del Titular (copia simple en formato impreso o electrónico  de la carta poder simple con firma autógrafa del Titular, el mandatario y sus  correspondientes identificaciones oficiales vigentes – credencial de elector,  pasaporte o Visa);</li>
                     <li>La  descripción clara y precisa de los datos respecto de los que busca ejercer  alguno de los Derechos ARCO, y</li>
                     <li>Cualquier  otro elemento o documento que facilite la localización de los datos personales  del Titular.
                     </li>
                   </ol>

                     	<p></p>
                     	<p>En el caso de las solicitudes de rectificación de datos personales, el  Titular deberá también indicar las modificaciones a realizarse y aportar la  documentación que sustente su petición.</p>
                        <p>
                  Para dar cumplimiento a la obligación de acceso a sus datos personales,  se hará previa acreditación de la identidad del titular o personalidad del  representante; poniendo la información a disposición en sitio en el domicilio  del Responsable. Se podrá acordar otro medio entre el Titular y el Responsable  siempre que la información solicitada así lo permita.</p>
                  <p>
                  Para la petición del formato, recepción y respuesta de las solicitudes  para ejercer sus derechos ARCO, la revocación de su consentimiento y los demás  derechos previstos en la LFPDP ponemos a su disposición los siguientes medios:</p>
                  
                  		<strong><u>Oficina de Protección de Datos Personales</u></strong>
               	<p>
                  Correo: <a href="mailto:sitioweb@lovelocal.mx">sitioweb@lovelocal.mx</a></p>
                  <p>
                  Presencial: San  ramón # 34, Colonia del valle, Código postal 03100, Delegación, Delegación  Benito Juárez, CDMX.
                  </p>
                  <p>
                  Cabe enfatizar que la información  personal se puede modificar desde el perfil personal de cada cliente, todo esto  quedara actualizado en tiempo real al momento de la modificación dentro del  perfil. Así mismo los medios proporcionados con anterioridad, se ofrecen para  dar cumplimiento a la LFPDP.
                  </p>
                  <p>
                  En caso de que la información proporcionada en su solicitud sea errónea  o insuficiente, o bien, no se acompañen los documentos de acreditación  correspondientes, podremos solicitarle, dentro de los cinco días hábiles  siguientes a la recepción de la solicitud, que aporte los elementos o  documentos necesarios para dar trámite a la misma. El Titular contará con diez  días hábiles para atender el requerimiento, contados a partir del día siguiente  en que lo haya recibido. De no dar respuesta en dicho plazo, se tendrá por no  presentada la solicitud correspondiente.
                  </p>
                  <p>
                  LoveLocal responderá al Titular en un plazo máximo de veinte días hábiles,  contados desde la fecha en que se recibió la solicitud a efecto de que, si  resulta procedente, haga efectiva la misma dentro de los quince días hábiles  siguientes a que se comunique la respuesta. En todos los casos, la respuesta se  dará por la misma vía por la que haya presentado su solicitud o en su caso por  cualquier otro medio acordado con el Titular. Los plazos antes referidos podrán  ser ampliados en términos de la LFPDP.</p>
                  
                     </li>
                  <li><strong><u>LIMITACIÓN DE USO Y DIVULGACIÓN DE LA INFORMACIÓN.</u></strong>&nbsp;El Responsable y/o sus Encargados conservarán  los datos personales del Titular durante el tiempo que sea necesario para  procesar sus solicitudes de información, productos y/o servicios, así como para  mantener los registros contables, financieros y de auditoria en términos de la  LFPDP y de la legislación mercantil, fiscal y administrativa vigente.
                  
                  <p>
                  Los datos personales recolectados se encontrarán protegidos por medidas de  seguridad administrativas, técnicas y físicas adecuadas contra el daño,  pérdida, alteración, destrucción o uso, acceso o tratamiento no autorizados, de  conformidad con lo dispuesto en la LFPDP y la demás legislación aplicable. No  obstante lo señalado anteriormente, LoveLocal no garantiza que terceros no  autorizados no puedan tener acceso a los sistemas físicos o lógicos de los  Titulares o del Responsable o en los documentos electrónicos y archivos  almacenados en sus sistemas. En consecuencia, LoveLocal no será en ningún caso responsable  de los daños y perjuicios que pudieran derivarse de dicho acceso no autorizado.</p>
                  <p>
                  Usted o su representante legal debidamente acreditado podrán limitar el uso o  divulgación de sus datos personales a través de los mismos medios y  procedimientos dispuestos para el ejercicio de los Derechos ARCO. Si su  solicitud resulta procedente, será registrado en el listado de exclusión  dispuesto por LoveLocal para dejar de recibir información relativa a campañas  publicitarias o de mercadotecnia.
                  </p>
                  <p>
                  Asimismo, le asiste el derecho de inscribirse en el Registro Público para  Evitar Publicidad (REPEP) de la PROFECO&nbsp;<a href="http://repep.profeco.gob.mx/" target="_blank">http://repep.profeco.gob.mx</a>					
                  </p>
                  <p>
                  En caso de que usted considere que LoveLocal ha vulnerado su derecho a la protección  de sus datos personales, puede acudir al Instituto Nacional de Transparencia,  Acceso a la Información y Protección de Datos Personales (&ldquo;INAI&rdquo;).</p>	
						</li>
                  <li><strong><u>RECOLECCIÓN DE DATOS AL NAVEGAR EN PÁGINAS WEB DE ZIIKFOR.</u></strong>&nbsp;LoveLocal puede recabar datos a través de sus  sitios Web, o mediante el uso de herramientas de captura automática de datos.  Dichas herramientas le permiten recolectar la información que envía su  navegador a dichos sitios Web, tales como el tipo de navegador que utiliza, el  idioma de usuario, los tiempos de acceso, y la dirección IP de sitios Web que  utilizó para acceder a los sitios del Responsable o sus Encargados.
                 		<p></p>
                  	<p>Dentro de las herramientas de captura automática de datos utilizadas por  LoveLocal en sus sitios y páginas web se encuentran las cookies, los Web beacons,  y los enlaces en los correos electrónicos.
                     </p>
                     <p>
		                  <em>Vínculos en los correos electrónicos de LoveLocal.</em>- Los correos electrónicos pueden incluir vínculos  que permiten a LoveLocal saber si usted activó dicho vínculo y visitó la página  web de destino, pudiendo esta información ser incluida en su perfil. Asimismo,  pueden incluir vínculos diseñados para dirigirlo a las secciones relevantes de  los sitios Web, al re-direccionarlo a través de los servidores de LoveLocal el  sistema de re-direccionamiento permite determinar la eficacia de las campañas  de marketing en línea.
                     </p>
                     <p>
		                  <em>Protección a menores, a personas en estado de  interdicción o incapacidad.</em>- LoveLocal  alienta a los padres y/o tutores a tomar un papel activo en las actividades en  línea de sus hijos o representados. En caso de que considere que los datos  personales han sido proporcionados por un menor o por una persona en estado de  interdicción o incapacidad, en contravención al presente Aviso, por favor envíe  un correo electrónico a la dirección: sitioweb@lovelocal.mx &nbsp;para que LoveLocal  proceda a eliminar tales datos personales a la brevedad.
                     </p>
                  </li>
                  <li><strong><u>CAMBIOS AL AVISO.</u></strong>&nbsp;LoveLocal se reserva el derecho de actualizar  periódicamente el presente Aviso para reflejar los cambios en sus prácticas de  información. Es responsabilidad del Titular revisar el contenido del Aviso en  el sitio: www.lovelocal.mx/login/ &nbsp;o solicitándolo al correo electrónico&nbsp;sitioweb@lovelocal.mx  El Responsable entenderá que de no expresar lo contrario, significa que el  Titular ha leído, entendido y acordado los términos ahí expuestos, lo que  constituye su consentimiento a los cambios y/o actualizaciones respecto al  tratamiento de sus datos personales.</li>
               </ol>
				</div>
			</div>
		</div>
	</section>   
   <?
	include_once("../inc/publicidad.php");
	include_once("../inc/copyright.php");
	?>

</div><!-- eof #box_wrapper -->
</div>
<script src="../js/compressed.js"></script><script src="../js/main.js"></script></body></html>