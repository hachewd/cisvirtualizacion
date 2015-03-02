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
	
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Reporte de Registros</title>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
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
    <a href="reporte2.php">Reiniciar búsqueda</a>
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
	<?php

		for($i=0;$i<8;$i++){
			//$dia = $i + 1;
			$query = "SELECT count(*) from ivr_bimbo_dic where CURDATE() - $i <= calldate";
			$result = $db->query($query);
			$cuenta = $result->fetch_array();
			$array[] = $cuenta[0];
			//$daytoday =otalDia[$h]);*/
		}
		$totalDias =  count($array);

        $queryT = "SELECT count(id) from ivr_bimbo_dic";
        $resultados = $db->query($queryT);
        $contar = $resultados->fetch_array();
        $totalR = $contar[0];

	?>
  <section id="content">
    <h2>Promo Bimbo</h2>
  	<h2>Gr&aacuteficos</h2>
  
  	
		<script type="text/javascript">
$(function () {
        $('#container').highcharts({
            chart: {
                type: 'areaspline'
            },
            title: {
                text: 'Total de códigos activados últimos 7 días'
            },
            legend: {
                layout: 'vertical',
                align: 'left',
                verticalAlign: 'top',
                x: 150,
                y: 100,
                floating: true,
                borderWidth: 1,
                backgroundColor: '#FFFFFF'
            },
            xAxis: {
                categories: [
                    'Ayer',
                    '2 dias',
                    '3 dias',
                    '4 dias',
                    '5 dias',
                    '6 dias',
                    '7 dias'
                ],
                plotBands: [{ // visualize the weekend
                    from: 4.5,
                    to: 6.5,
                    color: 'rgba(68, 170, 213, .2)'
                }]
            },
            yAxis: {
                title: {
                    text: 'Cantidad x Día'
                }
            },
            tooltip: {
                shared: true,
                valueSuffix: ' codigos'
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                areaspline: {
                    fillOpacity: 0.5
                }
            },
            series: [{
                name: 'Códigos Activados',
                data: [
                <?php for($h=0;$h<$totalDias;$h++){
					$diaA= $h + 1;
					if($diaA < $totalDias){
						$daytoday[] = ($array[$diaA]) - $array[$h];
						echo $daytoday[$h].",";
					}
				} ?>
				]
            }]
        });
    });
    $(function () {
    var chart;
    
    $(document).ready(function () {
        
        // Build the chart
        $('#pieg').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: 'Porcentaje de Activación x diversos medios'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            series: [{
                type: 'pie',
                name: 'Medios de Activación',
                data: [
                    <?php
        $medio[0] = 'web';
        $medio[1] = 'ivr';
        $medio[2] = 'fac';
        for($j=0;$j<sizeof($medio);$j++){
            $mdc= $j+1;
            $search= $medio[$j];
            $busq = "WHERE `ivr_bimbo_dic`.`cust_type` like '%$search%'";
            $queryM = "SELECT count(*) FROM ivr_bimbo_dic $busq";
           /* $queryM= "SELECT count(*) FROM ivr_bimbo_dic WHERE cust_type like $busq";*/
            $res = $db->query($queryM);
            $rows = $res-> fetch_array();
            $medios[] = $rows[0];
            $porcentaje[] = ($medios[$j] * 100) / $totalR;
            echo "['".$medio[$j]."', ".$porcentaje[$j]."],";
        }
     

        ?>
                    /*['Firefox',   45.0],
                    ['IE',       26.8],
                    {
                        name: 'Chrome',
                        y: 12.8,
                        sliced: true,
                        selected: true
                    },
                    ['Safari',    8.5],
                    ['Opera',     6.2],
                    ['Others',   0.7]*/
                ]
            }]
        });
    });
    
});

		</script>
	</head>
	<body>
<script src="js/js/highcharts.js"></script>
<script src="js/js/modules/exporting.js"></script>

<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
 <div id="pieg" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
 <div id="error">
 </div>
</section>
</body>
</html>
