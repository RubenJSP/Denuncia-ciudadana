<?php
	require_once 'userData.php';
	include 'template/header.php';
	require_once 'genInfo.php';

	if(!isset($_SESSION))
 		session_start();

 	$tipo = $datos['tipo'];

 	if($tipo!='2' && !isset($_SESSION['user']))
 		header("Location: index.php");
 	else if($tipo!='2')
 		 header("Location: mapa.php");

function getReports($filtro){
	  	 $dbh = connectDB();
	  	 $query = 'SELECT * FROM denuncias';
	  	 switch ($filtro) {
	  	 	case '0':
	  	 		$query =  'SELECT * FROM denuncias ORDER BY CASE WHEN estatus ="Finalizado" THEN 1 WHEN estatus = "Pendiente" THEN 2 ELSE 3 END';
	  	 		break;
	  	 	case '1':
	  	 		$query = 'SELECT * FROM denuncias ORDER BY fechaRegistro ASC';
	  	 	break;

	  	 	case '2':
	  	 	$query = 'SELECT * FROM denuncias ORDER BY fechaRegistro DESC';
	  	 	break;

	  	 	case '3':
	  	 	$query = 'SELECT * FROM denuncias ORDER BY TIME(fechaRegistro) ASC';
	  	 	break;

	  	 	case '4':
	  	 	$query = 'SELECT * FROM denuncias ORDER BY TIME(fechaRegistro) DESC';
	  	 	break;

	  	 	default:
	  	 		$query = 'SELECT * FROM denuncias ';
	  	 		break;
	  	 	}
           
            $stm = $dbh->prepare($query);
            $stm->setFetchMode(PDO::FETCH_ASSOC);
            $stm->execute();
            $data = '';
            $color = '';
            while($row=$stm->fetch()){
            	$time = strtotime($row['fechaRegistro']);
            	$myFormatForView = date("d/m/y g:i A", $time);
            	$usuario = getGenInfo($row['idUser']);
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
						<li> <b>Usuario:</b> '.$usuario['nombre'].' '.$usuario['apellidoPaterno'].' '.$usuario['apellidoMaterno'].'</li>
						<li><b>Estatus: </b>'. $row['estatus'].'</li>	
						<li> <b>Problema presentado:</b> '.$row['tipo'].'</li>
					</ul>
					<a href="report.php?report='.$row['idDenuncia'] .'" class="btn btn-primary" style ="margin-left: 20px;">Ver más</a>
					
				</div>	
			</div> </div>';
            }

            if(strlen($data)<1)
            	$data = '
            	<div class="alert alert-primary" role="alert" style="margin: 0 auto; width:1000px;">
 				 La lista de reportes está vacía.
				</div>


            	';

            return $data;


	  }


	  function getReportsByUser($name){
	  		$param='';
	  	 	$dbh = connectDB();
	  	 	$query = 'SELECT * FROM denuncias INNER JOIN users ON users.nombre LIKE ? WHERE users.idUser = denuncias.idUser';
	  	 	$param=array("%$name%");
            $stm = $dbh->prepare($query);
            $stm->setFetchMode(PDO::FETCH_ASSOC);
            $stm->execute($param);
            $data = '';
            $color = '';
            while($row=$stm->fetch()){
            	$time = strtotime($row['fechaRegistro']);
            	$myFormatForView = date("d/m/y g:i A", $time);
            	$usuario = getGenInfo($row['idUser']);
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
						<li> <b>Usuario:</b> '.$usuario['nombre'].' '.$usuario['apellidoPaterno'].' '.$usuario['apellidoMaterno'].'</li>
						<li><b>Estatus: </b>'. $row['estatus'].'</li>	
						<li> <b>Problema presentado:</b> '.$row['tipo'].'</li>
					</ul>
					<a href="report.php?report='.$row['idDenuncia'] .'" class="btn btn-primary" style ="margin-left: 20px;">Ver más</a>
					
				</div>	
			</div> </div>';
            }

            if(strlen($data)<1)
            	$data = '
            	<div class="alert alert-primary" role="alert" style="margin: 0 auto; width:1000px;">
 				 La lista de reportes está vacía.
				</div>


            	';

            return $data;


	  }

	  if(isset($_GET['msj'])){
	  	echo'<div style="text-align: center;" class="alert alert-success" role="alert">
		  Se eliminó el registro correctamente.
		</div>';
	  }


 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Admin panel</title>
	    <link rel="stylesheet" href="style.css">
	   	<link rel="stylesheet" href="RegisterStyle.css">
	    <link rel="stylesheet" type="text/css" href="style2.css">

	        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">

</head>
<body>
    <div class="container" style="margin-bottom: 70px;">
		<h4>Filtrar por: </h4>
		<select style="margin:4px 0 10px; height: 40px; width: 50%; border-radius: 5px;" onchange="location = this.value;">
			<option><?php 
				$op='Selecciona una opción';
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
								else if($_GET['filter']=='5')
										$op='Usuario';
					}
						
					echo $op;
			 ?></option>
			<option value="admin.php?filter=0">Estatus</option>
			<option value="admin.php?filter=1">Fecha (Asc)</option>
			<option value="admin.php?filter=2">Fecha(Desc)</option>
			<option value="admin.php?filter=3">Hora (Asc)</option>
			<option value="admin.php?filter=4">Hora (Desc)</option>
			<option value="admin.php?filter=5">Usuario</option>
		</select>
		<?php 
			if(isset($_GET['filter'])){
				$filtro = $_GET['filter'];
				if($_GET['filter']=='5'){
						echo '<form action="" method="POST" style="margin-bottom:10px; width:50%;">
				
				<input class="input-text" type="text" name="nom" placeholder="Nombre" style="width: 100%; margin-bottom: 5px;" required>
				<input class="btn btn-primary" type="submit" name="send" value="Buscar">
				</form>';
				if(isset($_POST['nom'])){
						$n =$_POST['nom'];


						echo getReportsByUser($n);
					}
				
				
				}else
				echo getReports($filtro);
			}
			else
				echo getReports("-1");


		 ?>		
	</div>
	<?php include 'template/footer.php'; ?>
</body>
</html>