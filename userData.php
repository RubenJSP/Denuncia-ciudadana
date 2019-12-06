<?php
    require_once ('conection.php');
  if(!isset($_SESSION)) 
    { 
        session_start();
    }    
    $datos;
    
   function getUserInfo($mail){
            $dbh = connectDB();
            $query = 'SELECT * FROM users WHERE eMail = :mail';
            $stm = $dbh->prepare($query);
            $stm->setFetchMode(PDO::FETCH_ASSOC);
            $stm->bindParam(':mail', $mail);
            $stm->execute();
            $data = $stm->fetch();
            return $data;

    }
    
    if(isset($_SESSION['user'])){
        $mail= $_SESSION['user'];
    
    $datos = getUserInfo($mail);
    }



?>