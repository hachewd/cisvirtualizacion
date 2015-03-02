<?php
			//incluimos la clase PHPMailer
			require_once('PHPMailer/class.phpmailer.php');

			//instancio un objeto de la clase PHPMailer
			$mail = new PHPMailer(); // defaults to using php "mail()"
			$mail->isMail();//usamos Sendmail, también podemos usar mail() con isMail()

	if (isset($_POST) && !empty($_POST)) {
		
		//validación de datos
		$error = array();
		
		//$con = mysql_connect(SERVER, USERNAME, PASSWORD) or die(mysql_error());
		$i = 0;
		$keys = array_keys($_POST);
		for ($i; $i < sizeof($keys); $i++){
			$_POST[$keys[$i]] = utf8_decode(strip_tags(addslashes($_POST[$keys[$i]])));
		}
		
		/*$pasaporte = false;
		if (strlen($_POST['cedula'])>9) {
			$pasaporte = true;
		}*/
		
		if ($_POST['espacio'] == "") {
			$error["espacio"] = "Seleccione un espacio";
		}
		if ($_POST["memoria"] == "") {
			$error["memoria"] = "Seleccione la memoria";
		}
		if ($_POST["anchobanda"] == "") {
			$error["anchobanda"] = "Seleccione el ancho de banca";
		}
		if ($_POST["procesamiento"] == "") {
			$error["procesamiento"] = "Seleccione el procesador";
		}
		if ($_POST["sistemaoperativo"] == "") {
			$error["sistemaoperativo"] = "Seleccione el sistema operativo";
		}
		if ($_POST["email"] == "") {
			$error["email"] = "Ingrese su e-mail";
		}
		else {
			if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
				$error["email"] = "Email inválido";
			}
		}
		
		if (count($error)>0){
			die(json_encode($error));
		}
		else
		{
			$body = '
			<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<table width="800" border="0" align="center" cellspacing="0" cellpadding="0">
		<tbody>
	
			<tr>
				<td style="line-height:0;"><a href="http://cis-solutions.com/" target="_new"><img src="http://www.cis-solutions.com/promociones/email/images/cis_virtualizacion_01.jpg" alt="cis-virtualizacion"></a></td>
			</tr>
		
			
			<tr height="40">
				
			</tr>

			<tr>
				<td style="display:block;">
					<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0">
						<tbody>
							<tr>
								<td></td>
								<td style="color:#545454;font-family: arial, helvetica, sans-serif; font-size:16px;">Solicitud enviada por: '.$_POST['email'].'</td>
								<td></td>
							</tr>
							<tr>
								<td></td>
								<td height="50" style="color:#545454;font-family: arial, helvetica, sans-serif; font-size:25px;">Configuraci&oacute;n del servidor</td>
								<td></td>
							</tr>
							<tr>
								<td width="44"></td>
								<td><img src="http://www.cis-solutions.com/promociones/email/images/cis_virtualizacion_09.jpg" alt="cis-virtualizacion"></td>
								<td width="34"></td>
							</tr>
							<tr>
								<td></td>
								<td>
									<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0">
										<tbody>
											<tr>
												<td width="41" height="32"><img src="http://www.cis-solutions.com/promociones/email/images/cis_virtualizacion_check.jpg" alt="cis-virtualizacion"></td>
												<td width="682" style="color:#545454;font-family: arial, helvetica, sans-serif; font-size:16px;">'.$_POST['espacio'].'</td>
											</tr>
											<tr>
												<td width="41" height="32"><img src="http://www.cis-solutions.com/promociones/email/images/cis_virtualizacion_check.jpg" alt="cis-virtualizacion"></td>
												<td width="682" style="color:#545454;font-family: arial, helvetica, sans-serif; font-size:16px;">'.$_POST['memoria'].'</td>
											</tr>
											<tr>
												<td width="41" height="32"><img src="http://www.cis-solutions.com/promociones/email/images/cis_virtualizacion_check.jpg" alt="cis-virtualizacion"></td>
												<td width="682" style="color:#545454;font-family: arial, helvetica, sans-serif; font-size:16px;">'.$_POST['anchobanda'].'</td>
											</tr>
											<tr>
												<td width="41" height="32"><img src="http://www.cis-solutions.com/promociones/email/images/cis_virtualizacion_check.jpg" alt="cis-virtualizacion"></td>
												<td width="682" style="color:#545454;font-family: arial, helvetica, sans-serif; font-size:16px;">'.$_POST['procesamiento'].'</td>
											</tr>
											<tr>
												<td width="41" height="32"><img src="http://www.cis-solutions.com/promociones/email/images/cis_virtualizacion_check.jpg" alt="cis-virtualizacion"></td>
												<td width="682" style="color:#545454;font-family: arial, helvetica, sans-serif; font-size:16px;">'.$_POST['sistemaoperativo'].'</td>
											</tr>
										</tbody>
									</table>

								</td>
								<td></td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td style="display:block; line-height:0;" height="79"></td>
			</tr>
			<tr>
				<td style="display:block; line-height:0;"><img src="http://www.cis-solutions.com/promociones/email/images/cis_virtualizacion_15.jpg" alt="17"></td>
			</tr>
			<tr>
				<td style="display:block; line-height:0;" height="15"></td>
			</tr>
			<tr>
				<td style="display:block; line-height:0;">
					<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0">
						<tbody>
							<tr>
								<td><img src="http://www.cis-solutions.com/promociones/email/images/cis_virtualizacion_17.jpg" alt="10"></td>
								<td>
									<table border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td colspan="2"><img src="http://www.cis-solutions.com/promociones/email/images/cis_virtualizacion_18.jpg" alt="10"></td>
									</tr>
									<tr>
										<td><a href="https://www.facebook.com/CisSolutions" target="_new"><img src="http://www.cis-solutions.com/promociones/email/images/cis_virtualizacion_23.jpg" alt="10" border="0"></a></td>
										<td><a href="https://twitter.com/CISSolutions" target="_new"><img src="http://www.cis-solutions.com/promociones/email/images/cis_virtualizacion_24.jpg" alt="10" border="0"></a></td>
									</tr>
								</table>
								</td>
								<td><img src="http://www.cis-solutions.com/promociones/email/images/cis_virtualizacion_19.jpg" alt="12"></td>
								<td><a href="http://cis-solutions.com" target="_new"><img src="http://www.cis-solutions.com/promociones/email/images/cis_virtualizacion_20.jpg" alt="13" border="0"></a></td>
								<td><a href="http://www.grupo-garnier.com/?lang=en" target="_new"><img src="http://www.cis-solutions.com/promociones/email/images/cis_virtualizacion_21.jpg" alt="14" border="0"></a></td>
								<td><img src="http://www.cis-solutions.com/promociones/email/images/cis_virtualizacion_22.jpg" alt="15"></td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td style="display:block; line-height:0;" height="15"></td>
			</tr>
		</tbody>
	</table>
</body>
</html>
			';
			/*$mail->IsSMTP();  
			$mail->Host     = "mail.hachewd.com";  
			//$mail->From     = "info@hachewd.com";
			$mail->SMTPAuth = true; 
			$mail->Username ="info@hachewd.com"; 
			$mail->Password="Prisma@2308"; */

			$mail->SetFrom('sales@cis-solutions', 'Sales Cis');
			$address = "hachewd@gmail.com";
			$mail->AddAddress($address, "Hache Web & Design");
			$mail->Subject = 'Cotizacion servidor virtual CIS CLOUD';
			
			$mail->MsgHTML($body);
			if(!$mail->Send()) {//finalmente enviamos el email
				die(json_encode(array($mail->ErrorInfo)));
			   //echo $mail->ErrorInfo;//si no se envía correctamente se muestra el error que ocurrió
			   //include ("contacto_error.php");
				exit;
			} else {
				die(json_encode(array('resultado'=>1)));
			}

		}
		
		//die(json_encode(array('resultado'=>1)));
		
	}
?>