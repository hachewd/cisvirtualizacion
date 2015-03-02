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
	header("Content-type: application/vnd.ms-excel" ) ;
	header("Content-Disposition: attachment; filename=CodActivados_".$_GET['search'].".xls" ) ;
	$tamano_paginador = 600;
	$total_registros = 0;
	
	$search = "";
	$search_sql = "";
	if (isset($_GET['search'])) {
		//$search = mysql_real_escape_string($_GET['search']);
		$search =$_GET['search'];
		$search_sql = "WHERE
			`ivr_bimbo_dic`.`cust_cedula` like '%$search%' or
			`ivr_bimbo_dic`.`cust_pasporte` like '%$search%' or
			`ivr_bimbo_dic`.`cust_telefono` like '%$search%' or
			`ivr_bimbo_dic`.`cust_promo_cod` like '%$search%' or
			`ivr_bimbo_dic`.`cust_residencia` like '%$search%' or
			`ivr_bimbo_dic`.`cust_type` like '%$search%' or
			`ivr_bimbo_dic`.`calldate` like '%$search%' or
			`ivr_bimbo_dic`.`cust_nombre` like '%$search%' or
			`ivr_bimbo_dic`.`cust_apellido` like '%$search%' or
			`ivr_bimbo_dic`.`cust_edad` like '%$search%' or
			`ivr_bimbo_dic`.`cust_email` like '%$search%'";
	}
	/*if (isset($_GET['start'])) {
		//$start = addslashes($_GET['start']);
		$start = $_GET['start'];
		
		//$end = $tamano_paginador;
		$end = addslashes($tamano_paginador);
		//$query = "SELECT * FROM ivr_bimbo_dic $search_sql ORDER BY calldate desc limit $start, 350";
		$query = "SELECT * from ivr_bimbo_dic $search_sql limit $start, $end";
		$result = $db->query($query);
	}*/
	/*else
	{
		$query ="SELECT * FROM ivr_bimbo_dic $search_sql ORDER BY calldate desc limit 0, $tamano_paginador ";
		$result = $db->query($query);
	}*/
	$query ="SELECT id, cust_cedula, cust_pasporte, cust_telefono, cust_promo_cod, cust_residencia, cust_type, calldate, cust_nombre, cust_apellido, cust_edad, cust_email FROM ivr_bimbo_dic $search_sql";
	$result = $db->query($query);

	$queryC = "SELECT count(*) FROM ivr_bimbo_dic $search_sql"; //$search_sql";
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

<section id="main">

  <section id="content">
  	<h2>Reporte completo</h2>

  <span class="resultados">Página <?php echo $pagina_actual?> (Total: <?php echo $total_registros?> Registros)</span>
 
    <table cellpadding="5" cellspacing="0">
    	
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
   
  </section>
</section>
</body>
</html>
