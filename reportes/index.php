<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gan&aacute; una de las 100 Cenas Navide&ntilde;as</title>

<link rel="stylesheet" type="text/css" href="css/reportes.css"/>
<link rel="stylesheet" type="text/css" href="../css/all-style.css"/>
</head>
<body>
<section class="login">
	<section class="logopromo"><img src="../images/logo_cishosting.png"/></section>
  <section class="formLogin">
  <p>Ingrese los datos solicitados</p>
  <form action="reportes.php" method="post" id="login" name="login">
   	<label>Usuario</label><br/>
      <input type="text" name="usuario" placeholder="Ingrese el usuario"/><br/><a href="javascript:void(0);" onclick="login.submit();" class="btnlogin">Ingresar</a>
      <?php
	  if (isset($_GET['e'])) {
	  ?>     
      <?php
	  }
	  ?>
      </form>
  </section>
</section>
</body>
</html>