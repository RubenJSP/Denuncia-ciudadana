<?php
      require_once 'conection.php';

      function getGenInfo($id){
            $dbh = connectDB();
            $query = 'SELECT * FROM users WHERE idUser = :idUser';
            $stm = $dbh->prepare($query);
            $stm->setFetchMode(PDO::FETCH_ASSOC);
            $stm->bindParam(':idUser', $id);
            $stm->execute();
            $data = $stm->fetch();
            return $data;
    }

?>