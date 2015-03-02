<?php
	session_start();
	if (!isset($_SESSION['usuario'])) {
		if (isset($_POST['usuario'])) {
			if($_POST['usuario'] == "promo_epa") {
				$_SESSION['usuario'] = true;

			}
			else{
				header("Location:login.php?e=1");
				die();
			}
		}
		else
		{
			header("Location:login.php?e=1");
			die();
		}
	}


	include_once "../db_conn.php";
	
	$tamano_paginador = 600;
	
	$total_registros = 0;
	
	$search = "";
	$search_sql = "";

	
	if (isset($_GET['rango'])) {
		//$rango = mysql_real_escape_string($_GET['rango']);
		$rango = $_GET['rango'];
		//$search =$_GET['search'];
		$search_sql = "where CURDATE() - $rango <= calldate";
	}
	else{
		$search_sql = "";
		$rango= "";
	}

	if (isset($_GET['start'])) {
		$start = $_GET['start'];
		$end = $tamano_paginador;
		$query = "SELECT * from ivr_bimbo_dic $search_sql limit $start, $end";
		$result = $db->query($query);
	}
	else
	{
		$query ="SELECT * from ivr_bimbo_dic $search_sql limit 0, $tamano_paginador";
		$result = $db->query($query);
	}
	$queryC = "SELECT count(*) FROM ivr_bimbo_dic $search_sql";
	$contar= $db->query($queryC);
	$cuenta_registros = $contar->fetch_array();
	$total_registros = $cuenta_registros[0];


	$pagina_actual = !isset($_GET['start']) || $_GET['start'] == 0 ? 1 : (($_GET['start'])/$tamano_paginador)+1;
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Reporte de Registros</title>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/reportes.css"/>

<script>
</script>
</head>
<body>
<header>
  <section class="contenido"> 
  	<section class="busqueda"><form name="buscar" method="get" class="form_buscar">
  		<label>Filtrar:</label>
      <select name="rango" id="rango">
      	<option>Seleccion un rango</option>
      	<option value="10">1 1/5 Semana</option>
      	<option value="6">1 Semana</option>
      	<option value="5">6 d&iacute;as</option>
      	<option value="4">5 d&iacute;as</option>
      	<option value="3">4 d&iacute;as</option>
      	<option value="2">3 d&iacute;as</option>
      	<option value="1">2 d&iacute;as</option>
      	<option value="0">Hoy</option>
      </select>
      <input type="submit" value="Buscar" />
    </form>
    <a href="rangos.php">Reiniciar búsqueda</a>
</section>
    <nav>
		<ul>
			<li><a href="reporte2.php">Reporte Completo y B&uacute;squedas</a></li>
			<li><a href="rangos.php">Filtra dias recientes</a></li>
			<li><a href="graficos.php">gr&aacute;ficos</a></li>
		</ul>
	</nav>
</section>
  </header>
<section id="main">
	<h2>Promo Bimbo</h2>
  <section id="content">
  	<h2>B&uacute;squeda por periodo de tiempo</h2>
  <?php
  if ($rango != ""){
  ?>
  <a href="exportar_rango.php?rango=<?php echo $_GET['rango'] ?>">Exportar a Excel</a>
  <?php
  }
  else {
  ?>
  <a href="exportar_rango.php">Exportar a Excel</a>
  <?php
  }
  ?>
  <div class="tituloSec"><h3>los pr&oacute;ximos <?php echo $rango ?> días</h3></div>
  <span class="resultados">Página <?php echo $pagina_actual?> (Total: <?php echo $total_registros?> Registros)</span>
  <section class="paginador"><?php
$search_pag = "";
if (isset($_GET['rango'])) {
	$search_pag = "&rango=".$_GET['rango'];
}
for ($i = 0; $i <= $total_registros/$tamano_paginador; $i++) {
	$selected = "";
	if (isset($_GET['start']) && $_GET['start']==$i*$tamano_paginador) {
		$selected = " style=\"color:#000;\"";
	}
	else
	{
		$selected = "";
	}
	echo '<a href="rangos.php?start='.($i*$tamano_paginador).$search_pag.'"'.$selected.'>'.($i+1).'</a>';
}
?></section>
    <table cellpadding="5" cellspacing="0">
    	
</tr>
      <tr class="fondo_header">
        <td width="5%">ID</td>
        <td width="6%">Cédula</td>
        <td width="6%">Passporte</td>
        <td width="8%">Codigo</td>
        <td width="12%">Fecha / Hora</td>
        <td width="10%">Nombre</td>
        <td width="10%">Apellido</td>
        <td width="13%">Email</td>
        <td width="10%">Teléfono</td>
        <td width="5%">edad</td>
        <td width="10%">Residencia</td>
        <td width="5%">Tipo</td>
      </tr>
      <?php
	  $i = 0;
while ($r = $result->fetch_array()){
	echo '<tr>';
	echo '<td>'.$r['id'].'</td>';
	echo '<td>'.$r['cust_cedula'].'</td>';
	echo '<td>'.$r['cust_pasporte'].'</td>';
	echo '<td>'.$r['cust_promo_cod'].'</td>';
	echo '<td>'.date('d-m-Y H:m:s', strtotime($r['calldate'])).'</td>';
	echo '<td>'.utf8_encode(trim($r['cust_nombre'])).'</td>';
	echo '<td>'.utf8_encode(trim($r['cust_apellido'])).'</td>';
	echo '<td>'.$r['cust_email'].'</td>';
	echo '<td>'.$r['cust_telefono'].'</td>';
	echo '<td>'.$r['cust_edad'].'</td>';
	echo '<td>'.utf8_encode(trim($r['cust_residencia'])).'</td>';
	echo '<td>'.$r['cust_type'].'</td>';
	echo '</tr>';
	$i++;
}
?>

    </table>
    <section class="paginador"><?php
$search_pag = "";
if (isset($_GET['rango'])) {
	$search_pag = "&rango=".$_GET['rango'];
}
for ($i = 0; $i <= $total_registros/$tamano_paginador; $i++) {
	$selected = "";
	if (isset($_GET['start']) && $_GET['start']==$i*$tamano_paginador) {
		$selected = " style=\"color:#000;\"";
	}
	else
	{
		$selected = "";
	}
	echo '<a href="rangos.php?start='.($i*$tamano_paginador).$search_pag.'"'.$selected.'>'.($i+1).'</a>';
}
?></section>
  </section>
</section>
</body>
</html>
