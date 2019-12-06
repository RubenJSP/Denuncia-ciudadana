<?php
	require ('conection.php');

	session_start();
	//$datos = array();
		function getUser($mail) 
			{
			$dbh = connectDB();
			$query = 'SELECT * FROM users WHERE eMail = :mail';
			$stm = $dbh->prepare($query);
			$stm->setFetchMode(PDO::FETCH_ASSOC);
			$stm->bindParam(':mail', $mail);
			$stm->execute();
			$data = $stm->fetch();
			header('Content-Type: application/json');
			echo json_encode($data);
		}
		if(isset($_POST['login'])) {
			$mail = $_POST['mail'];
			getUser($mail);
			$_SESSION['user'] = $mail;
		}
?>

