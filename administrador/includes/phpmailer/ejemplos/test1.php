<?
require_once('../class.phpmailer.php');
//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch

$mail->IsSMTP(); // telling the class to use SMTP

try {
 	$mail->Host       = "consultatudoc.com.mx"; // SMTP server
  $mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
  $mail->SMTPAuth   = true;                  // enable SMTP authentication
	$mail->SMTPSecure = "ssl";
  $mail->Port       = 465;                    // set the SMTP port for the GMAIL server
  $mail->Username   = "google@consultatudoc.com.mx"; // SMTP account username
  $mail->Password   = "m[9&oZMRkCoF";        // SMTP account password
  $mail->AddAddress('elisabet.santiago@gmail.com', 'Lis');
  $mail->SetFrom('google@consultatudoc.com.mx', 'First Last');
  $mail->AddReplyTo('google@consultatudoc.com.mx', 'Consulta tu doc');
  $mail->Subject = 'PHPMailer Test Subject via mail(), advanced';
  $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
  $mail->MsgHTML(file_get_contents('contents.html'));
  $mail->AddAttachment('images/phpmailer.gif');      // attachment
  $mail->AddAttachment('images/phpmailer_mini.gif'); // attachment
  $mail->Send();
  echo "Message Sent OK<p></p>\n";
} catch (phpmailerException $e) {
  echo $e->errorMessage(); //Pretty error messages from PHPMailer
} catch (Exception $e) {
  echo $e->getMessage(); //Boring error messages from anything else!
}
?>