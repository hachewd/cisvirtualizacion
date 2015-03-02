<?php
	include_once "db_conn.php";
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
			$fecha = date('Y-m-d H:i:s'); //inicializo la fecha con la hora
			$nuevafecha= strtotime ( '+2 hour' , strtotime($fecha)) ;
		  	$nuevafecha = date ( 'Y-m-d H:i:s' , $nuevafecha );
			  
			
			$query = "INSERT INTO `virtualizacion1`(`correo`, `espacio`, `memoria`, `anchobanda`, `procesamiento`, `os`, `fecha`) VALUES ('".$_POST['email']."','".$_POST['espacio']."','".$_POST['memoria']."','".$_POST['anchobanda']."','".$_POST['procesamiento']."','".$_POST['sistemaoperativo']."','".$nuevafecha."')";//'".date('Y-m-d H:i:s', time())."')";

			mysql_select_db(DATABASE, $con);
			mysql_query($query, $con);

			$para  = 'sales@cis-solutions.com'; //'sales@cis-solutions.com' . ',' . 'hmata@hachedesign.com'; // atención a la coma
			// subject
			$titulo = 'Cotización servidor virtual CIS CLOUD';
			// message
			$mensaje = '
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

			// Para enviar un correo HTML mail, la cabecera Content-type debe fijarse
			$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
			$cabeceras .= 'Content-type: text/html; charset=UFT-8' . "\r\n";

			// Cabeceras adicionales
			//$cabeceras .= 'To:'.$_POST["email"]. "\r\n";
			$cabeceras .= 'From: sales@cis-solutions.com'. "\r\n";//sales@cis-solutions.com
			$cabeceras .= 'BCC: Hanzel Mata  <hachewd@gmail.com>' . "\r\n";


			// Mail it
			//mail($para, $titulo, $mensaje, $cabeceras);

			if(mail($para, $titulo, $mensaje, $cabeceras))
		      {
		      		//si envio
		      }
		      else
		      {
		      	$error["enviar"] = "Email no enviado";
		      	die(json_encode($error));
		      }

		}
		mysql_close($con);
		die(json_encode(array('resultado'=>1)));
		
	}
?>