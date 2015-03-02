
<?php
	define('SERVER', "192.168.113.7");
	define('USERNAME', "promo");
	define('PASSWORD', 'Promo2015');
	define('DATABASE', 'promociones');
	header ('Content-type: text/html; charset=utf-8');
	$con = mysql_pconnect(SERVER, USERNAME, PASSWORD) or die("No hay conexión a la base de datos: ".mysql_error());
	mysql_select_db(DATABASE, $con);

/*define('SERVER', "192.186.241.98");
	define('USERNAME', "cis");
	define('PASSWORD', 'O7~*Dg*#*pHN');
	define('DATABASE', 'cisvirtualizacion');
	header ('Content-type: text/html; charset=utf-8');
	$con = mysql_pconnect(SERVER, USERNAME, PASSWORD) or die("No hay conexión a la base de datos: ".mysql_error());
	mysql_select_db(DATABASE, $con);
*/