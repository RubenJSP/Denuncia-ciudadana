<?php
  require_once 'conection.php';
  /*function getReports(){
       $dbh = connectDB();
       $query = 'SELECT * FROM denuncias';
           $stm = $dbh->prepare($query);
           $stm->setFetchMode(PDO::FETCH_ASSOC);
           $stm->execute();
           $data = $stm->fetch();
          return json_encode($data);
    }*/

    function getReports(){
       $dbh = connectDB();
       $query = 'SELECT * FROM denuncias';
           
            $stm = $dbh->prepare($query);
            $stm->setFetchMode(PDO::FETCH_ASSOC);
            $stm->execute();
            $data = $stm->fetchAll();
            header('Content-Type: application/json');
            return json_encode($data);
    }

    if(isset($_POST['flag'])) {
        $datos = getReports();
        echo $datos;

    }
?>