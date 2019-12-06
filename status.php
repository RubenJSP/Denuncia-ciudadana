<?php
	require_once 'conection.php';
	if(!isset($_SESSION))
 		session_start();
	require_once ('conection.php');
	
	if(!isset($_SESSION['user'])) 
    { 
       header("Location: index.php");
    }


	function setStatus($estatus, $idDenuncia){
	  	 $dbh = connectDB();
            $query = 'UPDATE denuncias SET estatus = :estatus WHERE idDenuncia = :idDenuncia';
            $stm = $dbh->prepare($query);
            $stm->setFetchMode(PDO::FETCH_ASSOC);
            $stm->bindParam(':idDenuncia', $idDenuncia);
            $stm->bindParam(':estatus', $estatus);
            $stm->execute();
        }

     function deleteMsj($idDenuncia){
     	$dbh = connectDB();
            $query = 'DELETE FROM comentarios WHERE idDenuncia = :idDenuncia';
            $stm = $dbh->prepare($query);
            $stm->setFetchMode(PDO::FETCH_ASSOC);
            $stm->bindParam(':idDenuncia', $idDenuncia);
            $stm->execute();
     }
	function deleteReport($idDenuncia){
	  	 $dbh = connectDB();
            $query = 'DELETE FROM denuncias WHERE idDenuncia = :idDenuncia';
            $stm = $dbh->prepare($query);
            $stm->setFetchMode(PDO::FETCH_ASSOC);
            $stm->bindParam(':idDenuncia', $idDenuncia);
            $stm->execute();
        }
		$idDenuncia = $_SESSION['actual'];
		$msj = '';
		if(isset($_GET['end'])){
			$estatus = $_GET['end'];
			setStatus($estatus,$idDenuncia);
			$msj='&msj=1';
		}

		if(isset($_GET['cancel'])){
			$estatus = $_GET['cancel'];
			$msj='&msj=2';
			setStatus($estatus,$idDenuncia);
		}

		if(isset($_GET['delete'])){
			deleteMsj($idDenuncia);
			deleteReport($idDenuncia);
			echo $idDenuncia;
			
			header("Location: admin.php?msj=3");	
		}

	
		if(!isset($_GET['delete']))
       header("Location: report.php?report=".$idDenuncia.$msj);	




?>