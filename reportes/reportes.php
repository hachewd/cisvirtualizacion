<?php
	session_start();
	if (!isset($_SESSION['usuario'])) {
		if (isset($_POST['usuario'])) {
			if($_POST['usuario'] == "ciscloud") {
				$_SESSION['usuario'] = true;
			}
			else{
				header("Location:index.php?e=1");
				die();
			}
		}
		else
		{
			header("Location:index.php?e=1");
			die();
		}	
	}

	include_once "db_conn.php";
	
	$tamano_paginador = 50;
	
	$total_registros = 0;
	
	$search = "";
	$search_sql = "";
	if (isset($_GET['search'])) {
		//$search = mysql_real_escape_string($_GET['search']);
		$search =$_GET['search'];
		$search_sql = "WHERE
			`virtualizacion1`.`correo` like '%$search%' or
			`virtualizacion1`.`espacio` like '%$search%' or
			`virtualizacion1`.`memoria` like '%$search%' or
			`virtualizacion1`.`anchobanda` like '%$search%' or
			`virtualizacion1`.`procesamiento` like '%$search%' or
			`virtualizacion1`.`os` like '%$search%'";
	}
	if (isset($_GET['start'])) {
		//$start = addslashes($_GET['start']);
		$start = $_GET['start'];
		//$end = $tamano_paginador;
		$end = addslashes($tamano_paginador);
		//$query = "SELECT * FROM registro $search_sql ORDER BY calldate desc limit $start, 350";
		$query = "SELECT * from virtualizacion1 $search_sql limit $start, $end";
		$result = $db->query($query);
	}
	else
	{
		$query ="SELECT * FROM virtualizacion1 $search_sql limit 0, $tamano_paginador";
		$result = $db->query($query);
	}
	$queryC = "SELECT count(*) FROM virtualizacion1 $search_sql"; //$search_sql";
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
  <section class="contenido"> <section class="busqueda"> 
   	<form name="buscar" method="get" class="form_buscar">
    	<label>Buscar:</label>
      <input type="text" name="search" id="busqueda" placeholder="Buscar..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : '';?>" />
      <input type="submit" value="Buscar" />
    </form>
    <a href="reportes.php">Reiniciar b&uacute;squeda</a>
</section>
    <nav>
		<ul>
			<li><a href="reportes.php">Cotizaciones</a></li>
		</ul>
	</nav>
</section>
  </header>	
<section id="main">
	<h2>Cotizaciones Cis-Cloud</h2>
  <section id="content">
  	<h2>Configuraciones</h2>
  <?php
  if ($search != ""){
  ?>
  <!--<a href="exportar.php?search=<?php echo $search; ?>">Exportar a Excel</a>-->
  <?php
  }
  else {
  ?>
  <!--<a href="exportar.php">Exportar a Excel</a>-->
  <?php
  }
  ?>

  <span class="resultados">P&aacute;gina <?php echo $pagina_actual?> (Total: <?php echo $total_registros?> Registros)</span>
  <section class="paginador">
  	Pagina:
  	<?php
$search_pag = "";
if (isset($_GET['search'])) {
	$search_pag = "&search=".$_GET['search'];
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
	echo '<a href="reportes.php?start='.($i*$tamano_paginador).$search_pag.'"'.$selected.'>'.($i+1).'</a>';

}

?>
  </section>
    <table cellpadding="5" cellspacing="0" width="100%">
    	
      <tr class="fondo_header">
        <td width="16%">Correo</td>
        <td width="14%">Espacio</td>
        <td width="14%">Memoria</td>
        <td width="14%">Anchobanda</td>
        <td width="14%">Procesamiento</td>
        <td width="14%">OS</td>
        <td width="14%">Fecha</td>
      </tr>
      <?php
	  $i = 0;
while ($r = $result->fetch_array()){
	echo '<tr>';
	echo '<td>'.$r['correo'].'</td>';
	echo '<td>'.$r['espacio'].'</td>';
	echo '<td>'.$r['memoria'].'</td>';
	echo '<td>'.$r['anchobanda'].'</td>';
	echo '<td>'.$r['procesamiento'].'</td>';
	echo '<td>'.$r['os'].'</td>';
	echo '<td>'.date('d-m-Y h:i:s a', strtotime($r['fecha'])).'</td>';
	echo '</tr>';
	$i++;
}
?>

    </table>
    <section class="paginador">
  	<?php
$search_pag = "";
if (isset($_GET['search'])) {
	$search_pag = "&search=".$_GET['search'];
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
	echo '<a href="reportes.php?start='.($i*$tamano_paginador).$search_pag.'"'.$selected.'>'.($i+1).'</a>';
}

?>
  </section>
  <?php 
  $fecha = date('Y-m-j H:i:s'); //inicializo la fecha con la hora
  $nuevafecha= strtotime ( '+2 hour' , strtotime($fecha)) ;
  $nuevafecha = date ( 'Y-m-j h:i:s a' , $nuevafecha );
  echo $nuevafecha;
    ?>
  </section>
</section>
</body>
</html>