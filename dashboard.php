<?php
	require_once 'conection.php';
	include 'template/header.php';

	function getReports(){
	  	 $dbh = connectDB();
	  	 $query = 'SELECT * FROM denuncias';
           $stm = $dbh->prepare($query);
           $stm->setFetchMode(PDO::FETCH_ASSOC);
           $stm->execute();
           $data = $stm->fetch();
           if(!isset($data))
            	$data = '
            	<div class="alert alert-primary" role="alert" style="margin: 0 auto; width:1000px;">
 				 La lista de reportes está vacía.
				</div>
            	';

            return $data;
	  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Dashboard</title>
	<!-- stylesheets -->
	<link href="assets/fonts/font-roboto.css" rel="stylesheet">
	<link href="assets/bootstrap/bootstrap4-alpha3.min.css" rel="stylesheet">
	<link href="assets/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<link href="assets/web-analytics/style.css" rel="stylesheet">

	<!-- scripts -->
	<script src="assets/jquery/jquery-3.1.0.min.js"></script>
	<script src="assets/tether/tether.min.js"></script>
	<script src="assets/bootstrap/bootstrap4-alpha3.min.js"></script>
	<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
	<script src="assets/web-analytics/overview.js"></script>

</head>

<body style="padding-top: 0;">	
<div style="width: 100%;">
	<!-- page-content-wrapper -->
		<div style="margin-top: 0;">

			<!-- 1st row -->
			<div class="row m-b-1">
				<div class="col-md-12">
					<div class="card card-block">
						<h4 class="card-title m-b-2">Reportes registrados <span class="tag m-l-1" id="revenue-tag"></span></h4>
						<div id="revenue-spline-area-chart"></div>
					</div>
				</div>
			</div>
			<!-- /1st row -->

			<!-- 2nd row -->
			<div class="row m-b-1">
				<div class="col-md-12">
					<div class="card card-block">
						<h4 class="card-title m-b-2">Estatus de los reportes</h4>
						<span class="tag custom-tag hidden-sm-down">Haga clic en un segmento</span>
						<div class="row">
							<div class="col-md-4">
								<div id="annual-revenue-by-category-pie-chart"></div> -->
							</div>
							<div class="col-md-8 hidden-sm-down">
								<div id="monthly-revenue-by-category-column-chart"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /2nd row -->
		</div>
		<!-- /.container-fluid -->


	<!-- /page-content-wrapper -->
</div>
<script type="text/javascript">
	document.getElementById('revenue-tag').innerHTML = 'Total: ' + datos.length;
</script>
</body>

</html>