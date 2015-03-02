<?php
require 'class.phpmailer.php';

	$nombre = $_POST['fullname'];
	$email = $_POST['email'];
	$company = $_POST['company'];
	$phone = $_POST['phone'];
	$comentario = $_POST['comentario'];
	$error = '';
	

$mail = new PHPMailer();
 
$mail->isMail();//usamos Sendmail, también podemos usar mail() con isMail()
 
$mail->FromName = $nombre;
$mail->From = $email;//email de remitente desde donde se envía el correo.
 
$mail->AddAddress('hachewd@gmail.com', 'Hanzel Mata');//destinatario que va a recibir el correo
 
//$mail->AddCC('copia@dominio.com', 'copia');//envía una copia del correo a la dirección especificada
 
$mail->Subject = 'Visitante kmc-cr.com';
 
$mail->AltBody = 'cuerpo del mensaje en texto plano';//cuerpo con texto plano

$TxtMensa = "<html><head></head><body style='margin: 0; padding:0;'><table width='100%' border='0' cellspacing='0' cellpadding='5' style='font-family:Arial, Helvetica, sans-serif; font-size: 12px;'>";
$TxtMensa .= "<tr><td colspan='2'>Ha recibido un e-mail de: <strong>". $nombre." </strong></td></tr><tr><td colspan='2'>&nbsp;</td></tr><tr><td colspan='2'>Datos de contacto:</td></tr><tr><td colspan='2'>&nbsp;</td></tr><tr>";
$TxtMensa .= " <tr>
    <td width='6%'>Email: </td>
    <td width='84%'><strong>". $email ."</strong></td>
  </tr>
	<tr>
   <td width='6%'>Teléfono: </td>
    <td width='84%'><strong>". $phone ."</strong></td>
  </tr>
  <tr>
   <td width='6%'>Mensaje: </td>
    <td width='84%'><strong>". $comentario ."</strong></td>
  </tr>
  
  <tr>";
$TxtMensa .= " <td colspan='2'>&nbsp;</td></tr><tr>  <td colspan='2'>Envio desde el sistema Hachewd, version v 3.0</td></tr></table></body></html>";
$mail->Body = $TxtMensa;
 
//$mail->AddAttachment("archivo.zip");//adjuntos un archivo al mensaje
 
if(!$mail->Send()) {//finalmente enviamos el email
   echo $mail->ErrorInfo;//si no se envía correctamente se muestra el error que ocurrió
   include ("contacto_error.php");
		exit;
} else {
  
 /* $dbhost="localhost"; 
	$username="hachewd"; 
	$password="hacheWD2011"; 
	$dbname='hachewd_armatuciudad'; 
$conexion = @mysql_connect($db_host, $username, $password) or die(mysql_error()); 
$db = @mysql_select_db($dbname, $conexion) or die(mysql_error());

$sql="insert into visitantes(Nombre, Email, Emailing) values ('$nombre', '$email','$newsletter')"; 
$result=mysql_query($sql, $conexion);

@mysql_close($conexion); 
     return success;*/
	 header("Location: ../gracias.html");
}
?>