<?php include('template/header.php');
  	  require_once 'conection.php';
	  require_once 'userData.php';
	if(!isset($_SESSION['user'])) 
    { 
       header("Location: index.php");
    }
    if(!isset($_SESSION))
 		session_start();

		
	  $id = $datos['idUser'];


	  function getReports($id, $filtro){
	  	 $dbh = connectDB();
	  	 $query = 'SELECT * FROM denuncias WHERE idUser = :idUser';
	  	 switch ($filtro) {
	  	 	case '0':
	  	 		$query =  'SELECT * FROM denuncias WHERE idUser = :idUser ORDER BY CASE WHEN estatus ="Finalizado" THEN 1 WHEN estatus = "Pendiente" THEN 2 ELSE 3 END';
	  	 		break;
	  	 	case '1':
	  	 		$query = 'SELECT * FROM denuncias WHERE idUser = :idUser ORDER BY fechaRegistro ASC';
	  	 	break;

	  	 	case '2':
	  	 	$query = 'SELECT * FROM denuncias WHERE idUser = :idUser ORDER BY fechaRegistro DESC';
	  	 	break;

	  	 	case '3':
	  	 	$query = 'SELECT * FROM denuncias WHERE idUser = :idUser ORDER BY TIME(fechaRegistro) ASC';
	  	 	break;

	  	 	case '4':
	  	 	$query = 'SELECT * FROM denuncias WHERE idUser = :idUser ORDER BY TIME(fechaRegistro) DESC';
	  	 	break;

	  	 	default:
	  	 		$query = 'SELECT * FROM denuncias WHERE idUser = :idUser';
	  	 		break;
	  	 	}
           
            $stm = $dbh->prepare($query);
            $stm->setFetchMode(PDO::FETCH_ASSOC);
            $stm->bindParam(':idUser', $id);
            $stm->execute();
            $data = '';
            $color = '';
            //var_dump($data);
            while($row=$stm->fetch()){
            	$time = strtotime($row['fechaRegistro']);
            	$myFormatForView = date("d/m/y g:i A", $time);
            	if($row['estatus'] == 'Cancelado')
            		$color = 'style="background-color: #dc3546;"';
            	else if($row['estatus'] == 'Finalizado')
            		$color = 'style="background-color: #27a844;"';
            	else 
            		$color='';

            	$data .='<div class="report">
			<div class="report-title" '.$color.'> Reporte - '.$myFormatForView.'</div>
			<div class="body-cont">
				<input name="'.$row['idDenuncia'].'" type="hidden">
				<div class="img-View"><img src="uploaded_files/'.$row['img'].'"></div>
				<div class="info-cont">	
					<ul>
						<li>Estatus: '. $row['estatus'].'</li>	
						<li> Problema presentado: '.$row['tipo'].'</li>
					</ul>
					<a href="report.php?report='.$row['idDenuncia'] .'" class="btn btn-primary" style ="margin-left: 20px;">Ver más</a>
					
				</div>	
			</div> </div>';
            }

            return $data;


	  }

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Mis reportes</title>
	<link rel="stylesheet" type="text/css" href="style2.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<div class="container" style="margin-bottom: 70px;">
		<h4>Filtrar por: </h4>
		<select style="margin:4px 0 10px; height: 40px; width: 50%; border-radius: 5px;" onchange="location = this.value;">
			<option><?php 
				$op=''; 
				if(isset($_GET['filter'])){
					if($_GET['filter']=='0')
						$op='Estatus';
					else if($_GET['filter']=='1')
						$op='Fecha (Asc)';
						else if($_GET['filter']=='2')
							$op='Fecha (Desc)';
							else if($_GET['filter']=='3')
								$op='Hora (Asc)';
								else if($_GET['filter']=='4')
									$op='Hora (Desc)';
					}else
					$op='Selecciona una opción';
			
			echo $op;

			 ?></option>
			<option value="reportes.php?filter=0">Estatus</option>
			<option value="reportes.php?filter=1">Fecha (Asc)</option>
			<option value="reportes.php?filter=2">Fecha(Desc)</option>
			<option value="reportes.php?filter=3">Hora (Asc)</option>
			<option value="reportes.php?filter=4">Hora (Desc)</option>
		</select>
		<a href="reportes.php"></a>
		<?php 
			if(isset($_GET['filter']))
				$filtro = $_GET['filter'];
			else
				$filtro = '-1';

			echo getReports($id, $filtro);


		 ?>		
	</div>
	<?php include 'template/footer.php'; ?>
</body>
</html>